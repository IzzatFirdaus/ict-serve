<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\LoanRequest;
use App\Models\User;

class LoanRequestPolicy
{
    public function view(User $user, LoanRequest $loan): bool
    {
        if ($user->id === $loan->user_id) {
            return true;
        }

        if ($loan->supervisor_id && $user->id === $loan->supervisor_id) {
            return true;
        }

        return in_array($user->role, [UserRole::ICT_ADMIN, UserRole::SUPER_ADMIN], true);
    }

    public function update(User $user, LoanRequest $loan): bool
    {
        if ($user->id === $loan->user_id && $loan->canBeEdited()) {
            return true;
        }

        if ($loan->supervisor_id && $user->id === $loan->supervisor_id) {
            return true;
        }

        return in_array($user->role, [UserRole::ICT_ADMIN, UserRole::SUPER_ADMIN], true);
    }

    public function delete(User $user, LoanRequest $loan): bool
    {
        return in_array($user->role, [UserRole::ICT_ADMIN], true);
    }
}
