<?php

namespace App\Http\Controllers;

use App\Models\ClassCat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ClassCatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classcat = DB::table('tm_class_category AS a')
            ->where('a.is_active', 1)
            ->orderBy('a.id', 'desc')
            ->paginate(10);
        return view('academy_admin.classcat.index', compact('classcat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academy_admin.classcat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classcat = new ClassCat();
        $classcat->class_category = $request->kategori_kelas;
        $classcat->desc = $request->deskripsi_kategori_kelas;
        $classcat->created_by = Auth::user()->name;
        $classcat->created_date = Carbon::now();
        $classcat->save();

        return redirect()->route('academy_admin.classcat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassCat $classCat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->first();
        return view('academy_admin.classcat.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $update_data = [
            'class_category' => $request->kategori_kelas,
            'desc' => $request->deskripsi_kategori_kelas,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->update($update_data);
        if ($update_affected > 0) {
            return redirect()->route('academy_admin.classcat.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return redirect()->route('academy_admin.classcat.index');
        }
    }

    public function delete(Request $request)
    {
        $delete_data = [
            'is_active' => 0,
            'modified_by' => Auth::user()->name,
            'modified_date' => Carbon::now()
        ];
        $update_affected = DB::table('tm_class_category AS a')
            ->where('a.id', $request->id)
            ->update($delete_data);
        if ($update_affected > 0) {
            return $update_affected;
        } else {
            return 'failed to delete';
        }
    }
}
