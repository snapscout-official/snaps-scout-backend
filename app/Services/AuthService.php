<?php

namespace App\Services;

use App\Http\Requests\Agency\AgencyLoginRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\AgencyCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Agency\AgencyRegister;


class AuthService
{

    public function authenticateRegisterMerchant(Request $request)
    {
      
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            
            if (Auth::attempt($request->only(['email', 'password'])))
            {

            return  $request->expectsJson() ? response()->json([
                'authenticated' => true,
                'User' => auth()->user(),
                'message' => 'Successfully authenticated',
                'access_token' => $user->createToken('auth-token')->plainTextToken
            ]) : null;
            }

            
            return $request->expectsJson() ?  response()->json([
                'authenticated' => false,
                'message' => 'Invalid credentials'
            ]) : null;
        
    }
    public function authenticateLoginMerchant(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::MERCHANT)
        {
            return response()->json([
                'authenticated' => false,
                'message' => 'You are not authorized to login as Merchant'
            ], 402);
        }
        if (Auth::attempt($request->only(['email', 'password'])))
        {
            $request->session()->regenerate();
            return $request->expectsJson() ?  response()->json([
                'authenticated' => true,
                'User' => auth()->user(),
                'Message' => 'Successfully authenticated'
            ]) : null;
        }
        return $request->expectsJson() ?  response()->json([
            'authenticated' => false,
            'Message' => 'Error authentication'
        ]) : null;
    }

    public function authenticateRegisterAgency(AgencyRegister $request)
    {
      
        DB::beginTransaction();

        
        $user = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'birth_date' => $request->dateOfBirth,
            'tin_number' => $request->tinNumber,
            'gender' => $request->gender,
            'phone_number' => $request->contactNumber,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::AGENCY
        ]);

       $location = Location::create([
            'building_name' =>$request->buildingName ,
            'street' => $request->street,
            'barangay' =>$request->barangay,
            'city' => $request->city,
            'province' =>$request->province,
            'country' =>$request->country,
       ]);
        $agencyCategory = AgencyCategory::create([
            'agency_category_name' => $request->agencyCategory
             ]);
        
        $user->agency()->create([
        'agency_name' =>$request->agencyName,
        'position' =>$request->position,
        'location_id' => $location->location_id,
        'category_id' => $agencyCategory->id,
    ]);
        DB::commit();

        if (Auth::attempt($request->only(['email', 'password'])))
        {
            
            $user = User::where('email', $request->email)->first();

            event(new Registered($user));
        
            return  $request->expectsJson() ? response()->json([
                'authenticated'=> true,
                'agencyUser' => auth()->user(),
                'message' => 'Sucessfully authenticated',
                'emailVerificationUrl' => 'localhost:5173',
                'access_token' => $user->createToken('auth-token')->plainTextToken
                
            ]) : null;

            
        }
        return $request->expectsJson() ?  response()->json([
            'authenticated' => false,
            'message' => 'Failed to Register'
        ]) : null;
    }

    
    public function authenticateAgencyLogin(AgencyLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::AGENCY)
        {
            return  $request->expectsJson() ?  response()->json([
                'authenticated' => false,
                'message' => 'You are not authorized to login as agency'
            ], 402) : null;
        }
        
        if (Auth::attempt($request->only(['email', 'password'])))
        {
           
            return  $request->expectsJson() ? response()->json([
                'authenticated' => true,
                'message' => 'Successfully logged in',
                'access_token' => $user->createToken('auth-token')->plainTextToken
            ]) : null;
        }

        return $request->expectsJson() ?  response()->json([
            'authenticated' => false,
            'message' => 'Unable to authenticate credentials'
        ]) : null;

    }
}