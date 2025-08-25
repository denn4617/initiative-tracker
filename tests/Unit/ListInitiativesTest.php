<?php

namespace Tests\Unit\Actions;

use App\Actions\Initiatives\ListInitiatives;
use App\Models\Initiative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListInitiativesTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_initiatives_oldest_first(): void
    {
        $a = Initiative::factory()->create(['created_at' => now()->subDay()]);
        $b = Initiative::factory()->create(['created_at' => now()]);

        $list = app(ListInitiatives::class);
        $items = $list();

        $this->assertSame([$a->id, $b->id], $items->pluck('id')->all());
    }
}
