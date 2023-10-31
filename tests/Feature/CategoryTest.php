<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ParentCategory;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CategoryTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        // Artisan::call('db:seed', ['--class' => 'RsoleSeeder']);
        $this->seed(Role::class);
        // dd(Role::all());
    }
    public function test_action_requires_authentication(): void
    {
        // $this->withoutExceptionHandling();
        $response = $this->getJson('/api/admin/create-category');
        $response->assertStatus(403);
    }

    public function test_authenticated_user_can_perform_action(): void
    {
        $user = User::factory()->create();
        // dd(Role::all());
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
                ],
                'subCategories' => [
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
            ]);
    }
    public function test_authenticated_admin_can_delete_parent_category(): void
    {

        $parentCategory = ParentCategory::factory()->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->delete("api/admin/parent-category/{$parentCategory->parent_id}");
        $this->assertDatabaseMissing('parent_category', ['parent_id' => $parentCategory->parent_id]);
    }
    public function test_unauthenticated_admin_cannot_delete_parent_category(): void
    {
        $parentCategory = ParentCategory::factory()->create();
        $response = $this->delete("api/admin/parent-category/{$parentCategory->parent_id}");
        $response->assertStatus(403);
    }
}
