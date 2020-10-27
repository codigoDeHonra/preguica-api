<?php

namespace App\Policies;

use App\User;

class PostUserPolicy
{
    public function update(User $user)
    {
        return true;
    }
}
