<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use App\Mail\MailNotify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function index()
    {
        return view('dashboard.messages.index', [
            'title' => 'Message',
            'messages' => Message::all()
        ]);
    }
    public function emails()
    {
        return view('dashboard.messages.email', [
            'title' => 'Email',
            'emails' => Email::latest()->get()
        ]);
    }

    public function show($id)
    {
        Message::where('id', $id)->update([
            'status' => 'read',
        ]);
        return view('dashboard.messages.show', [
            'title' => 'Message',
            'message' => Message::find($id)
        ]);
    }
    public function show_email($id)
    {
        return view('dashboard.messages.show_email', [
            'title' => 'Email',
            'email' => Email::find($id)
        ]);
    }
    public function write_email()
    {
        return view('dashboard.messages.write_email', [
            'title' => 'Email'
        ]);
    }

    public function reply_message(Request $request)
    {
        $message = Message::find($request->id_message);
       
        Mail::to($message->email)->send(new MailNotify([
                'subject' => $request->subject,
                'to' => $message->email,
                'from' => 'official@toptalentsconsulting.co.id',
                'text' => $request->message,
        ]));

        Message::where('id', $request->id_message)->update([
            'replay' => 'yes',
        ]);

        Email::create([
            'subject' => $request->subject,
            'email' => $message->email,
            'message' => $request->message,
        ]);

        return redirect('/dashboard/emails')->with('success', 'Message has been replied');

    }
    public function send_email(Request $request)
    {
       
        Mail::to($request->email)->send(new MailNotify([
                'subject' => $request->subject,
                'to' => $request->email,
                'from' => 'official@toptalentsconsulting.co.id',
                'text' => $request->message,
        ]));

        Email::create([
            'subject' => $request->subject,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect('/dashboard/emails')->with('success', 'Message has been send');

    }

}
