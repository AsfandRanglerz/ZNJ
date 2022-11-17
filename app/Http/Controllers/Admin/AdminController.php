<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AdminController extends Controller
{
    public function getdashboard()
    {   $data['venue']=User::where('role','Venue')->count();
        $data['recruiter']=User::where('role','Recruiter')->count();
        $data['entertainer']=User::where('role','Entertainer')->count();
        // dd($data);
        return view('admin.index',compact('data'));
    }
    public function getProfile()
    {
        $data = Admin::find(Auth::guard('admin')->id());
        return view('admin.auth.profile', compact('data'));
    }
    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'phone']);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/img'), $filename);
            $data['image'] = 'public/admin/assets/img/' . $filename;
        }
        Admin::find(Auth::guard('admin')->id())->update($data);
        return back()->with(['status' => true, 'message' => 'Profile Updated Successfully']);
    }
    public function forgetPassword()
    {
        return view('admin.auth.forgetPassword');
    }
    public function adminResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:admins,email',
        ]);
        $exists = DB::table('password_resets')->where('email', $request->email)->first();
        if ($exists) {
            return back()->with('message', 'Reset Password link has been already sent');
        } else {
            $token = Str::random(30);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
            ]);

            $data['url'] = url('change_password', $token);
            Mail::to($request->email)->send(new ResetPasswordMail($data));
            return back()->with('message', 'Reset Password Link Send Successfully');
        }
    }
    public function change_password($id)
    {

        $user = DB::table('password_resets')->where('token', $id)->first();
        if (isset($user)) {
            return view('admin.auth.chnagePassword', compact('user'));
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'confirmed' => 'required',

        ]);
        if ($request->password != $request->confirmed) {
            return back()->with(['error_message' => 'Password not matched']);
        }
        $password = bcrypt($request->password);
        $tags_data = [
            'password' => bcrypt($request->password)
        ];
        if (Admin::where('email', $request->email)->update($tags_data)) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect('admin');
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin');
    }

    //Change Password
    public function profile_change_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required'
        ]);
        $auth = Auth::guard('admin')->user();
        if (!Hash::check($request->current_password, $auth->password)) {
            return back()->with(['status' => false, 'message' => "Current Password is Invalid"]);
        } else if (strcmp($request->current_password, $request->new_password) == 0) {
            return redirect()->back()->with(['status' => false, 'message' => "New Password cannot be same as your current password."]);
        } else {
            $user =  Admin::find($auth->id);
            $user->password =  Hash::make($request->new_password);
            $user->save();
            return back()->with(['status' => true, 'message' => 'Password Updated Successfully']);
        }
    }
}
