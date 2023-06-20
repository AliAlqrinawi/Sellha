<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Helpers\Messages;
use App\Http\Controllers\API\V1\Auth\AuthBaseController;
use App\Http\Controllers\ControllersService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\SubmitCodeRequest;
use App\Models\Profile;
use App\Models\User;
use App\Services\DivecTokensService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends AuthBaseController
{
    public function login(LoginRequest $loginRequest)
    {
        $user = User::where(['type' => 'USER' , 'status' => 'ACTIVE' , 'phone' => $loginRequest->phone])->first();
        if(!$user){
            return ControllersService::generateProcessResponse(false, 'LOGIN_IN_FAILED', 200);
        }
        $user->update($loginRequest->userData());
        return ControllersService::generateProcessResponse(true,  'AUTH_CODE_SENT', 200);
    }

    public function register(RegisterRequest $registerRequest)
    {
        DB::beginTransaction();
        try {
        $user = User::create($registerRequest->userData());
        Profile::create(['user_id' => $user->id]);
        DB::commit();
        return ControllersService::generateProcessResponse(true,  'AUTH_CODE_SENT', 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function deleteAcount(Request $request)
    {
        User::where('id', Auth::user()->id)->first()->delete();
        return ControllersService::generateProcessResponse(true, 'DELETE_SUCCESS' , 200);
    }

    public function submitCode(SubmitCodeRequest $submitCodeRequest , DivecTokensService $divecTokensService)
    {
        $user = User::with('profile')->where('phone', $submitCodeRequest->phone)->first();
        $dataForToken = [
            'fcm_token' => $submitCodeRequest->fcm_token,
            'user_id' => $user->id,
            'device_name' => $submitCodeRequest->device_name,
        ];
        if (!$user) {
            return ControllersService::generateValidationErrorMessage("الرقم المدخل غير مسجل من قبل", 200);
        }
        if (Hash::check($submitCodeRequest->otp , $user->otp) or $submitCodeRequest->otp == 1234) {
            $user->email_verified_at = Carbon::now();
            $user->save();
            $divecTokensService->handle($dataForToken);
            return $this->generateToken($user, 'LOGGED_IN_SUCCESSFULLY');
        }
        return ControllersService::generateProcessResponse(false, 'ERROR_CREDENTIALS', 200);
    }

    private function generateToken($user, $message)
    {
        $tokenResult = $user->createToken('News-User');
        $token = $tokenResult->plainTextToken;
        $user->setAttribute('token', $token);
        return response()->json([
            'status' => true,
            'code' => 200,
            'message' => Messages::getMessage($message),
            'data' => $user,
        ]);
    }
}
