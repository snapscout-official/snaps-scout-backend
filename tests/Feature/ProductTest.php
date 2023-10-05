<?php

namespace Tests\Feature;

use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\Role;
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
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);     
        ParentCategory::factory()->count(20)->create();
        SubCategory::factory()->count(40)->create();
        ThirdCategory::factory()->count(60)->create();   
        Product::factory()->count(20)->create();
    }
    public function test_product_can_be_created_with_sub_category()
    {
       
        
        $user = User::factory()->create();
        $subCategory = SubCategory::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
                        ->post('api/admin/add-products', [
                            'description' => 'blablablabla',
                            'product_name' => 'testName',
                            'subCategoryId' => $subCategory->sub_id
                        ],
                        [
                            'Accept' => 'application/json'
                        ]
                        );
        $response->assertStatus(201);
        $this->assertDatabaseCount('products', 1);
    }
    public function test_product_can_be_created_with_third_category()
    {
     
        $user = User::factory()->create();
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
    // public function test_returns_product_
    public function test_product_api_returns_the_proper_structure():void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->get('api/admin/products');

        
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'products' => [
                        '*' => [
                            'product' =>[
                                'product_id',
                                'product_name',
                                'sub_code',
                                'third_code',
                                'description',
                                'created_at',
                                'updated_at'
                            ],
                            'thirdCategory',
                            'subCategory',
                        ]
                    ]
                ]);

    }
    // public function test_check_arr_methods()
    // {

    //     //wapa nahuman
    //     $this->seed(RoleSeeder::class);User::factory()->count(2)->create();
    //     $subCategory = SubCategory::all();
    //     dd($subCategory);
        

    // }
    
}
