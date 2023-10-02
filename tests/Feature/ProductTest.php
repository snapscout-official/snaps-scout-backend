<?php

namespace Tests\Feature;

use App\Models\ParentCategory;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    public function test_product_can_be_created_with_sub_category()
    {
       
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        ParentCategory::factory()->create();
        $subCategory = SubCategory::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
                        ->post('api/admin/add-products', [
                            'description' => 'blablablabla',
                            'product_name' => 'testName',
                            'subCategoryId' => $subCategory->sub_id
                        ]);
        $response->assertStatus(201);
        $this->assertDatabaseCount('products', 1);
    }
    public function test_product_can_be_created_with_third_category()
    {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        ParentCategory::factory()->create();
        $subCategory = SubCategory::factory()->create();
        $thirdCategory = ThirdCategory::factory()->create();
        $response = $this->actingAs($user)
                        ->post('api/admin/add-products', [
                            'description' => 'blablabla',
                            'product_name' => 'test',
                            'thirdCategoryId' => $thirdCategory->third_id
                        ],
                        [
                            'Accept' => 'application/json'
                        ]);
        $response->assertStatus(201);
        $this->assertDatabaseCount('products', 1);
    }
}
