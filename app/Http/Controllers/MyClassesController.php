<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyClassesController extends Controller
{
    public function index($myclasses_kywd = null)
    {
        $nip = Auth::user()->nip;
        $myclasses = DB::table('tr_enrollment AS a')
            ->select('a.id', 'b.session_name', 'c.class_title', 'b.start_effective_date', 'b.end_effective_date', 'd.enrollment_status')
            ->leftJoin('t_class_session AS b', 'b.id', '=', 'a.class_session_id')
            ->leftJoin('t_class_header AS c', 'c.id', '=', 'b.class_id')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->where('a.emp_nip', $nip)
            ->orderBy('a.id', 'desc');
        if ($myclasses_kywd != null) {
            $any_params = [
                'b.session_name',
                'c.class_title',
                'd.enrollment_status'
            ];
            $myclasses->whereAny($any_params, 'like', '%' . $myclasses_kywd . '%');
        }
        $myclasses = $myclasses->paginate(10);
        return view('myclasses.index', compact('myclasses', 'myclasses_kywd'));
    }
}
