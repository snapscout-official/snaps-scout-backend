<?php

namespace Tests\Feature;

use App\Models\ParentCategory;
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
        
        $response->assertStatus(200)
                ->assertJsonStructure([
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
    public function test_admin_can_delete_parent_category():void
    {
        $parentCategory = ParentCategory::factory()->create();
        $response = $this->delete("api/admin/parent-category/{$parentCategory->parent_id}");
        $this->assertDatabaseMissing('parent_category', ['parent_id' => $parentCategory->parent_id]);
    }
}
