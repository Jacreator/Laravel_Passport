<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
//    Send mail
    public function sendMail()
    {
        Mail::to('petersammy7070@gmail.com')->send(new OrderShipped());
    }
}
