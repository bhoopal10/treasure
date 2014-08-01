<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 5/18/14
 * Time: 7:57 PM
 */

class AccountController extends BaseController
{
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));

    }

    public function getCreate()
    {
        return View::make('account.create');
    }
    public function postCreate()
    {
        $validator=Validator::make(Input::all(),
            array(
                'email'=>'required|max:50|email|unique:users',
                'user'=>'required|max:50|unique:users',
                'name'=>'required|max:50|alpha',
                'password'=>'required|min:4',
                'confirm_password'=>'required|same:password',
                'mobile'=>'required|numeric|digits:10',
                

            )
        );

        $email=Input::get('email');
        $name=Input::get('name');
        
        $college=Input::get('college_name');
        $username=Input::get('user');
        $password=Hash::make(Input::get('password'));
        $rawPassword=Input::get('password');
        $mobile=Input::get('mobile');
       
        $profile=Input::get('profile');
        $code=str_random(60);
        if($validator->fails())
        {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        else{
                /*creating rows to multiple table so here use in transaction*/
                DB::beginTransaction();
                   $id=DB::table('users')->insertGetId(array(
                       'displayName'=>$name,
                       'userName'=>$username,
                       'password'=>$password,
                       'email'=>$email,
                       'code'=>$code,
                       'profilesId'=>$profile,
                       'IsActive'=>'Y',
                   ));
                   if(!$id)
                   {
                    DB::rollback();
                     return Redirect::back()->with('error','Your account not created please try again');
                   }
          
                   /*the following code for email confirmation to activate account*/
                   // Mail::send('emails.auth.activate',array('link'=>URL::to('account/activate',$code),'displayName'=>$first_name,'username'=>$username),function($message) use ($email,$first_name) {
                      // $message->to($email,$first_name)->subject('Activation Code');
                   // });
                   /* automatic activation*/
    //               return $this->getActivate($code);
                   /* after sending email it is redirect */


                   $contact=DB::table('contact')->insert(array(
                    'mobile'=>$mobile,
                    'user_id'=>$id,
                    'updated_at'=>Date('Y-m-d H:i:s')
                    ));
                   if(!$contact)
                   {
                        DB::rollback();
                         return Redirect::back()->with('error','Your account not created please try again');
                   }
                   // $college=DB::table('college')->insert(array(
                   //  'name'=>$college,
                   //  'admin_email'=>$email,
                   //  'user_id'=>$id,
                   //  'updated_at'=>Date('Y-m-d H:i:s')
                   //  ));

                   // if($college)
                   // {
                   //      DB::commit();
                   //      return Redirect::to('account/login')->with('success','Account created successfully and contact admin for activation ');
                   // }
                   else
                   {
                        DB::commit();
                         /* Greeting message from website to user Email*/
                         Mail::send('emails.greeting.new_user',array('displayName'=>$name,'username'=>$username,'password'=>$rawPassword),function($message) use($email,$name){
                            $message->to($email,$name)->subject('Treasure @ College Fever Registration Details');
                         });
                        /*end Greeting message*/
                       return Redirect::to('account/login')->with('success','Account created successfully ');
                   }
            }
            
        }

    public function getLogin()
    {
        return View::make('account.login');
    }
    public function postLogin()
    {
        $data=Input::all();
        $validator=Validator::make($data,
            array(
           'username'=>'required',
            'password'=>'required'
        ));
        if($validator->fails())
        {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        else{
            $remember=(Input::has('remember'))? true : false;
            $username=$data['username'];
            $password=$data['password'];
            $active='Y';
            $field=filter_var($username,FILTER_VALIDATE_EMAIL)?'email':'userName';
            if(Auth::attempt(array($field=>$username,'password'=>$password,'IsActive'=>$active),$remember))
            {
                $mod=Auth::getProfile();
                Session::get('login_redirect') ? $url = Session::get('login_redirect') : $url = URL::to('/').'/'.$mod;
                // echo $mod. "<>".$url;exit;
                Session::put('developers.userId',Auth::user()->id);
                return Redirect::to($url)
                            ->with('login_redirect',Session::forget('login_redirect'));
            }
            else{
                return Redirect::back()->withInput()
                    ->withErrors(array('error'=>'Username or password incorrect'))
                    ->with('error','Username or password incorrect');
            }
        }

    }

    public function getLogout()
    {
        Auth::logout();
        Session::forget('login_redirect');
        return Redirect::to('/')
            ->with('success','Your successfully logged out');
    }
    public function getActivate($code)
    {
        $data['id']=$code;
       $validator=Validator::make($data,array('id'=>'alpha_num|min:60|max:60'));
        if($validator->fails())
        {
            return Response::view('errors.missing', array(), 404);
        }

        $user=User::where('code','=',$code)->where('IsActive','=','N');
        if($user->count()){
            $user=$user->first();
            //Update your user to active state
            $user->IsActive='Y';
            $user->code='';
            if($user->save()){
                return Redirect::to('account/login')->with('success','Your account activated! you can login');
            }
        }
        return Redirect::to('/')->with('error','We could not activate your account. Try again');

    }
    public function getChangePassword()
    {
        if(Auth::check())
        {
            return View::make('account.ChangePassword');
        }
        else{
            return Redirect::to('account/login');
        }

    }

    public function postChangePassword()
    {
        $validator=Validator::make(Input::all(),
            array(
               'old_password'=>'required',
                'new_password'=>'required|min:6',
                'confirm_password'=>'required|same:new_password'
            ));
        if($validator->fails())
        {
            return Redirect::back()
                ->withInput()
                ->withErrors($validator);
        }
        else{
            $user=User::find(Auth::user()->id);
            $old_password=Input::get('old_password');
            $new_password=Input::get('new_password');
            if(Hash::check($old_password,$user->getAuthPassword()))
            {
                $user->password=Hash::make($new_password);
                if($user->save())
                {
                    $mod=Auth::getProfile();
                    return Redirect::to("/$mod")
                        ->with('success','Your password has been changed.');
                }
                else{
                    return Redirect::back()
                        ->with('error','Your password could not change');
                }
            }
            else{
                return Redirect::back()
                    ->with('error','Your old password incorrect');
            }
        }
        return Redirect::back()
            ->with('error','Your password could not change');
    }
    public function getCreatePassword()
    {
        return View::make('account.CreatePassword');

    }

    public function getForgetPassword()
    {
        return View::make('account.ForgetPassword');
    }
    public function postForgetPassword()
    {
        $validator=Validator::make(Input::all(),array(
            'email'=>'required|email'
        ));
        if($validator->fails())
        {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $user=User::where('email','=',Input::get('email'));
            if($user->count())
            {
                $email=Input::get('email');
                $user=$user->first();
                $user_name=$user->userName;
                $displayName=$user->displayName;
                $password=str_random(10);
                $user->code=str_random(60);
                $user->password_tmp=Hash::make($password);
                $code=$user->code.$password;
                if($user->save())
                {
                     Mail::send('emails.auth.ForgetPassword',array('link'=>URL::to('account/recover',$code),'displayName'=>$displayName,'username'=>$user_name,'password'=>$password),function($message) use($email,$user_name) {
                       $message->to($email,$user_name)->subject('Your new password');
                    });
                   
                    return Redirect::to('/')
                        ->with('success','Your new password sent to your mail ');
                }
            }
            else{
              return Redirect::back()
                  ->with('error','Email ID not found. Please enter registered Email ID');
            }
        }
    }

    public function getRecover($code)
    {
        $data['id']=substr($code,0,60);
        $password=substr($code,60,70);
        $data['password']=$password;
        $validator=Validator::make($data,array('id'=>'alpha_num|min:60|max:60','password'=>'alpha_num|min:10|max:10'));
        if($validator->fails())
        {
           App::abort(404);
        }

        $user=User::where('code','=',$data['id'])
            ->where('password_tmp','!=','');
        if($user->count())
        {
            $user=$user->first();
            $user->password=$user->password_tmp;
            $user->password_tmp='';
            $user->code='';
            if($user->save())
            {
                if(Auth::attempt(array('email'=>$user->email,'password'=>$data['password'])))
                {
                    Session::flash('password',$password);
                    return Redirect::to('account/create-password');
                }

            }
            else{
                return Redirect::back()
                    ->with('error','Could not request new password');
            }
        }
        else{
            return Redirect::back()
                ->with('error','Could not request new password');
        }
    }
    public function getPpt()
    {
       echo Auth::user()->id;
    }


}
