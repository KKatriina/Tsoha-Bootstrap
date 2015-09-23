<?php

class UserController extends BaseController{
  public static function login(){
      View::make('/user/login.html');
  }
  
  public static function handle_login(){
    $params = $_POST;

    $user = User::authenticate($params['username'], $params['password']);

    if(!$user){
      View::make('user/login.html');
    }else{
      $_SESSION['user'] = $user->nimi;

      Redirect::to('/tervetuloa');
    }
  }
  
  public static function tervetuloa() {
      View::make('/user/tervetuloa.html');
  }
}
