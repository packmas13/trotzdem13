<?php

namespace App;

class MapHelper
{
    // coordinates of the "extrem" troops
    public $north = 48.5;
    public $south = 47.6;
    public $east = 13.0;
    public $west = 11.2;

    public function center():array
    {
        return [
            ($this->south+$this->north)/2,
            ($this->east+$this->west)/2,
        ];
    }

    private function width():float
    {
        return $this->east-$this->west;
    }

    private function height():float
    {
        return $this->north-$this->south;
    }

    public function boundSouthWest():array
    {
        return [
            $this->south-$this->height()/4,
            $this->west-$this->width()/3,
        ];
    }

    public function boundNorthEast():array
    {
        return [
            $this->north+$this->height()/4,
            $this->east+$this->width()/3,
        ];
    }
}
