<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AdminTest extends TestCase
{
 
    public function test_admin_can_login()
    {
        $response = $this->post('api/admin/login', [
            'email' => 'mary.soliva@carsu.edu.ph',
            'password' => 'starmovies3144'
        ]);
        $response->assertStatus(200);   
    }

    public function test_admin_cannot_login_with_invalid_credentials():void
    {
        $response = $this->post('api/admin/login', [
            'email' => 'gio.gonzales@carsu.edu.ph',
            'password' => 'adsadada'
        ]);
        $response->assertStatus(401);
    }

}
