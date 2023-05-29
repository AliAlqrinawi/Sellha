<?php

namespace App\Http\Controllers;

use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Auth;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    protected $firebaseAuth;

    public function __construct(Auth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth->withProjectId('test-e0c84');
    }

    public function sendOtp(Request $request)
    {
        $phone = $request->input('phone');

        // Generate OTP using Firebase
        $verification = $this->firebaseAuth->sendPhoneNumberVerificationCode($phone, [
            'locale' => 'en',
            'sessionInfo' => 'Your session info',
        ]);

        // Return a success response
        return response()->json(['message' => 'OTP sent successfully']);
    }

    public function verifyOtp(Request $request)
    {
        $phone = $request->input('phone');
        $otp = $request->input('otp');

        // Verify OTP using Firebase
        try {
            $verifiedIdToken = $this->firebaseAuth->verifyPhoneNumber($phone, $otp);

            // You can access the verified user ID token
            $userUid = $verifiedIdToken->claims()->get('sub');

            // Return the user ID token or any other response as needed
            return response()->json(['user_uid' => $userUid]);
        } catch (InvalidToken $e) {
            // Failed to verify the OTP
            return response()->json(['error' => 'Invalid OTP'], 400);
        }
    }
}
