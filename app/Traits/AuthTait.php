<?php
namespace App\Traits;
use Illuminate\Support\Facades\Auth;
trait AuthTait
{
    /**
     * @throws \Exception
     */
  public function userAuthCheck()
  {
      if (!Auth::user())
      {
       throw new \Exception('you should be logged in to use repository');
      }
  }
}

