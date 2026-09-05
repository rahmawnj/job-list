<?php

namespace App\Http\Controllers;

use App\Mail\SignUp;
use App\Mail\MailNotify;
use App\Http\Controllers\Controller;
use App\Models\Mail;
use Illuminate\Support\Facades\Mail as MailLib;

class MailController extends Controller
{
    public function send_mail()
    {
            MailLib::to('rahmawnj4@gmail.com')->send(new MailNotify([
                'subject' => 'Balasan Email',
                'from' => 'official@toptalentsconsulting.co.id',
                'text' => 'officicla',
            ]));
    }
    public function message_send_mail()
    {
            MailLib::to('rahmawnj4@gmail.com')->send(new MailNotify([
                'subject' => 'Balasan Email',
                'from' => 'official@toptalentsconsulting.co.id',
                'text' => 'officicla',
            ]));
    }

    public function sendMail()
    {
        $name = 'Rahma';
        MailLib::to('rahmawnj4@gmail.com')->send(new SignUp($name));
        return view('welcome');
    }
}
