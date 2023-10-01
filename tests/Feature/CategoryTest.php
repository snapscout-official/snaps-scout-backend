<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;


class CategoryTest extends TestCase
{
    // use RefreshDatabase;
    public function test_action_requires_authentication():void
    {
        $response = $this->getJson('/api/admin/create-category');
        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_perform_action():void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
                        ->getJson('api/admin/create-category');
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'categories' => [
                    '*' => [
                        'parent_id',
                        'parent_name',
                        'sub_categories' => [
                            '*' => [
                                'sub_id',
                                'sub_name',
                                'parent',
                                'third_categories' => [
                                    '*' => [
                                        'third_id',
                                        'third_name',
                                        'sub_id'
                                    ]
                                ]
                            ]
                        ]

                    ]
            ]        
        ]);    
    }

}
