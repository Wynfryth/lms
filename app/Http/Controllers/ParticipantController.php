<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $participant = DB::table('miegacoa_employees.emp_employee AS a')
            ->orderByDesc('a.Join_Date')
            ->orderBy('a.Employee_name', 'asc')
            ->offset(0)
            ->limit(10)
            ->get();
        $participant_sum = DB::table('miegacoa_employees.emp_employee AS a')
            ->count();
        $participant_page_numbers = intval($participant_sum / 10);
        $current_page = 1;
        return view('academy_admin.participant.index', compact('participant', 'participant_sum', 'participant_page_numbers', 'current_page'));
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
    public function show(Participant $participant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        //
    }

    public function delete(Request $request) {}

    public function recover(Request $request) {}
}
