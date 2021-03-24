<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Team;
use Illuminate\Console\Command;

class ImportChallengesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't13:import-challenges {csv}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import or update csv challenges';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $author_id = $this->authorId();
        $bannerGetter = $this->bannerGetter();
        $categoryGetter = $this->categoryGetter();

        $path = $this->argument('csv');
        $handle = fopen($path, 'r');

        // skip 3 first header lines
        fgetcsv($handle);
        fgetcsv($handle);
        fgetcsv($handle);

        $inserted = 0;
        while (!feof($handle)) {
            $line =fgetcsv($handle);
            if (empty($line[4])) {
                break;
            }
            $bannerIDs = $bannerGetter($line[1]);
            // $category_id = $bannerGetter($line[1]);
            $data = [
                'author_id' => $author_id,
                'source' => trim($line[2]),
                'category_id' => $categoryGetter($line[3]),
                'title' => trim($line[4]),
                'description' => trim($line[5]),
                'quantity' => $this->quantityGet($line[8]),
            ];
            $challenge = Challenge::updateOrCreate(['title'=>$data['title']], $data);
            $challenge->banners()->sync($bannerIDs);
            $inserted++;
        }
        $this->info($inserted.' inserted or updated');
        return 0;
    }

    private function bannerGetter()
    {
        $b = Banner::pluck('id', 'color');
        $banners = [
            'ab Jupfis' => [$b['jupfi'],$b['pfadi'],$b['rover'],$b['lilie']],
            'ab Pfadis' => [$b['pfadi'],$b['rover'],$b['lilie']],
            'ab Rover' => [$b['rover'],$b['lilie']],
            'ALLE' => [$b['woelfling'],$b['jupfi'],$b['pfadi'],$b['rover'],$b['lilie']],
            'bis Jupfis' => [$b['woelfling'], $b['jupfi']],
            'Rover' => [$b['rover']],
            'Wölflinge' => [$b['woelfling']],
        ];
        return function ($field) use ($banners) {
            $ids = $banners[$field];
            if (empty($ids)) {
                throw new \Exception("Unsupported Stufen:".$field, 1);
            }
            return $ids;
        };
    }

    private function authorId()
    {
        return Team::findOrFail(42)->leader_id;
    }

    private function categoryGetter()
    {
        $c = Category::pluck('id', 'title');
        $categories = [
            '(Pfadfinder.) Handwerk' => $c['(Pfadfinderisches) Handwerk'],
            'Geist & Seele' => $c['Für Geist & Seele'],
            'Networking & Identität' => $c['Networking & Identität'],
            'Umwelt & Miteinander' => $c['Umwelt & Miteinander'],
        ];
        return function ($field) use ($categories) {
            $id = $categories[$field];
            if (empty($id)) {
                throw new \Exception("Unsupported category:".$field, 1);
            }
            return $id;
        };
    }

    private function quantityGet($field)
    {
        if (in_array($field, ['beliebig',''])) {
            return 10;
        }
        if ($field == 1) {
            return 1;
        }
        throw new \Exception("Unsupported quantity:".$field, 1);
    }
}
