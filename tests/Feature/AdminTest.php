<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
    }
    public function test_admin_can_login()
    {
        $user = User::factory()->create();
        $response = $this->post('api/admin/login', [
            'email' => "{$user->email}",
            'password' => 'Starmovies_12'
        ]);
        $response->assertStatus(200);   
    }

    //test that invalid credentials cannot login and returns a 401 http status
    public function test_admin_cannot_login_with_invalid_credentials():void
    {
        
        $response = $this->post('api/admin/login',[
            'email' => 'gio.gonzales@carsu.edu.ph',
            'password' => 'sadawdaw'
        ]);
        $response->assertStatus(401);
    }
    

}
