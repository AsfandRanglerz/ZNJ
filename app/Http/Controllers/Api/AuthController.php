<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function create(Request $request)
    {
        if ($request->role_type === 'recruter') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'company_name' => 'required',
                'designation' => 'required',
                'email' => 'required|unique:users,email|email',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $recruter_data = [
                'name' => $request->name,
                'company_name' => $request->company_name,
                'designation' => $request->designation,
                'role_type'=>$request->role_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)

            ];
            $user = User::create($recruter_data);
            $token = $user->createToken('znjToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return $this->sendSuccess('Recruter Register Successfully', $response);
        } elseif ($request->role_type === 'entertainer') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email|email',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $entertainer_data = [
                'name' => $request->name,
                'company_name' => $request->company_name,
                'designation' => $request->designation,
                'role_type'=>$request->role_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)

            ];
            $user = User::create($entertainer_data);
            $token = $user->createToken('znjToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return $this->sendSuccess('Entertainer Register Successfully', $response);
        } elseif ($request->role_type === 'venue') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email|email',
                'venue_name' => 'required',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $venue_data = [
                'name' => $request->name,
                'venue_name' => $request->company_name,
                'role_type'=>$request->role_type,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)

            ];
            $user = User::create($venue_data);
            $token = $user->createToken('znjToken')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return $this->sendSuccess('Venue Register Successfully', $response);
        } else {
            return $this->sendError('Invalid Credentials');
        }
    }
}
