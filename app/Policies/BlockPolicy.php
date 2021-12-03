<?php



namespace App\Policies;



use App\Models\Block;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;



class BlockPolicy

{

    use HandlesAuthorization;


    // Only a user with a admin role can modify blocks
  


    public function create(User $user)

    {

        return $user->role=="admin";

    }


    public function update(User $user, Block $block)

    {

        return $user->role=="admin";

    }


    public function delete(User $user, Block $block)

    {

        return $user->role=="admin";

    }




    public function restore(User $user, Block $block)

    {

        return $user->role=="admin";

    }

    public function forceDelete(User $user, Block $block)

    {

        return $user->role=="admin";

    }

}

