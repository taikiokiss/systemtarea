<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Mail\NotifyMail;
use Mail;
use App\Task;
class SendEmailController extends Controller
{
     
    public function sendEmail(Request $request)
    {
      Mail::to('elmaic_14@hotmail.com')->send(new NotifyMail());
    } 

    public function send() 
    {
      $user = User::first();
  
        $project = [
            'greeting' => 'Hi '.$user->email.',',
            'body' => 'This is the project assigned to you.',
            'thanks' => 'Thank you this is from codeanddeploy.com',
            'actionText' => 'View Project',
            'actionURL' => url('/'),
            'id' => 57
        ];
  
        Notification::send($user, new EmailNotification($project));
   
        dd('Notification sent!');
    }


}