<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($classes_kywd = null)
    {
        $classes = DB::table('t_class_header AS a')
            ->leftJoin('tm_class_category AS b', 'a.class_category_id', '=', 'b.id')
            ->select('a.id', 'a.class_title', 'a.class_desc', 'a.class_period', 'a.start_eff_date', 'a.end_eff_date', 'b.class_category', 'a.is_active')
            // ->where('a.is_active', 1)
            ->orderByDesc('a.id');
        if ($classes_kywd != null) {
            $any_params = [
                'a.class_title',
                'a.class_desc',
                'a.class_period',
                'a.start_eff_date',
                'a.end_eff_date',
                'b.class_category'
            ];
            $classes->whereAny($any_params, 'like', '%' . $classes_kywd . '%');
        }
        $classes = $classes->paginate(10);

        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];

        foreach ($classes as $index => $item) {
            $month_number = intval(explode('-', $classes[$index]->class_period)[1]) - 1;
            $classes[$index]->class_period = $bulan[$month_number] . ' ' . explode('-', $classes[$index]->class_period)[0];
            $classes[$index]->start_eff_date = date('d-m-Y', strtotime($classes[$index]->start_eff_date));
            $classes[$index]->end_eff_date = date('d-m-Y', strtotime($classes[$index]->end_eff_date));
        }
        return view('classes.index', compact('classes', 'classes_kywd'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = DB::table('tm_class_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();
        return view('classes.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kelas' => 'required',
                'kategori_kelas' => 'required',
                'bulan_periode_kelas' => 'required',
                'tahun_periode_kelas' => 'required',
                'periode_efektif_kelas_mulai' => 'required',
                'periode_efektif_kelas_sampai' => 'required',
                // 'tc_kelas' => 'required',
            ],
            [
                'nama_kelas.required' => 'Nama kelas belum terisi.',
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
                'bulan_periode_kelas.required' => 'Bulan periode kelas belum terisi.',
                'tahun_periode_kelas.required' => 'Tahun periode kelas belum terisi.',
                'periode_efektif_kelas_mulai.required' => 'Periode efektif kelas dari belum terisi.',
                'periode_efektif_kelas_sampai.required' => 'Periode efektif kelas sampai belum terisi.',
                // 'tc_kelas.required' => 'Pusat pelatihan belum terisi.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        $class_period = $request->tahun_periode_kelas . '-' . $request->bulan_periode_kelas . '-01';
        $start_eff_date = date('Y-m-d', strtotime($request->periode_efektif_kelas_mulai));
        $end_eff_date = date('Y-m-d', strtotime($request->periode_efektif_kelas_sampai));

        $insert_data = [
            'class_title' => $request->nama_kelas,
            'class_desc' => $request->deskripsi_kelas,
            'class_category_id' => $request->kategori_kelas,
            'class_period' => $class_period,
            'is_active' => 1,
            'start_eff_date' => $start_eff_date,
            'end_eff_date' => $end_eff_date,
            'created_by' => Auth::id(),
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('t_class_header')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            $status = [
                'status' => 'insert',
                'status_message' => 'Berhasil menambah data!'
            ];
            return redirect()->route('classes')->with($status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('t_class_header AS a')
            ->where('a.id', $id)
            ->first();

        $kategori = DB::table('tm_class_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'asc')
            ->get();
        return view('classes.edit', compact('item', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_kelas' => 'required',
                'kategori_kelas' => 'required',
                'bulan_periode_kelas' => 'required',
                'tahun_periode_kelas' => 'required',
                'periode_efektif_kelas_mulai' => 'required',
                'periode_efektif_kelas_sampai' => 'required',
            ],
            [
                'nama_kelas.required' => 'Nama kelas belum terisi.',
                'kategori_kelas.required' => 'Kategori kelas belum terisi.',
                'bulan_periode_kelas.required' => 'Bulan periode kelas belum terisi.',
                'tahun_periode_kelas.required' => 'Tahun periode kelas belum terisi.',
                'periode_efektif_kelas_mulai.required' => 'Periode efektif kelas dari belum terisi.',
                'periode_efektif_kelas_sampai.required' => 'Periode efektif kelas sampai belum terisi.',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        $class_period = $request->tahun_periode_kelas . '-' . $request->bulan_periode_kelas . '-01';
        $start_eff_date = date('Y-m-d', strtotime($request->periode_efektif_kelas_mulai));
        $end_eff_date = date('Y-m-d', strtotime($request->periode_efektif_kelas_sampai));
        $update_data = [
            'class_title' => $request->nama_kelas,
            'class_desc' => $request->deskripsi_kelas,
            'class_category_id' => $request->kategori_kelas,
            'class_period' => $class_period,
            'is_active' => 1,
            'start_eff_date' => $start_eff_date,
            'end_eff_date' => $end_eff_date,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $update_action = DB::table('t_class_header AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_action > 0) {
            $status = [
                'status' => 'update',
                'status_message' => 'Berhasil mengubah data!'
            ];
            return redirect()->route('classes')->with($status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        //
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::id(),
            'modified_date' => Carbon::now()
        ];
        $delete_action = DB::table('t_class_header AS a')
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
        $recover_action = DB::table('t_class_header AS a')
            ->where('a.id', $request->id)
            ->update($recover_data);
        if ($recover_action > 0) {
            return $recover_action;
        } else {
            return 'failed to recover';
        }
    }
}
