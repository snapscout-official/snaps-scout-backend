<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Agency;
use App\Models\Philgep;
use App\Models\Location;
use App\Models\Merchant;
use App\Models\AgencyCategory;
use Illuminate\Database\Seeder;
use App\Models\MerchantCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // DB::beginTransaction();

        // $user = User::create([
        //     'first_name' => 'Gio',
        //     'last_name' => 'Gonzales',
        //     'birth_date' => now()->subYear(21),
        //     'tin_number' => '1023131',
        //     'gender' => 'Male',
        //     'phone_number' => '09918804161',
        //     'email' => 'gio.gonzales@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::MERCHANT
        // ]);
        // $location = Location::create([
        //     'building_name' => 'Bayawak building',
        //     'street' => 'Purok 17',
        //     'barangay' => 'San Vicente',
        //     'city' => 'Butuan City',
        //     'province' => 'Agusan Del Norte',
        //     'country' => 'Philippines'
        // ]);
        // $merchantCat = MerchantCategory::create([
        //     'name' => 'Ambot'
        // ]);
        // $philgeps = Philgep::create([
        //     'type' => 'Ambot sab lage'
        // ]);
        // Merchant::create([
        //     'merchant_id' => $user->id,
        //     'business_name' => 'Ohweed',
        //     'location_id' => $location->location_id,
        //     'category_id' => $merchantCat->id,
        //     'philgeps_id' => $philgeps->id
        // ]);
        // DB::commit();
        // DB::beginTransaction();

        // $user = User::create([
        //     'first_name' => 'Mary',
        //     'last_name' => 'Soliva',
        //     'birth_date' => now()->subYear(21),
        //     'tin_number' => '222222',
        //     'gender' => 'Female',
        //     'phone_number' => '09916464633',
        //     'email' => 'mary.soliva@carsu.edu.ph',
        //     'password' => Hash::make('starmovies3144'),
        //     'role_id' => Role::AGENCY
        // ]);
        // $location = Location::create([
        //     'building_name' => 'Bayawak building',
        //     'street' => 'Purok 17',
        //     'barangay' => 'Villa Kanangga',
        //     'city' => 'Butuan City',
        //     'province' => 'Agusan Del Norte',
        //     'country' => 'Philippines'
        // ]);
        // $agencyCat = AgencyCategory::create([
        //     'name' => 'Test'
        // ]);
        // Agency::create([
        //     'agency_id' => $user->id,
        //     'name' => 'Navigatu',
        //     'location_id' => $location->location_id,
        //     'category_id' => $agencyCat->id,
        //     'position' => 'Incubatee'
            
        // ]);
        // DB::commit();
        // $roles = [
        //     'merchant',
        //     'agency'
        // ];
        // foreach($roles as $role)
        // {
        //     Role::create([
        //         'role_name' => $role
        //     ]);
        // }
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
            'email' =>'gio.gonzales@carsu.edu.ph',
            'password' => Hash::make('starmovies3144'),
            'role_id' => Role::SUPERADMIN
        ]);
        $location = Location::create([
            'building_name' =>'Bayawak building' ,
            'street' => 'Purok 17',
            'barangay' =>'Villa Kanangga',
            'city' => 'Butuan City',
            'province' =>'Agusan Del Norte',
            'country' =>'Philippines',
        ]);
        $agencyCategory = AgencyCategory::create([
            'agency_category_name' => 'Test'
        ]);

        $user->agency()->create([
            'agency_name' =>'Navigatu',
            'position' =>'Incubatee',
            'location_id' => $location->location_id,
            'category_id' => $agencyCategory->id,
        ]);
        DB::commit();
       
    }
}
