<?php

namespace App\Policies;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    
    /**
     * Author helper
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Model  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    protected function _isAuthor(User $user, Model $model)
    {
        return $user->id === $model->author_id
            ? Response::allow()
            : Response::deny(__('You are not the author'));
    }
}
