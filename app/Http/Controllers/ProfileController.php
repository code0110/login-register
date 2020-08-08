<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        if (Auth::user())
        {
            $user = User::find(Auth::user()->id);
            // dd($user = User::find(Auth::user()->id)->id);
            if ($user)
            {
                return view('profile.edit')->withUser($user);
            }
            else
            {
                return redirect()->back();
            }
        }

    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if ($user)
        {

            if (Auth::user()->email === $request['email'])
            {
                $validate = $request->validate(['name' => 'required|min:2', 'email' => 'required|email']);
            }
            else
            {
                $validate = $request->validate(['name' => 'required|min:2', 'email' => 'required|email|unique:users']);
            }



            $avatar = $request->file('avatar');
            if ($avatar) {
               $filename = time() . '.' . $avatar->getClientOriginalExtension();
               $extension = $request
                ->avatar
                ->extension();
            \Image::make($avatar)->resize(300, 300)
                ->save(public_path('/uploads/avatars/') . $filename);
                 $user->avatar = $filename;
            }        

            $user->name = $request['name'];
           
            $user->email = $request['email'];
            $user->password = $request->has('password') ? bcrypt($request->password) : $user->password;
            $user->save();
            return redirect()->back();

        }
        else
        {
            return redirect()->back();
        }

    }
}

