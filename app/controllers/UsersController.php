<?php
class UsersController extends BaseController {




public function getIndex() {



	/*Mail::send('emails.auth.test' , array('name' , 'Fouad') , function($message){
		$message->to('fo2ad.mahmoud@gmail.com' , 'fouad email' )->subject('test email');
	});*/
	return View::make('hello');
}




public function postCreate() {

	$username = Input::get('username');
	$email = Input::get('email');
	$password = Input::get('password');


	//  code
	$code = str_random(60);

	$user  = new User;
	$user->username = $username;
	$user->email = $email;
	$user->password = Hash::make($password);
	$user->code = $code;
	$user->active = 0;
	
	if($user->save()){

		//send email

 		Mail::send('emails.auth.test' , array('link'=> URL::route('account-activate' , $code) , 'username'=>$username) , function($message) use ($user) {
 
             $message->to($user->email , $user->username)->subject('activate your account');
 

		});



	   return Redirect::to('users/index')
	                  ->with('yes' , 'account has ben created pleas activated it ');

	}


}


/*

$remember  = (Input::has('remember')) ? true : false;

*/


public function getActivate($code) {


	$user  = User::where('code' , '=' , $code)->where('active' , '='  ,0);

	if($user->count()) {
		$user = $user->first();

		//  update user  activate 
		$user->active = 1;
		$user->code = '';
		 if($user->save()) {


		 	return Redirect::to('users/index')->with('yes' , 'account activate done u can now login ');


		 }
	}

	return Redirect::to('users/index')->with('yes' , 'we coulnt activate ur account yet pleas try again later ');

}


public function getRecover() {

	return View::make('recover');
}


public function postRecover() {

	$user  = User::where('email' , '=' , Input::get('email'));

	if($user->count()) {

		$user  =  $user->first();
		/////  Generate Password

		$code       =  str_random(60);
		$password   =  str_random(10);
          
          $user->code  = $code;
          $user->password_temp = Hash::make($password);

          if($user->save()) {

		    Mail::send('emails.auth.recover' , array('link'=>URL::route('account-forget',$code)  ,'username'=>$user->username , 'password'=>$password) , function($message) use ($user)  {
           
             $message->to($user->email , $user->username)->subject('recovery password');
		    });

	      return Redirect::to('users/index')
	      ->with('yes' , 'we send the password to ur email pleas check it');

          }



	}

	return Redirect::to('users/index')
	->with('yes' , 'the email not found');
}


public function getForget($code) {
	

	$user = User::where('code' , '=' , $code)
	                ->where('password_temp' , '!=' , '');

	     if($user->count()) {

	     	$user = $user->first();

	     	$user->password  = $user->password_temp;
	     	$user->password_temp = '';
	     	$user->code      =   '';

	     	if($user->save()) {
	     			return Redirect::to('users/index')
	         ->with('yes' , 'now u can log in with new generated password');

	     	}
	     }
	     	   	return Redirect::to('users/index')
	         ->with('yes' , 'somthing went wrong');           

}







}
?>