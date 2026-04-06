<?php

namespace App\Http\Controllers;

use App\Mail\NameOfMailer;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    // public function send()
    // {
    //     $users = User::all();

    //     foreach ($users as $user) {
    //         $mailData = [
    //             'title' => 'Welcome, ' . $user->name . '!',
    //             'body'  => 'Your account was created successfully on ' . now()->format('F j, Y') . '.',
    //         ];

    //         Mail::to('yousefkhafif35@gmail.com')->send(new NameOfMailer($mailData)); //if i want to sen to all user email i need to do this $user->email
    //     }

    //     return "Emails sent to all " . $users->count() . " users!";
    // }

    public function send()
    {
       Mail::to("kun443756@gmail.com")->send(new NameOfMailer());
        return "Email sent successfully!";
    }
}
