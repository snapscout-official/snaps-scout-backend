<?php

namespace App\Services;

use App\Http\Requests\Agency\AgencyLoginRequest;
use Carbon\Carbon;
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
      
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            
            if (Auth::attempt($request->only(['email', 'password'])))
            {
            $request->session()->regenerate();
            return response()->json([
                'authenticated' => true,
                'User' => auth()->user(),
                'message' => 'Successfully authenticated'
            ]);
            }
            return response()->json([
                'authenticated' => false,
                'message' => 'Invalid credentials'
            ]);
        
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
            return response()->json([
                'authenticated' => true,
                'User' => auth()->user(),
                'Message' => 'Successfully authenticated'
            ]);
        }
        return response()->json([
            'authenticated' => false,
            'Message' => 'Error authentication'
        ]);
    }

    public function authenticateRegisterAgency(AgencyRegister $request)
    {
      
        DB::beginTransaction();

        $date = Carbon::createFromFormat('F j, Y', $request->birth_date)
                    ->format('Y-m-d');
        
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $date,
            'tin_number' => $request->tin_number,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => Role::AGENCY
        ]);

       $location = Location::create([
            'building_name' =>$request->building_name ,
            'street' => $request->street,
            'barangay' =>$request->barangay,
            'city' => $request->city,
            'province' =>$request->province,
            'country' =>$request->country,
       ]);
        $agencyCategory = AgencyCategory::create([
            'agency_category_name' => $request->agency_category_name
             ]);
        
        $user->agency()->create([
        'agency_name' =>$request->agency_name,
        'position' =>$request->position,
        'location_id' => $location->location_id,
        'category_id' => $agencyCategory->id,
    ]);
        DB::commit();

        if (Auth::attempt($request->only(['email', 'password'])))
        {
            $request->session()->regenerate();

            event(new Registered($user));

            return response()->json([
                'authenticated'=> true,
                'agencyUser' => auth()->user(),
                'message' => 'Sucessfully authenticated',
                'emailVerificationUrl' => 'localhost:5173'
            ]);

            
        }
        return response()->json([
            'authenticated' => false,
            'message' => 'Failed to Register'
        ]);
    }

    
    public function authenticateAgencyLogin(AgencyLoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user->role_id !== Role::AGENCY)
        {
            return response()->json([
                'authenticated' => false,
                'message' => 'You are not authorized to login as agency'
            ], 402);
        }
        
        if (Auth::attempt($request->only(['email', 'password'])))
        {
            $request->session()->regenerate();
            return response()->json([
                'authenticated' => true,
                'message' => 'Successfully logged in'
            ]);
        }

        return response()->json([
            'authenticated' => false,
            'message' => 'Unable to authenticate credentials'
        ]);

    }
}