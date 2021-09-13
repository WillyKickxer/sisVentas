<?php

namespace sisVentas\Http\Controllers\Auth;

use sisVentas\User;
use Validator;
use sisVentas\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    |Este controlador maneja el registro de nuevos usuarios, así como la autenticación de usuarios existentes. De forma predeterminada, este controlador usa un rasgo simple para agregar estos comportamientos. ¿Por qué no lo exploras?
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     * Dónde redirigir a los usuarios después de iniciar sesión / registrarse.
     * @var string
     */
    protected $redirectTo = '/ventas/venta'; //indica la vista que se mostrará al usuario cada vez que se logue correctamente

    /**
     * Create a new authentication controller instance.
     * Cree una nueva instancia de controlador de autenticación.
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     * Obtenga un validador para una solicitud de registro entrante.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     * Cree una nueva instancia de usuario después de un registro válido.
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        return redirect('login');//cuando intente acceder al formulario de registro redireccionará al login
    }

}
