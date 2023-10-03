<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Review $review)
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('作成者本人のみ編集が可能です。');
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id
            ? Response::allow()
            : Response::deny('作成者本人のみ削除が可能です。');
    }
}
