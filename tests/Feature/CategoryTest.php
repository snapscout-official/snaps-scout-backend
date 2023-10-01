<?php

namespace Tests\Feature;

use App\Models\Role;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    // use RefreshDatabase;
    public function an_action_requires_authentication():void
    {
        $response = $this->getJson('/api/admin/create-category');
        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_perform_action():void
    {
        // $user = User::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
                        ->getJson('api/admin/create-category');
        
        $response->assertStatus(200);
        
    }
}
