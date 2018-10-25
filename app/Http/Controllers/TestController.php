<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailVerificationNotification;
class TestController extends Controller
{
    public function index(){
        dd(111);
    }
}
