<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Spec;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariantSpecsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $values = [
        //     ['specs_name' => 'color', 'specs_value' => 'red'],
        //     ['specs_name' => 'color', 'specs_value' => 'blue'],
        //     ['specs_name' => 'color', 'specs_value' => 'green'],
        //     ['specs_name' => 'color', 'specs_value' => 'black'],
        //     ['specs_name' => 'color', 'specs_value' => 'white'],
        //     ['specs_name' => 'size', 'specs_value' => 'large'],
        //     ['specs_name' => 'size', 'specs_value' => 'small'],
        //     ['specs_name' => 'size', 'specs_value' => 'medium'],
        // ];
        // foreach($values as $value)
        // {
        //     Spec::create($value);
        // }
        $date = Carbon::createFromFormat('F j, Y', 'June 11, 2002')
        ->format('Y-m-d');

        $user = User::create([
            'first_name' => 'Mary',
            'last_name' => 'Soliva',
            'birth_date' => $date,
            'tin_number' =>'1023113122',
            'gender' => 'Male',
            'phone_number' =>'09918104161',
            'email' =>'mary.soliva@carsu.edu.ph',
            'password' => Hash::make('starmovies3144'),
            'role_id' => Role::MERCHANT
        ]);
        
    }
}
