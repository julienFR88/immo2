<?php

  namespace App\Http\Controllers\Auth;

  use System\Auth\Auth;

  class LoginController
  {
    private $redirectTo = "/home";
    private $reditectToAdmin = "/admin";

    public function view()
    {
      return view('auth.login');
    }

    public function login()
    {
      Auth::logout();
      $request = new LoginRequest();
    }
  }