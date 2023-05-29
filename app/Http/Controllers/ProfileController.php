<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('profile')->withCount('products' , 'orders')->withSum('orders' , 'total')->find($id);
        return view('dashboard.views-dash.profile.index' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::find($id);
        $request->validate([
                'phone' => 'required|numeric|unique:users,phone,' .  $profile->user->id,
                'avatar' => 'nullable|image',
                'user_name' => 'required|string|max:255',
                'about' => 'required|string|max:255',
                'distance' => 'required|in:MILE,KILO',
            ]);

        $data = $request->all();
        if ($request->file('avatar')) {
            $name = Str::random(12);
            $path = $request->file('avatar');
            $name = $name . time() . '.' . $request->file('avatar')->getClientOriginalExtension();
            $path->move('uploads/Profiles', $name);
            $data['avatar'] = 'uploads/Profiles/' . $name;
        }
        $profile = Profile::find($id);
        $profile->update($data);
        $user = User::find($profile->user->id);
        $user->name = $data['user_name'] ?? $user->name;
        $user->phone = $data['phone'] ?? $user->name;
        $user->verification = $data['verification'] ?? $user->verification;
        $user->save();
        return redirect()->back()->with('success' , __('Updated successfully'));
    }
}
