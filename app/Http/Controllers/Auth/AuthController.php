<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Request as Rq;
use Session;


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
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }


    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'logout']);
    }


    /**
     * Show the application login form.
     *
     * @codeCoverageIgnore
     * @return \Illuminate\Http\Response
     *
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password')))
        {
            return redirect('/home');
        }

        return redirect('/login')->withErrors([
            'email' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }


    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $data             = $request->all();
        $data['password'] = bcrypt($data['password']);

        // is user email domain blocked?
        if ($this->isBlockedDomain($data['email'])) {
            $validator->getMessageBag()->add('email', (string)trans('validation.invalid_domain'));
            $this->throwValidationException(
                $request, $validator
            );
        }


        Auth::login($this->create($request->all()));

        // get the email address
        if (Auth::user() instanceof User) {
            $email     = Auth::user()->email;
            $address   = route('index');
            $ipAddress = $request->ip();
            // send email.
            try {
                Mail::send(
                    ['emails.registered-html', 'emails.registered'], ['address' => $address, 'ip' => $ipAddress], function (Message $message) use ($email) {
                    $message->to($email, $email)->subject('Welcome to Firefly III! ');
                }
                );
            } catch (\Swift_TransportException $e) {
                Log::error($e->getMessage());
            }

            // set flash message
            Session::flash('success', 'You have registered successfully!');
            Session::flash('gaEventCategory', 'user');
            Session::flash('gaEventAction', 'new-registration');

            // first user ever?
            if (User::count() == 1) {
                $admin = Role::where('name', 'owner')->first();
                Auth::user()->attachRole($admin);
            }


            return redirect($this->redirectPath());
        }
        // @codeCoverageIgnoreStart
        abort(500, 'Not a user!');


        return redirect($this->redirectPath());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $host = Rq::getHttpHost();

        return view('auth.register', compact('host'));
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
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
}
