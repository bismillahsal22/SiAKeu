<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function showFormRegister()
    {
        return view('auth.register');
    }

    public function showFormRegisterWali()
    {
        return view('auth.register_wali');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nohp' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nohp' => $data['nohp'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'akses' => $data['akses'],
        ]);
    }
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Tentukan akses otomatis sebagai 'admin'
        $data = $request->all();
        $data['akses'] = 'admin'; // Menetapkan hak akses admin

        $this->create($data);

        // Redirect ke halaman login setelah pendaftaran
        return redirect()->route('login.admin')->with('success', 'Pendaftaran akun berhasil! Silakan login.');
    }

    public function registerWali(Request $request)
    {
        $this->validator($request->all())->validate();

        // Tentukan akses otomatis sebagai 'wali'
        $data = $request->all();
        $data['akses'] = 'wali'; // Menetapkan hak akses wali

        $this->create($data);

        // Redirect ke halaman login setelah pendaftaran
        return redirect()->route('login.wali')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}