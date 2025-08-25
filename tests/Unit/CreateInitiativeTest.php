<?php

namespace Tests\Unit\Actions;

use App\Actions\Initiatives\CreateInitiative;
use App\Models\Initiative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateInitiativeTest extends TestCase
{
    use RefreshDatabase;

    public function test_creates_initiative_via_action(): void
    {
        $action = app(CreateInitiative::class);

        $i = $action([
            'title' => 'Action-created',
            'description' => null,
            'impact_score' => 6,
            'category' => 'Climate',
        ]);

        $this->assertInstanceOf(Initiative::class, $i);
        $this->assertTrue($i->exists);
        $this->assertSame(6, $i->impact_score);
    }
}
