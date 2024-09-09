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
    public function index()
    {
        $classes = DB::table('t_class_header AS a')
            ->leftJoin('tm_class_category AS b', 'a.class_category_id', '=', 'b.id')
            ->select('a.id', 'a.class_title', 'a.class_desc', 'a.class_period', 'a.start_eff_date', 'a.end_eff_date', 'b.class_category')
            ->where('a.is_active', 1)
            ->orderByDesc('a.id')
            ->paginate(10);

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
        return view('academy_admin.classes.index', compact('classes'));
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

        $tc = DB::table('tm_training_center AS a')
            // ->where('a.is_active', 1) --> belum ada kolom is_active nya
            ->orderBy('a.id', 'asc')
            ->get();
        return view('academy_admin.classes.create', compact('kategori', 'tc'));
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
            'created_by' => Auth::user()->name,
            'created_date' => Carbon::now()
        ];
        $insert_action = DB::table('t_class_header')
            ->insertGetId($insert_data);
        if ($insert_action > 0) {
            return redirect()->route('academy_admin.classes.index')->with('success', 'Berhasil menambahkan data kelas!');
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

        $tc = DB::table('tm_training_center AS a')
            // ->where('a.is_active', 1) --> belum ada kolom is_active nya
            ->orderBy('a.id', 'asc')
            ->get();
        return view('academy_admin.classes.edit', compact('item', 'kategori', 'tc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $classes)
    {
        //
    }
}
