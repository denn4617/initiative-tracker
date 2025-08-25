<?php

namespace App\Actions\Initiatives;

use App\Models\Initiative;
use Illuminate\Support\Facades\DB;

class UpdateInitiative
{
    public function __invoke(Initiative $initiative, array $data): Initiative
    {
        return DB::transaction(function () use ($initiative, $data) {
            $initiative->update($data);
            return $initiative->refresh();
        });
    }
}
