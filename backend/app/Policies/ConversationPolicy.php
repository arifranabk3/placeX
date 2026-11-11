<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;

class ConversationPolicy
{
    public function view(User $user, Conversation $conversation): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return $conversation->participants()->where('user_id', $user->id)->exists();
    }

    public function sendMessage(User $user, Conversation $conversation): bool
    {
        if ($user->status !== 'active') {
            return false;
        }

        return $conversation->participants()->where('user_id', $user->id)->exists();
    }
}

