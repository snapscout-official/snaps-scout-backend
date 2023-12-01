<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\ThirdCategory;
use App\Models\ParentCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // $roles = [
        //     'merchant',
        //     'agency',
        //     'super_admin'
        // ];
        // foreach ($roles as $role) {
        //     Role::create([
        //         'role_name' => $role
        //     ]);
        // }
        DB::beginTransaction();

        // $date = Carbon::createFromFormat('F j, Y', 'March 21, 2002')
        //     ->format('Y-m-d');

        // $user = User::create([
        //     'first_name' => 'Mary',
        //     'last_name' => 'Soliva',
        //     'birth_date' => $date,
        //     'tin_number' => '1023131',
        //     'gender' => 'Female',
        //     'phone_number' => '09338603326',
        //     'email' => 'mary.soliva@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::SUPERADMIN
        // ]);
        // ParentCategory::factory(5)->create();
        // SubCategory::factory(5)->create();
        // ThirdCategory::factory(4)->create();
        // $products = ['Calculator', 'Carbon Film', 'Chalk'];
        // foreach ($products as $product) {
        //     Product::create([
        //         'product_name' => $product,
        //         'sub_code' => rand(1, 5),
        //         'third_code' => Arr::random([null, rand(1, 4)]),
        //         'description' => fake()->sentence()
        //     ]);
        // }
        DB::commit();

        // $roles = ['merchant', 'agency', 'super_admin'];
        // foreach ($roles as $role) {
        //     Role::create([
        //         'role_name' => $role
        //     ]);
        // }
    }
}
