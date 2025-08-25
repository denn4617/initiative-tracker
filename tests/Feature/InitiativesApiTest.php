<?php

namespace Tests\Feature;

use App\Models\Initiative;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InitiativesApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_lists_initiatives_oldest_first(): void
    {
        $a = Initiative::factory()->create(['created_at' => now()->subDay()]);
        $b = Initiative::factory()->create(['created_at' => now()]);

        $res = $this->getJson('/api/initiatives')->assertOk();

        $ids = collect($res->json('data'))->pluck('id')->all();
        $this->assertSame([$a->id, $b->id], $ids);
    }

    public function test_creates_initiative_returns_201(): void
    {
        $payload = [
            'title' => 'Reduce water usage',
            'description' => 'Install low-flow fixtures',
            'impact_score' => 8,
            'category' => 'Environment',
        ];

        $this->postJson('/api/initiatives', $payload)
            ->assertCreated()
            ->assertJsonPath('data.title', $payload['title'])
            ->assertJsonPath('data.impact_score', $payload['impact_score']);

        $this->assertDatabaseHas('initiatives', [
            'title' => 'Reduce water usage',
            'impact_score' => 8,
        ]);
    }

    public function test_validates_payload_on_create(): void
    {
        $this->postJson('/api/initiatives', [
            'title' => '',
            'impact_score' => 15,
            'category' => '',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'impact_score', 'category']);
    }

    public function test_shows_single_initiative(): void
    {
        $i = Initiative::factory()->create();

        $this->getJson("/api/initiatives/{$i->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $i->id)
            ->assertJsonPath('data.title', $i->title);
    }

    public function test_updates_initiative(): void
    {
        $i = Initiative::factory()->create(['title' => 'Old', 'impact_score' => 3]);

        $this->putJson("/api/initiatives/{$i->id}", [
            'title' => 'New',
            'impact_score' => 7,
        ])->assertOk();

        $this->assertDatabaseHas('initiatives', [
            'id' => $i->id,
            'title' => 'New',
            'impact_score' => 7,
        ]);
    }

    public function test_deletes_initiative(): void
    {
        $i = Initiative::factory()->create();

        $this->deleteJson("/api/initiatives/{$i->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('initiatives', ['id' => $i->id]);
    }
}
