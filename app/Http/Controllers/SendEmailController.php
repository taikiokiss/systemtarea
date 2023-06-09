<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Mail\NotifyMail;
use Mail;
 
class SendEmailController extends Controller
{
     
    public function sendEmail()
    {
 
      Mail::to('sistemas@degeremcia.com')->send(new NotifyMail());
 
    } 
}