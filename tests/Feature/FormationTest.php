<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Formation;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testListeDesFormations()
    {
        $response = $this->get('/api/formations');
        $response->assertStatus(200);
    }
}
