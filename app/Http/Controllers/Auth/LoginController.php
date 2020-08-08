<?php 
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use App\User;
class LoginController extends Controller { 
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
    /*** Where to redirect users after login. 
    ** @var string 
    */
    protected $redirectTo = '/';
    /*** Create a new controller instance. 
    * * @return void 
    */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }
    public function redirectToGithub() {
        return Socialite::driver('github')->redirect();
    }
    public function handleGithubCallback() {
        try {
            $user = Socialite::driver('github')->user();
            $finduser = User::where('github_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect('/');
            } else {
                $newUser = User::create(['name' => $user->name, 'email' => $user->email, 'github_id' => $user->id]);
                Auth::login($newUser);
                return redirect()->back();
            }
        }
        catch(Exception $e) {
            return redirect('auth/github');
        }
    }
} ?>