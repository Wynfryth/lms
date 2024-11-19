<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrainCtsController extends Controller
{
    public function index($traincts_kywd = null)
    {
        $traincts = DB::table('tm_training_center AS a')
            ->select('a.id', 'a.tc_name', 'a.tc_address', 'a.note', 'a.is_active')
            // ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc');
        if ($traincts_kywd != null) {
            $any_params = [
                'a.tc_name',
                'a.tc_address',
                'a.note'
            ];
            $traincts->whereAny($any_params, 'like', '%' . $traincts_kywd . '%');
        }
        $traincts = $traincts->paginate(10);
        return view('traincts.index', compact('traincts', 'traincts_kywd'));
    }

    public function create()
    {
        return view('traincts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tc_name' => 'required',
                'tc_address' => 'required',
                'tc_note' => 'required'
            ],
            [
                'tc_name.required' => 'Nama training center belum terisi.',
                'tc_address.required' => 'Alamat training center belum terisi.',
                'tc_note.required' => 'Catatan training center belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $insert_data = [
            'tc_name' => $request->tc_name,
            'tc_address' => $request->tc_address,
            'note' => $request->tc_note,
            // 'is_active' => $request->is_active,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('tm_training_center')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('traincts')->with($status);
        }
    }

    public function edit($id)
    {
        $item = DB::table('tm_training_center AS a')
            ->where('a.id', $id)
            ->first();
        return view('traincts.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'tc_name' => 'required',
                'tc_address' => 'required',
                'tc_note' => 'required'
            ],
            [
                'tc_name.required' => 'Nama training center belum terisi.',
                'tc_address.required' => 'Alamat training center belum terisi.',
                'tc_note.required' => 'Catatan training center belum terisi.'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $update_data = [
            'tc_name' => $request->tc_name,
            'tc_address' => $request->tc_address,
            'note' => $request->tc_note,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_training_center AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_affected > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('traincts')->with($status);
        }
    }
    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_training_center AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return $update_affected;
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
        $update_affected = DB::table('tm_training_center AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to recover';
        }
    }
}
