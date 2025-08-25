<?php

namespace App\Actions\Initiatives;

use App\Models\Initiative;
use Illuminate\Support\Facades\DB;

class DeleteInitiative
{
    public function __invoke(Initiative $initiative): void
    {
        DB::transaction(fn() => $initiative->delete());
    }
}
