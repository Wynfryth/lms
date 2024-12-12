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
            ->select('a.id', 'b.id AS class_id', 'b.class_title', 'b.class_desc', 'b.start_eff_date', 'b.end_eff_date', 'd.enrollment_status')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.session_name) AS session_name'))
            ->leftJoin('t_class_header AS b', 'b.id', '=', 'a.class_id')
            ->leftJoin('t_class_session AS c', 'c.class_id', '=', 'b.id')
            ->leftJoin('tm_enrollment_status AS d', 'd.id', '=', 'a.enrollment_status_id')
            ->where('a.emp_nip', $nip)
            ->orderBy('a.id', 'desc')
            ->groupBy('a.id');
        //  ->toSql();
        // dd($myclasses);
        if ($myclasses_kywd != null) {
            $any_params = [
                'b.class_title',
                'b.class_desc',
                'd.enrollment_status'
            ];
            $myclasses->whereAny($any_params, 'like', '%' . $myclasses_kywd . '%');
        }
        $myclasses = $myclasses->paginate(10);
        return view('myclasses.index', compact('myclasses', 'myclasses_kywd'));
    }
}
