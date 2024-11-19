<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantsController extends Controller
{
    public function index($participant_kywd = null)
    {
        // $participants = DB::table('miegacoa_employees.emp_employee AS a')
        //     ->select('a.nip', 'a.Employee_name', 'a.Organization', 'a.Position_Nama', 'a.Branch_Name')
        //     ->orderByDesc('a.Join_Date')
        //     ->orderBy('a.Employee_name', 'asc');
        // if ($participant_kywd != null) {
        //     $any_params = [
        //         'a.nip',
        //         'a.Employee_name',
        //         'a.Organization',
        //         'a.Position_Nama',
        //         'a.Branch_Name'
        //     ];
        //     $participants->whereAny($any_params, 'like', '%' . $participant_kywd . '%');
        // }
        // $participants = $participants->paginate(10);
        // return view('participant.index', compact('participants', 'participant_kywd'));
    }
}
