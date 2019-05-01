<?php

namespace App\Http\Controllers;

use App\Mail\PassResetLink;
use App\Mail\VerifyMail;
use App\PassReset;
use App\User;
use App\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
//use Illuminate\Http\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Image;
use Illuminate\Support\Facades\Input;
use function Sodium\compare;

class UserController extends Controller
{

    public  function  postSignUp(Request $request)
    {
        //$user = User::where('id',4)->first();
        //Log::info($user);
        //Log::info($user->verifyUser);
        //Log::info(VerifyUser::select()->get());
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'first_name' => 'required|max:120',
            'password' => 'required|min:4',
            'confirm_password' => 'required_with:password|same:password'
        ]);

        $email = $request['email'];
        $first_name = $request['first_name'];
        $password = bcrypt($request['password']);

        $user = new User();
        $user->email = $email;
        $user->first_name = $first_name;
        $user->password = $password;
        $user->save();

        $verifyUser = new VerifyUser();
        $verifyUser->user_id = $user->id;
        $verifyUser->token = str_random(40);
        $verifyUser->save();


        //Auth::login($user);
        Mail::to($email)->send(new VerifyMail($user));
        return redirect()->route('userhome')->with("message","We sent the verification link to your email. Please check inbox or spam folder in your email.");
    }

    public  function  postSignIn(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request['email'])->first();
        if(isset($user))
        {
            if($user->verified) {
                if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
                    return redirect()->route('dashboard');
                }
                return redirect()->back()->withErrors('Password is incorrect');
            }else{
                if(!(Auth::validate(['email' => $request['email'], 'password' => $request['password']]))){
                    return redirect()->back()->withErrors('Password is incorrect');
                }
                return redirect()->back()->with('message' , 'Please verify your account. We sent you verification link to your email');
            }
        }
        return redirect()->back()->withErrors('User is not exist, please signup first');
    }

    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('userhome');
    }

    public function getAccount()
    {
        return \view('account', ['user' => Auth::user()]);
    }

    public function updateAccount(Request $request)
    {
        if($request->hasFile())
        {
            return 'true';
        }
        return 'false';
        return Input::hasFile('image');
        $path = $request->image->storeAs('images', 'filename.jpg');
        return $path;
        //return Input::all();
        $this->validate($request, [
            'first_name' => 'required'
        ]);

        $user = Auth::user();

        if($request->file('image')) {
            if (Storage::disk('local')->has('public/' . $user->first_name . '-' . $user->id . '.jpg'))
            {
                Storage::delete('public/' . $user->first_name . '-' . $user->id . '.jpg');
            }
            $imagePath = $request['first_name'] . '-' . $user->id . '.jpg';
            //Log::info($imagePath);
            //$Path = $request->file('image')->storeAs('', $imagePath);
            $Path = $request->file('image')->store('images');
            return $path;
            //$request->file('image')->move(public_path('contacts/import/'), $imagePath);
            //$image = Image::make(Storage::get($Path))->resize(320, 240)->encode();
            //Storage::disk('local')->put($imagePath, $image);
            //Log::info($request->file(''));
            //Storage::putFileAs('public', new File($request->file('image')), 'photo.jpg');
        }
        elseif (Storage::disk('local')->has('public/' . $user->first_name . '-' . $user->id . '.jpg') && $user->first_name !== $request['first_name'])
        {
            Storage::move('public/' . $user->first_name . '-' . $user->id . '.jpg','public/' . $request['first_name'] . '-' . $user->id . '.jpg');
        }
        $user->first_name = $request['first_name'];
        $user->update();
        return redirect()->route('account');
    }

    public function userImage($filename){
        $userfile = Auth::user()->first_name . '-' . Auth::user()->id . '.jpg';
        if($userfile === $filename)
        {
            $file = Storage::disk('local')->get('public/' . $filename);
            return new Response($file,200);
        }
        return 'You are not authorized to access this page';

    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            }else{
                $status = "Your e-mail is already verified. You can now login.";
            }
        }else{
            return redirect()->route('userhome')->withErrors("Sorry your email cannot be identified.");
        }
        return redirect()->route('userhome')->with('message', $status);
    }

    public function changePassword(Request $request)
    {
        $this->validate($request, [
            'currentpassword' => 'required|min:4',
            'new_password' => 'required|min:4',
            'new_confirm_password' => 'required_with:new_password|same:new_password'
        ]);
        $user = Auth::user();
        if(Auth::attempt(['email' => $user->email, 'password' => $request['currentpassword']]))
        {

            $user->password = bcrypt($request['new_password']);
            $user->update();
            return redirect()->back()->with('message','Password successfully changed');
        }
            return redirect()->back()->with('message','Current password is not matching');


    }

    public function passresetToken($token)
    {
        $user = PassReset::where('token',$token)->first();
        if(isset($user))
        {
            $current_time = \Carbon\Carbon::now();
            $token_time = $user->updated_at;
            $difference = $token_time->diffInMinutes($current_time);
            if ($difference <= 60)
            {
                return view('resetPassword')->with('usertoken',$token);

            }
            else
            {
                return redirect()->route('userhome')->withErrors("Token is expired, please resend Password Reset Link");
            }

        }
        return redirect()->route('userhome')->withErrors('Invalid Token');

    }

    public function passresetLink(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|email'
        ]);

        $user = User::where('email', $request['email'])->first();
        //Log::info($user->PassReset);
        if(isset($user))
        {
            if(isset($user->PassReset))
            {
                $passReset = $user->PassReset;
                $passReset->token = str_random(40);
                $passReset->update();
            }
            else
            {

                $passReset = new PassReset();
                $passReset->user_id = $user->id;
                $passReset->token = str_random(40);
                $passReset->save();
            }



            Mail::to($request['email'])->send(new PassResetLink($passReset->User));
            return redirect()->route('userhome')->with("message","We sent the password reset link to your email address. Please check inbox or spam folder in your email.");
        }
        return redirect()->route('resetpass')->withErrors("User not found using email: " . $request['email']);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:4',
            'confirm_password' => 'required_with:password|same:password'
        ]);

        $getuser = PassReset::where('token', $request['_usertoken'])->first();
        //Log::info($user->User->id);

        if(isset($getuser))
        {
            $user = $getuser->User;
            $user->password = bcrypt($request['password']);
            $user->update();
            $getuser->delete();
         return redirect()->route('userhome')->with('message','Password successfully changed');
        }
        return redirect()->back()->withErrors("Invalid token to reset password");

    }

   /* public function showToastMessage($type, $message) {
        $option = [
            "closeButton" => false,
            "debug" => false,
            "newestOnTop" => false,
            "progressBar" => false,
            "positionClass" => "showToast",
            "preventDuplicates" => false,
            "onclick" => null,
            "showDuration" => "300",
            "hideDuration" => "1000",
            "timeOut" => "5000",
            "extendedTimeOut" => "1000",
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut"
        ];
        switch($type){
            case 'info':
                toastr()->info($message,'',$option);
                break;

            case 'warning':
                toastr()->warning($message,'',$option);
                break;

            case 'success':
                toastr()->success($message,'',$option);
                break;

            case 'error':
                toastr()->error($message,'',$option);
                break;
        }
        return;
    }*/
}

