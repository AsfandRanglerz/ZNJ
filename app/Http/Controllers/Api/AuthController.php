<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        if ($request->role === 'recruter') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'company' => 'required',
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
                'company' => $request->company,
                'designation' => $request->designation,
                'role'=>$request->role,
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

        } elseif ($request->role === 'entertainer') {
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
                'company' => $request->company,
                'designation' => $request->designation,
                'role'=>$request->role,
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
        } elseif ($request->role === 'venue') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|unique:users,email|email',
                'venue' => 'required',
                'phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->sendError($validator->errors()->first());
            }
            $venue_data = [
                'name' => $request->name,
                'venue' => $request->company,
                'role'=>$request->role,
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
        }
        else
        {
            return $this->sendError('Invalid Credentials');
        }
    }
    public function login(Request $request){

            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',


            ]);
            $user = User::where('email',$request->email)->first();

            if ($validator->fails())
            {
                return $this->sendError($validator->errors()->first());
            }
            elseif (!$user || !Hash::check($request->password, $user->password))
            {
                return $this->sendError('Invalid Credentials');
            }
            else
            {
                $token = $user->createToken('znjToken')->plainTextToken;
                $response = [
                    'user' => $user,
                    'token' => $token
                ];
                return $this->sendSuccess('User Login Successfully', $response);
            }
    }
    public function logout(){

        DB::table('personal_access_tokens')->where(['tokenable_id' => Auth::id()])->delete();
        return $this->sendSuccess('User Logout Successfully',Auth::id());
    }
    public function forgetPassword(){

    }


}
