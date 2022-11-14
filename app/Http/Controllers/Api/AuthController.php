<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

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
            $recruter_data = $request->only(['name', 'email', 'phone', 'password', 'role', 'company', 'designation']);
            $recruter_data['password'] = Hash::make($request->password);
            $user = User::create($recruter_data);
            $user['token'] = $user->createToken('znjToken')->plainTextToken;
            return $this->sendSuccess('Recruter Register Successfully', $user);
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
                'role' => $request->role,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ];
            $entertainer_data = $request->only(['name', 'email', 'role', 'phone', 'password']);
            $entertainer_data['password'] = Hash::make($request->password);
            $user = User::create($entertainer_data);
            $user['token'] = $user->createToken('znjToken')->plainTextToken;
            return $this->sendSuccess('Entertainer Register Successfully', $user);
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
            $venue_data = $request->only(['name', 'email', 'phone', 'password', 'role', 'venue']);
            $venue_data['password'] = Hash::make($request->password);
            $user = User::create($venue_data);
            $user['token'] = $user->createToken('authToken')->plainTextToken;
            return $this->sendSuccess('Venue Register Successfully', $user);
        } else {
            return $this->sendError('Invalid Credentials');
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        }
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return  $this->sendError('Invalid email or password');
        }
        $user = User::find(auth()->id());
        $user['token'] = $user->createToken('authToken')->plainTextToken;
        return $this->sendSuccess('Login Successfully', $user);
    }
    // public function logout()
    // {
    //     Auth::logout();


    //     DB::table('personal_access_tokens')->where(['tokenable_id' => Auth::id()])->delete();

    //     return $this->sendSuccess('User Logout Successfully', Auth::id());
    // }
    public function forgetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        } else if (!$user) {
            return $this->sendError('Invalid Credentials');
        } else {
            try {
                $token = random_int(1000, 9999);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
                Mail::to($request->email)->send(new ResetPasswordUser($token));
                return $this->sendSuccess('Email Sent Successfully Successfully', ['email' => $user->email]);
            } catch (\Throwable $th) {
                return $this->sendError('Something Went Wrong');
            }
        }
    }
    public function confirmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
        ]);

        $token_data = DB::table('password_resets')->where('token', $request->token)->where('email', $request->email)->first();
        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        } else if (!$token_data) {
            return $this->sendError('Token Invalid or Expired or Email not exist');
        } else {
            DB::table('password_resets')->where('token', $request->token)->where('email', $request->email)->delete();
            return $this->sendSuccess('Token Confirmed Successfully', ['email' => $token_data->email]);
        }
    }
    public function submitResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->first());
        } else if (!$user) {
            return $this->sendError('Email not exist');
        } else {
            return $this->sendSuccess('Reset Password Updated Successfully');
        }
    }
}
