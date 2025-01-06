<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardsController extends Controller
{
    public function index($year = null)
    {
        $dashboardYear = $year;
        if ($year) {
        } else {
            $year = date('Y');
        }
        // all enrollment
        $whereParams = [
            'a.enrollment_status_id' => 1
        ];
        $allEnrollment = DB::table('tr_enrollment AS a')
            ->where($whereParams)
            ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
            ->count();

        // all attended classes
        $nip = Auth::user()->nip;
        $whereParams = [
            'a.enrollment_status_id' => 1,
            'a.emp_nip' => $nip
        ];
        $attendedClasses = DB::table('tr_enrollment AS a')
            ->where($whereParams)
            ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
            ->count();

        return view('dashboard', compact('dashboardYear', 'allEnrollment', 'attendedClasses'));
    }
}
