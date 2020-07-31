<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $unreadNotifications = auth()->user()->unreadNotifications()->paginate(10);
        return view('admin.notifications.index', compact('unreadNotifications'));
    }

    public function readAll()
    {
        $unreadNotifications = auth()->user()->unreadNotifications;

        $unreadNotifications->each(function ($n) {
            $n->markAsRead();
        });

        flash('Notificações marcadas como lidas.')->success();
        //return redirect()->route('admin.notifications');
        return redirect()->back();
    }

    public function read($notification)
    {
        $notification = auth()->user()->notifications()->find($notification);
        $notification->markAsRead();
        flash('Notificação marcada como lida.')->success();
        //return redirect()->route('admin.notifications');
        return redirect()->back();
    }
}
