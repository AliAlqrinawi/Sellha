<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{

    public function edit_admin()
    {
        $id=auth()->user()->id;
        $user = User::find($id);

        return view('dashboard.views-dash.admin.edit',compact('user'));
    }

    public function update_admin(Request $request)
    {
        $id=$request->id;
        $rules = [
            'email' => 'required|email|unique:users,email,'.$id,
        ];
        $validation = $request->validate($rules);
        $users = User::find($id);
        $users->update( $request->all());
        session()->flash('success', 'تم تعديل المستخدم بنجاح ');
        return redirect()->route('home');
    }

    public function reset_Password()
    {
        $id=auth()->user()->id;
        $user = User::find($id);
        return view('dashboard.views-dash.admin.resetPassword', compact('user') );
    }

    public function resetPassword(Request $request)
    {
        $rules = [
            'old_password' => 'required|min:3',
            'new_password' => 'required|min:3',
            'confirm_password' => 'required|min:3|same:new_password',
        ];
        $validated = $request->validate($rules);
        $user = auth()->user();
        if (!Hash::check($request->get('old_password'), $user->password)) {
            $message = 'The old password is incorrect'; //wrong old
            return redirect()->back()->with('danger' , $message);
        }
        $user->password = bcrypt($request->get('new_password'));
        $data=$user->save();
        return redirect()->route('home');
    }
}
