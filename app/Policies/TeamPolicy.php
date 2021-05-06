<?php


namespace App\Policies;


use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Team $team
     * @return mixed
     */
    public function changeImage(User $user, Team $team)
    {
        if($team->leader_id == $user->id){
            return true;
        }
        if($user->isOrga()){
            return true;
        }
        return false;
    }
}