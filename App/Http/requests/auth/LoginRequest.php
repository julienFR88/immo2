<?php

  namespace App\Http\Requests\Auth;

  use System\Request\Request;

  class LoginController extends Request
  {
    protected function rules()
    {
    return [
        'email' => "required|max:64|email",
        'password' => "required
      ];
    }
}