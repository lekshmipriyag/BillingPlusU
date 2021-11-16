<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Users;
use App\PasswordResets;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function registerProcessorForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('register_processor');
    }

    public function registerProcessor(Request $request)
    {
        session([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'post_code' => $request->input('post_code'),
            'email' => $request->input('email'),
            'mobile_number' => $request->input('mobile_number')
        ]);

        $this->validate($request,
            [
                'first_name' => 'required|alpha|max:150',
                'last_name' => 'required|alpha|max:150',
                'post_code' => 'required|numeric|digits_between:1,50',
                'email' => 'required|email|unique:users,email|max:150',
                'password' => array(
                    'required',
                    'min:8',
                    'confirmed',
                    'max:150',
                    'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
                ),
                'mobile_number' => 'required|digits_between:1,50',
                'term' => 'required',
                'g-recaptcha-response' => 'required|recaptcha'
            ]
        );

        try {
            $user = new Users;

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->post_code = $request->input('post_code');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->mobile_number = $request->input('mobile_number');
            $user->type = "processor";
            $user->access_level = 1;

            $user->save();
            Auth::login($user);

            session([
                'first_name' => '',
                'last_name' => '',
                'post_code' => '',
                'email' => '',
                'mobile_number' => '',
                'profession' => ''
            ]);

        } catch (\Exception $e) {
            return redirect('register_processor')->with('error', 'Failed!');
        }
        return redirect('/');
    }

    public function registerPersonalForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('register_personal',
            [
                'professions' => [
                    "General Practice",
                    "Dermatology",
                    "General Paediatrics",
                    "General Pathology",
                    "Ophthalmologists",
                    "Psychiatry",
                    "Obstetrics and Gynaecology",
                    "Cardio-thoracic Surgery",
                    "Neurology",
                    "Cardiology",
                    "Intensive Care"
                ]
            ]
        );
    }

    public function registerPersonal(Request $request)
    {
        session([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'post_code' => $request->input('post_code'),
            'email' => $request->input('email'),
            'mobile_number' => $request->input('mobile_number'),
            'profession' => $request->input('profession')
        ]);

        $this->validate($request,
            [
                'first_name' => 'required|alpha|max:150',
                'last_name' => 'required|alpha|max:150',
                'post_code' => 'required|numeric|digits_between:1,50',
                'email' => 'required|email|unique:users,email|max:150',
                'password' => array(
                    'required',
                    'min:8',
                    'confirmed',
                    'max:150',
                    'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
                ),
                'mobile_number' => 'required|digits_between:1,50',
                'profession' => 'required|max:150',
                'term' => 'required',
                'g-recaptcha-response' => 'required|recaptcha'
            ]
        );

        try {
            $user = new Users;

            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->post_code = $request->input('post_code');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->mobile_number = $request->input('mobile_number');
            $user->profession = $request->input('profession');
            $user->type = "personal";
            $user->access_level = 0;

            $user->save();
            Auth::login($user);

            session([
                'first_name' => '',
                'last_name' => '',
                'post_code' => '',
                'email' => '',
                'mobile_number' => '',
                'profession' => ''
            ]);

        } catch (\Exception $e) {
            return redirect('register_personal')->with('error', 'Failed!');
        }
        return redirect('/');
    }

    public function registerPracticeForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('register_practice');
    }

    public function registerPractice(Request $request)
    {
        $this->validate($request,
            [
                'practice_name' => 'required|max:150',
                'first_name' => 'required|alpha|max:150',
                'last_name' => 'required|alpha|max:150',
                'address' => 'required|max:150',
                'post_code' => 'required|numeric|digits_between:1,50',
                'email' => 'required|email|unique:users,email|max:150',
                'password' => array(
                    'required',
                    'min:8',
                    'confirmed',
                    'max:150',
                    'regex:(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'
                ),
                'practice_phone_number' => 'required|digits_between:1,50',
                'mobile_number' => 'required|digits_between:1,50',
                'abn' => 'required|numeric|digits_between:1,50',
                'term' => 'required'
            ]
        );

        try {
            $user = new Users;

            $user->practice_name = $request->input('practice_name');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->address = $request->input('address');
            $user->post_code = $request->input('post_code');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->practice_phone_number = $request->input('practice_phone_number');
            $user->mobile_number = $request->input('mobile_number');
            $user->abn = $request->input('abn');
            $user->type = "pratice";
            $user->access_level = 2;

            $user->save();
            Auth::login($user);
        } catch (\Exception $e) {
            return redirect('register_practice')->with('error', 'Failed!');
        }
        return redirect('/');
    }

    public function loginForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('login');
    }

    public function login(Request $request)
    {

        $this->validate($request,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        if (Auth::attempt(
                [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ],
                $request->input('remember'))
        ){
            return redirect('/');
        }
        return redirect('login')->with('error', 'Invalid Email address or Password');
    }

    public function logout(Request $request)
    {
        if(Auth::check())
        {
            Auth::logout();
            session_unset();
            Session::flush();
            $request->session()->invalidate();
        }
        return redirect('login');
    }

    public function changePasswordForm()
    {
        if(Auth::check())
        {
            return view('change_password',
                [
                    'name' => Auth::user()->first_name,
                    'user_type' => Auth::user()->type
                ]
            );
        }
        return redirect('login');
    }

    public function changePassword(Request $request)
    {
        if(Auth::check())
        {
            $this->validate($request,
                [
                    'password' => array(
                        'required',
                        'min:8',
                        'confirmed',
                        'max:150',
                        'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
                    ),
                ]
            );
            $user = Auth::user();
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return redirect('change_password')->with('success', 'Success!');
        }
        return redirect('login');
    }

    public function forgotPasswordForm()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('forgot_password');
    }

    public function forgotPassword(Request $request)
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        $this->validate($request,
            [
                'email' => 'required|email'
            ]
        );

        $user = Users::where('email', request()->input('email'))->first();
        if (count($user) < 1) {
            return redirect('forgot_password')->with('error', 'Email does not exist!');
        }

        $passwordResets = PasswordResets::where('email', request()->input('email'))->first();
        if (count($passwordResets) < 1) {
            $passwordResets = new PasswordResets;
        }
        $passwordResets->email = $request->input('email');
        $passwordResets->token = Str::random(60);
        $passwordResets->save();

        $link = route('reset_password',
            [
                'token' => $passwordResets->token,
                'email' => urlencode($passwordResets->email)
            ]
        );

        $data = array(
            'title' => "BillingPlusU",
            'head' => "Reset Password Link:",
            'link' => $link,
            'content' => "The link will be expired in 15 minutes"
        );

        Mail::to($user)->send(new MailNotify($data));
 
        if (Mail::failures()) {
            return redirect('forgot_password')->with('error', 'A Network Error occurred. Please try again.');
        }
        return redirect('forgot_password')->with('success', 'Reset link has been sent. Please check your email inbox/spam');
    }

    public function resetPasswordForm(Request $request, $token, $email)
    {
        if(Auth::check())
        {
            return redirect('/');
        }

        $passwordResets = PasswordResets::where('email', urldecode($email))->first();

        if(count($passwordResets) < 1 || $passwordResets->token != $token)
        {
            return redirect('login')->with('error', 'Invalid token!');
        }

        if (now() > $passwordResets->updated_at->addMinutes(15))
        {
            return redirect('login')->with('error', 'Token Expired!');
        }

        return view('reset_password');
    }

    public function resetPassword(Request $request, $token, $email)
    {
        if(Auth::check())
        {
            return redirect('/');
        }

        $passwordResets = PasswordResets::where('email', urldecode($email))->first();

        if(count($passwordResets) < 1 || $passwordResets->token != $token)
        {
            return redirect('login')->with('error', 'Invalid token!');
        }

        if (now() > $passwordResets->updated_at->addMinutes(15))
        {
            return redirect('login')->with('error', 'Token Expired!');
        }

        $this->validate($request,
            [
                'password' => array(
                    'required',
                    'min:8',
                    'confirmed',
                    'max:150',
                    'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
                ),
            ]
        );

        $user = Users::where('email', urldecode($email))->first();
        if (count($user) < 1) {
            return redirect('forgot_password')->with('error', 'User does not exist!');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();
        Auth::login($user);
        $passwordResets->delete();

        return redirect('/');
    }

    public function pricing()
    {
        if(Auth::check())
        {
            return redirect('/');
        }
        return view('pricing');
    }
}
