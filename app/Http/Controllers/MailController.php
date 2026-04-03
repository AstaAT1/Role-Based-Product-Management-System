<?php

namespace App\Http\Controllers;

use App\Mail\NameOfMailer;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        Mail::to('[email protected]')->send(
            new NameOfMailer(
                'Welcome from Laravel',
                'Hadi hiya awel message men project dialek.'
            )
        );

        return 'Mail envoyée / tsiftat';
    }

    public function preview()
    {
        return new NameOfMailer(
            'Preview Mail',
            'Hadi ghir preview bach tchouf design qbel ma tsift.'
        );
    }
}
