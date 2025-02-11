<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function index($employees_kywd = null)
    {
        $employees = DB::table(config('custom.employee_db') . '.emp_employee AS a')
            ->select('a.nip', 'a.Employee_name', 'a.Organization', 'a.Position_Nama', 'a.Branch_Name')
            ->orderByDesc('a.Join_Date')
            ->orderBy('a.Employee_name', 'asc');
        if ($employees_kywd != null) {
            $any_params = [
                'a.nip',
                'a.Employee_name',
                'a.Organization',
                'a.Position_Nama',
                'a.Branch_Name'
            ];
            $employees->whereAny($any_params, 'like', '%' . $employees_kywd . '%');
        }
        $employees = $employees->paginate(10);
        return view('employees.index', compact('employees', 'employees_kywd'));
    }
}
