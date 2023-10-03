<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Lecture;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LecturePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Lecture $lecture)
    {
        return $user->id === $lecture->user_id
            ? Response::allow()
            : Response::deny('作成者本人のみ編集が可能です。');
    }

    public function delete(User $user, Lecture $lecture)
    {
        return $user->id === $lecture->user_id
            ? Response::allow()
            : Response::deny('作成者本人のみ削除が可能です。');
    }

    public function checkReview(User $user, Lecture $lecture)
    {
        return $lecture->reviews->where('user_id', '!=', $lecture->user_id)->isEmpty()
            ? Response::allow()
            : Response::deny('他のユーザーがレビューを投稿している場合は、編集・削除ができません。');
    }
}
