<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Listing $listing): bool
    {
        // Publicly visible if active and approved
        if ($listing->listing_status === 'active' && $listing->moderation_status === 'approved') {
            return true;
        }

        // Otherwise only owner or admin/moderator
        if (!$user) {
            return false;
        }

        return $user->id === $listing->user_id || $user->hasRole('admin') || $user->hasRole('moderator');
    }

    public function create(User $user): bool
    {
        return $user->status === 'active';
    }

    public function update(User $user, Listing $listing): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $listing->user_id && $user->status === 'active';
    }

    public function delete(User $user, Listing $listing): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $user->id === $listing->user_id && $user->status === 'active';
    }
}

