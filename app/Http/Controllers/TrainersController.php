<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainersController extends Controller
{
    public function index($trainers_kywd = null)
    {
        $trainers = DB::table('tm_trainer_data AS a')
            ->select('a.id', 'b.id AS employee_id', 'b.nip', 'b.Employee_name', 'b.Organization', 'a.is_active')
            ->selectRaw(DB::raw('GROUP_CONCAT(c.session_name) AS sesi_kelas'))
            ->leftJoin('miegacoa_employees.emp_employee AS b', 'b.nip', '=', 'a.nip')
            ->leftJoin('t_class_session As c', 'c.trainer_id', '=', 'a.id')
            // ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc')
            ->groupBy('a.id');
        if ($trainers_kywd != null) {
            $any_params = [
                'b.nip',
                'b.Employee_name',
                'b.Organization'
            ];
            $trainers->whereAny($any_params, 'like', '%' . $trainers_kywd . '%');
        }
        $trainers = $trainers->paginate(10);
        return view('trainers.index', compact('trainers', 'trainers_kywd'));
    }

    public function create()
    {
        return view('trainers.create');
    }

    public function trainers_selectpicker(Request $request)
    {
        $keyword = $request->term['term'];
        $trainers = DB::table('miegacoa_employees.emp_employee AS a')
            ->select('a.nip', 'a.Employee_name', 'a.Organization')
            ->where('a.Employee_name', 'like', '%' . $keyword . '%')
            ->get();
        return $trainers;
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'instruktur' => 'required',
            ],
            [
                'instruktur.required' => 'Nama instruktur belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $insert_data = [
            'nip' => $request->instruktur,
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_trainer_data')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('trainers')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_trainer_data AS a')
            ->select('a.id', 'b.id AS employee_id', 'b.nip', 'b.Employee_name', 'b.Organization', 'a.is_active')
            ->leftJoin('miegacoa_employees.emp_employee As b', 'b.nip', '=', 'a.nip')
            ->where('a.id', $id)
            ->first();
        return view('trainers.edit', compact('item'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'instruktur' => 'required',
            ],
            [
                'instruktur.required' => 'Nama instruktur belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $update_data = [
            'nip' => $request->instruktur,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('tm_trainer_data')
            ->where('id', $id)
            ->update($update_data);
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('trainers')->with($status);
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('tm_trainer_data AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($delete_action > 0) {
            return $delete_action;
        } else {
            return 'failed to delete';
        }
    }

    public function recover(Request $request)
    {
        $recover_data = [
            'is_active' => 1,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $recover_action = DB::table('tm_trainer_data AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
