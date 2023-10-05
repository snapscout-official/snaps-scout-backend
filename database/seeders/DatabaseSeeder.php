<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\ParentCategory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    
        $roles = [
            'merchant',
            'agency',
            'super_admin'
        ];
        foreach($roles as $role)
        {
            Role::create([
                'role_name' => $role
            ]);
        }
        DB::beginTransaction();
        
        $date = Carbon::createFromFormat('F j, Y', 'June 11, 2002')
                    ->format('Y-m-d');
        
        $user = User::create([
            'first_name' => 'Mary',
            'last_name' => 'Soliva',
            'birth_date' => $date,
            'tin_number' =>'1023131',
            'gender' => 'Female',
            'phone_number' =>'09918804161',
            'email' =>'mary.soliva@carsu.edu.ph',
            'password' => Hash::make('starmovies3144'),
            'role_id' => Role::SUPERADMIN
        ]);
        ParentCategory::factory()->count(10)->create();
        SubCategory::factory()->count(20)->create();
        ThirdCategory::factory()->count(20)->create();
        Product::factory()->count(20)->create();
        DB::commit();
       
    }
}
