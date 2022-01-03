<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /* public function username()
    {
        return 'username';
    } */

    public function login(Request $request)
    {
        $request->validate([
			'username' => ['required'],
			'password' => ['required'],
		]);
        // $credentials = $request->only('username', 'password');
        $username = $request->get('username');
        $password = $request->get('password'); 

        if (Auth::attempt(['username' => $username, 'password' => $password, 'is_verified' => 1])) {
            if(!isset(Auth::user()->student->student_id) && !isset(Auth::user()->faculty->faculty_id)){
                Auth::logout();
                return redirect()->route('login')
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => 'These credentials do not match our records.']);
            }else{
                if(isset(Auth::user()->student->id)){
                    $student = Student::withTrashed()->find(Auth::user()->student->student_id);
                    if($student->trashed()){
                        Auth::logout();
                        return redirect()->route('login')
                        ->withInput($request->only('username', 'remember'))
                        ->withErrors(['username' => 'These credentials do not match our records.']);
                    }
                }else{
                    $faculty = Faculty::withTrashed()->find(Auth::user()->faculty->faculty_id);
                    if($faculty->trashed()){
                        Auth::logout();
                        return redirect()->route('login')
                        ->withInput($request->only('username', 'remember'))
                        ->withErrors(['username' => 'These credentials do not match our records.']);
                    }
                }
            }

            

            return redirect()->route('dashboard');
        }else{
            $user = User::where([
                ['is_verified', '=', 0],
                ['username', '=', $username],
                // ['password', '=', $password],
            ])->exists();
            $message = "These credentials do not match our records.";
            if($user){
                $message = "Your account is under validation.";
            }
            return redirect()->route('login')
                ->withInput($request->only('username', 'remember'))
                ->withErrors(['username' => $message]);
            // return back()->with('alert-danger', 'User not found');
        }
    }
}
