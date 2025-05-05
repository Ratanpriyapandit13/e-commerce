<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\Category;
use App\Models\Login_otp;
use App\Models\Product;
use App\Models\User;
use App\Services\Msg91Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register(){
        return view('register');
    }


    public function register1(){
        return view('register1');
    }

    public function login(){

        return view('login')->with('is_addCart_page',session('is_addCart_page'));
    }

    public function login1(){
        return view('login1');
    }

    // User dashboard Start Here
    public function index(){
        return view('user/index');
    }

    public function history(){
        return view('user/order-history');
    }

    public function detail(){
        return view('user/detail');
    }

    public function settings(){
        return view('user/settings');
    }

    public function sendOtp(Request $request, Msg91Service $msg91)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $otpCode = rand(100000, 999999);
        $email = $request->email;

        // Update existing OTP or create a new one
        Login_otp::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otpCode,
                'user_id' => null,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]
        );

        try {
            Mail::to( $email)->send(new OtpMail($otpCode));

            if (session('is_addCart_page')) {
                return view('login1',compact('email'))->with('is_addCart_page',session('is_addCart_page'));
            }else{
                return view('login1',compact('email'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);

        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
        ]);

        $otpRecord = Login_otp::where('email', $request->email)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>=', now())
                        ->whereNull('user_id')
                        ->latest()
                        ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP'], 400);
        }

        // Find or create the user
        $user = User::firstOrCreate(['email' => $request->email]);

        // Update the OTP record with the user_id
        $otpRecord->update(['user_id' => $user->id]);

        // Log in the user
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('home');

    }


    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }



}
