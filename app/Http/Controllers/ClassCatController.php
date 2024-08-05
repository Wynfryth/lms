<?php

namespace App\Http\Controllers;

use App\Models\ClassCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ClassCatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classcat = ClassCat::orderByDesc('id')->paginate(10);
        // dd($classcat);
        return view('academy_admin.classcat.index', compact('classcat'));
        // $routename = Route::currentRouteName();
        // dd($routename);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(ClassCat $classCat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassCat $classCat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassCat $classCat)
    {
        //
    }
}
