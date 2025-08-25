<?php

namespace App\Actions\Initiatives;

use App\Models\Initiative;
use Illuminate\Support\Facades\DB;

class CreateInitiative
{
    public function __invoke(array $data): Initiative
    {
        return DB::transaction(fn() => Initiative::create($data));
    }
}
