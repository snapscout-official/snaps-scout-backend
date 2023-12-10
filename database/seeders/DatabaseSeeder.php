<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Spec;
use App\Models\User;
use App\Models\Philgep;
use App\Models\Product;
use App\Models\Location;
use App\Models\Merchant;
use App\Models\SubCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\ThirdCategory;
use App\Models\AgencyCategory;
use App\Models\ParentCategory;
use Illuminate\Database\Seeder;
use App\Models\MerchantCategory;
use App\Models\SpecValue;
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

        $date = Carbon::createFromFormat('F j, Y', 'June 5, 2002')
            ->format('Y-m-d');

        // $user = User::create([
        //     'first_name' => 'Mary',
        //     'last_name' => 'Soliva',
        //     'birth_date' => $date,
        //     'tin_number' => '4411233',
        //     'gender' => 'Female',
        //     'phone_number' => '09338603326',
        //     'email' => 'mary.soliva@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::SUPERADMIN
        // ]);
        // $user = User::create([
        //     'first_name' => 'Gio',
        //     'last_name' => 'Gonzales',
        //     'birth_date' => $date,
        //     'tin_number' => '123133',
        //     'gender' => 'Male',
        //     'phone_number' => '09918804161',
        //     'email' => 'gio.gonzales@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::AGENCY
        // ]);
        // $location = Location::create([
        //     'building_name' => 'Navigatu',
        //     'street' => 'Purok-6 Ampayon',
        //     'barangay' => 'Ampayon',
        //     'city' => 'Butuan City',
        //     'province' => 'Agusan Del Norte',
        //     'country' => 'Philippines'
        // ]);
        // $agencyCategory = AgencyCategory::create([
        //     'agency_category_name' => 'General Merchandise'
        // ]);
        // $agency = $user->agency()->create([
        //     'agency_name' => 'COA',
        //     'position' => 'GSO',
        //     'location_id' => $location->location_id,
        //     'category_id' => $agencyCategory->id
        // ]);
        // $user = User::create([
        //     'first_name' => 'Klinth',
        //     'last_name' => 'Matugas',
        //     'birth_date' => $date,
        //     'tin_number' => '12313130',
        //     'gender' => 'Male',
        //     'phone_number' => '09918804162',
        //     'email' => 'klinth.matugas@carsu.edu.ph',
        //     'password' => Hash::make('test'),
        //     'role_id' => Role::MERCHANT
        // ]);
        // $location = Location::create([
        //     'building_name' => 'SM',
        //     'street' => 'Zacor',
        //     'barangay' => 'Zacor',
        //     'city' => 'Butuan City',
        //     'province' => 'Agusan Del Norte',
        //     'country' => 'Philippines'
        // ]);
        // $merchantCategory = MerchantCategory::create([
        //     'merchant_name' => 'General Merchandise'
        // ]);
        // $philgep = Philgep::create([
        //     'type' => 'development'
        // ]);
        // $user->merchant()->create([
        //     'business_name' => 'SM City Butuan',
        //     'location_id' => $location->location_id,
        //     'category_id' => $merchantCategory->id,
        //     'philgeps_id' => $philgep->id
        // ]);
        // ParentCategory::factory(20)->create();
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
        $specs = Spec::all();
        foreach($specs as $spec)
        {
            $random  = rand(1, count($specs));
            $i = 0;
            $specValueIds = [];
            while($i <= $random)
            {
               $specValueIds[] =  SpecValue::create([
                    'spec_value' => fake()->word()
                ])->id;
                $i++;
            }
            $spec->values()->syncWithoutDetaching($specValueIds);
        }
        
        DB::commit();

        // $roles = ['merchant', 'agency', 'super_admin'];
        // foreach ($roles as $role) {
        //     Role::create([
        //         'role_name' => $role
        //     ]);
        // }
    }
}
