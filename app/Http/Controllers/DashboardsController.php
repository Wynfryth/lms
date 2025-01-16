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

        switch (Auth::user()->roles->pluck('name')[0]) {
            case "Academy Admin":
                // all enrollment
                $whereParams = [
                    'a.enrollment_status_id' => 1
                ];
                $allEnrollment = DB::table('tr_enrollment AS a')
                    ->where($whereParams)
                    ->whereRaw('YEAR(a.enrollment_date) = ?', [$year])
                    ->count();

                // pass rate
                // -> ambil dari MyClassesController passStatusCheck()

                $compact = compact('dashboardYear', 'allEnrollment');
                break;
            case "Student":
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

                $compact = compact('dashboardYear', 'attendedClasses');
                break;
        }

        return view('dashboard', $compact);
    }
}
