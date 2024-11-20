<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use App\Models\TechStack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $appKey = Config::get('app.key');
        return view('auth.registration', [
            'hashedAppKey' => $appKey,
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:trainees',
            'phone' => 'required|string|max:15',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            ],
        ]);

        $trainee = new Trainee;
        $trainee->firstName = $request->input('firstName');
        $trainee->lastName = $request->input('lastName');
        $trainee->email = $request->input('email');
        $trainee->phone = $request->input('phone');
        $trainee->password = Hash::make($request->input('password'));
        $trainee->save();
        $techStack = new TechStack();
        $techStack->trainee_id = $trainee->id;
        $techStack->save();

        // return redirect('/home');
        return redirect()->route('login')->with('success', 'Registered successfully.');
    }
}
