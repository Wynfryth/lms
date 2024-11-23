<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyTeachesController extends Controller
{
    public function index($myteaches_kywd = null)
    {
        $nip = Auth::user()->nip;
        $myteaches = DB::table('t_class_session AS a')
            ->select('a.id', 'a.session_name', 'c.class_title', 'a.start_effective_date', 'a.end_effective_date')
            ->selectRaw(DB::raw('COUNT(d.class_session_id) AS jumlah_peserta'))
            ->leftJoin('tm_trainer_data AS b', 'b.id', '=', 'a.trainer_id')
            ->leftJoin('t_class_header AS c', 'c.id', '=', 'a.class_id')
            ->leftJoin('tr_enrollment AS d', 'd.class_session_id', '=', 'a.id')
            ->where('b.nip', $nip)
            ->groupBy('a.id')
            ->orderBy('a.id', 'desc');
        if ($myteaches_kywd != null) {
            $any_params = [
                'b.session_name',
                'c.class_title',
            ];
            $myteaches->whereAny($any_params, 'like', '%' . $myteaches_kywd . '%');
        }
        $myteaches = $myteaches->paginate(10);
        return view('myteaches.index', compact('myteaches', 'myteaches_kywd'));
    }
}
