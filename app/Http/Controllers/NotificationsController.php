<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('notifications.index',compact('user'));
    }

    public function show(DatabaseNotification $notification,Request $request)
    {
        $notification->markAsRead();

//        dd($request);
        return redirect($request->query('redirect_url'));
    }
}
