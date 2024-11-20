<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Trainee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OTPController extends Controller
{
    public function generateOTP(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'You must be logged in to generate OTP.']);
        }

        $cachedOtp = Cache::get('otp_' . $request->user()->id);
        if (!is_numeric($cachedOtp)) {

            Log::info('Generating OTP for user: ' . $request->user()->id);

            $otp = rand(100000, 999999);

            Log::info('Generated OTP: ' . $otp);

            Cache::put('otp_' . $request->user()->id, $otp, now()->addMinutes(1));
            
            // Mail::to($request->user()->email)->send(new OtpMail($otp));

            return view('auth.verify-otp')->with('status', 'A new OTP has been sent to your email.');
        } else {
            // Cache::flush();
            Cache::forget('otp_' . $request->user()->id);

            $trainee = Trainee::findOrFail($request->user()->id);
            $trainee->is_verified = true;
            $trainee->save();

            return redirect('home')->with('success', 'OTP verified successfully.');
        }
    }

    public function verifyOTP(Request $request)
    {
        Log::info('Verifying OTP for user: ' . $request->user()->id);

        $otp = $request->input('otp');

        $cachedOtp = Cache::get('otp_' . $request->user()->id);

        Log::info('Cached OTP: ' . $cachedOtp);

        if ($otp === $cachedOtp) {
            Cache::forget('otp_' . $request->user()->id);

            $trainee = Trainee::findOrFail($request->user()->id);
            $trainee->is_verified = true;
            $trainee->save();
            
            return redirect('home')->with('success', 'OTP verified successfully.');

        } else {
            return redirect()->route('generate-otp')->withErrors(['otp' => 'The OTP has expired. A new OTP has been sent to your email.']);
        }
    }
}
