<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\ProfileStore;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('profile')->find(Auth::user()->id);
        return (new UserResource($user));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileStore $profileStore)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileStore $profileStore, $id)
    {
        $data = $profileStore->all();
        try {
            if ($profileStore->hasFile('avatar')) {
                $name = Str::random(12);
                $firstavatar = $profileStore->file('avatar');
                $firstavatarName = $name . time() . '_' . '.' . $firstavatar->getClientOriginalExtension();
                $firstavatar->move('uploads/profiles/', $firstavatarName);
                $data['avatar'] = 'uploads/profiles/' . $firstavatarName;
            }
            Profile::find(Auth::user()->profile->id)->update($data);
            $user = User::find(Auth::user()->id);
            $user->name = $data['user_name'] ?? $user->name;
            $user->phone = $data['phone'] ?? $user->name;
            $user->verification = $data['verification'] ?? $user->verification;
            $user->save();
        } catch (Throwable $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
        return parent::success(User::with('profile')->find(Auth::user()->id) , 'تم التعديل بنجاح');
        return ControllersService::generateProcessResponse(true, 'UPDATE_SUCCESS', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
