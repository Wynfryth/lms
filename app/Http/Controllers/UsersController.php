<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index($user_kywd = null)
    {
        $users = DB::table('users AS a')
            ->select('a.id, a.name, a.');
        if ($user_kywd != null) {
            $any_params = [
                'a.class_title',
                'a.class_desc',
                'a.class_period',
                'a.start_eff_date',
                'a.end_eff_date',
                'b.class_category'
            ];
            $users->whereAny($any_params, 'like', '%' . $user_kywd . '%');
        }
        $users = $users->paginate(10);
        return view('user.index', compact('users', 'user_kywd'));
    }
}
