<?php

namespace App\Actions\Initiatives;

use App\Models\Initiative;
use Illuminate\Database\Eloquent\Collection;

class ListInitiatives
{
    public function __invoke(): Collection
    {
        return Initiative::query()
            ->oldest('id')
            ->get();
    }
}
