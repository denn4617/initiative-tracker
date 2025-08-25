<?php

namespace Tests\Unit\Actions;

use App\Actions\Initiatives\UpdateInitiative;
use App\Models\Initiative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateInitiativeTest extends TestCase
{
    use RefreshDatabase;

    public function test_updates_initiative_via_action(): void
    {
        $i = Initiative::factory()->create(['title' => 'Old', 'impact_score' => 3]);

        $update = app(UpdateInitiative::class);
        $updated = $update($i, ['title' => 'New', 'impact_score' => 9]);

        $this->assertSame('New', $updated->title);
        $this->assertSame(9, $updated->impact_score);
    }
}
