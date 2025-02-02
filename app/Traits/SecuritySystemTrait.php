<?php

namespace App\Traits;

trait SecuritySystemTrait
{
    public function isOwnerSystem(): bool
    {
        return $this->id == config('owner-system.user.id') || $this->hasRole('super usuario');
    }
}