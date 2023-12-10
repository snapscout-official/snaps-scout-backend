<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AgencyProductReviewTest extends TestCase
{
    
   public function test_unathenticated_user_cannot_retrieve_data()
    {
        $response = $this->get('/api/agency/products');
        $response->assertStatus(403);
    }
    public function test_agency_user_can_retrieve_data()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('/api/agency/products');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) => 
            $json->hasAll(['data', 'data.products', 'data.total_products'])
    );
    }
}
