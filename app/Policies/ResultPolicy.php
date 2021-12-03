<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
       
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return mixed
     */

    // the result is public to view, if we have the id
    // ? means that the result can be viewed without logging in
    public function view(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */



    public function create(User $user,Event $event)
    {   
        if (Auth::User()->role=="admin") return true;
        if (Auth::User()->role=="office" && $event->office==Auth::User()->id) return true;
        if (Auth::User()->role=="penciler" && $event->penciler==Auth::User()->id) return true;

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return mixed
     */


    public function update(User $user,Result $result)
    {
        //dd("hit update");
        if (Auth::User()->role=="admin") return true;
        if ($result->event->active==false) return false;
        if (Auth::User()->role=="office" && $result->event->office==Auth::User()->id) return true;
        if (Auth::User()->role=="penciler" && $result->event->penciler==Auth::User()->id) return true;
        return false;
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return mixed
     */

    //results won't be deleted
    public function delete(User $user, Result $result)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return mixed
     */

    //results won't be deleted
    public function restore(User $user, Result $result)
    {
        if (Auth::User()->role=="admin") return true;
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Result  $result
     * @return mixed
     */

    //result won't be deleted
    public function forceDelete(User $user, Result $result)
    {
        if (Auth::User()->role=="admin") return true;
        return false;
    }
}
