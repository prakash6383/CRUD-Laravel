<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function updatePasswordByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $trainee = Trainee::where('email', $request->email)->first();
        if (!$trainee) {
            return redirect()->back()->withErrors(['email' => 'Trainee not found.']);
        }

        $trainee->password = Hash::make($request->password);
        $trainee->save();

        return redirect()->route('login')->with('success', 'Password updated successfully.');
    }
}
