<?php

namespace App\Http\Controllers\Admin;
use System\Auth\Auth;

  class AdminController
  {
    public function __contruct()
    {
      auth::loginById(1);
      auth::check();

      if(Auth::user()->user_type != 'admin')
      {
        redirect('/login');
        exit;
      }
    }

    public function index()
    {
      return view("admin.index");
    }
  }