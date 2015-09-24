<?php

class UserController extends BaseController{
  public static function login(){
      View::make('/user/login.html');
  }
  
  public static function handle_login(){
    $params = $_POST;

    $user = User::authenticate($params['nimi'], $params['salasana']);

    if(!$user){
      View::make('user/login.html');
    }else{
      $_SESSION['user'] = $user->nimi;
      self::get_user_logged_in();

      Redirect::to('/user/tervetuloa');
    }
  }
  
  public static function tervetuloa() {
      View::make('/user/tervetuloa.html');
  }
}
