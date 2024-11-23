<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{
    public function usernotifications(Request $request)
    {
        $usernip = Auth::user()->nip;
        $notifications = DB::table('t_notification_receipt AS a')
            ->select('a.id', 'b.notification_title', 'b.notification_content', 'a.read_status')
            ->join('t_notification AS b', 'a.notification_id', '=', 'b.id')
            ->where('a.user_nip', $usernip)
            ->orderByDesc('b.created_date')
            ->get();
        return response()->json($notifications);
    }

    public function readnotifications(Request $request)
    {
        $usernip = Auth::user()->nip;
        $notifications = DB::table('t_notification_receipt AS a')
            ->where('a.user_nip', $usernip)
            ->update(['a.read_status' => 1, 'read_at' => Carbon::now()]);
        return response()->json($notifications);
    }
}
