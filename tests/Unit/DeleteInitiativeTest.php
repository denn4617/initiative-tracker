<?php

namespace Tests\Unit\Actions;

use App\Actions\Initiatives\DeleteInitiative;
use App\Models\Initiative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteInitiativeTest extends TestCase
{
    use RefreshDatabase;

    public function test_deletes_initiative_via_action(): void
    {
        $i = Initiative::factory()->create();

        $delete = app(DeleteInitiative::class);
        $delete($i);

        $this->assertNull(Initiative::find($i->id));
    }
}
