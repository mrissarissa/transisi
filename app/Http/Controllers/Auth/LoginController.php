<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\User;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function username(){
        return 'nik';
    }

    public function login(Request $request){

        $this->validate($request,[
            'nik' => 'required|string',
            'password' => 'required|string',
        ],[
            'nik.required' => 'NIK is required',
            'password.required' => 'Password is required',
        ]);

        $user = user::Where('nik',$request->nik)->first();

        if (isset($user->nik)) {
            if (auth()->attempt(['nik'=>$request->nik,'password'=>$request->password])) {
                if(auth()->user()->deleted_at!==null){
                    Auth::logout();
                    return redirect()->back()
                        ->withInput($request->only($this->username(), 'remember'))
                        ->withErrors([
                            'password' => 'Akun anda tidak aktif. Silahkan hubungi administrator sistem',
                        ]);
                }
                return redirect()->route('home.index');
            }else{
                Auth::logout();
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        'password' => 'Password Salah, cek kembali . . .',
                    ]);
            }
        }else{
            Auth::logout();
                return redirect()->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors([
                        'password' => 'Akun tidak ditemukan, cek NIK anda kembali',
                    ]);
        }
        
    }

    // public function logout(Request $request){
    //     $this->guard()->logout();

    //     $request->session()->invalidate();
    //     Auth::logout();
    //     redirect('/');
    // }
}
