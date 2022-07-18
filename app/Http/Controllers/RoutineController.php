<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $routine = new Routine();
        $routine->session_id      = $request->session_id;
        $routine->day             = $request->day;
        $routine->day_id          = $request->day_id;
        $routine->course_id       = $request->course_id;
        $routine->course_code     = $request->course_code;
        $routine->per_credit      = $request->per_credit;
        $routine->remaning_credit = $request->remaning_credit;
        $routine->total_credit    = $request->total_credit;
        $routine->start_time      = $request->start_time;
        $routine->start_time_id   = $request->start_time_id;
        $routine->end_time        = $request->end_time;
        $routine->end_time_id     = $request->end_time_id;
        $routine->teacher_id      = $request->teacher_id;
        $routine->teacherS_name   = $request->teacherS_name;
        $routine->section_id      = $request->section_id;
        $routine->section         = $request->section;
        $routine->semister        = $request->semister;
        $routine->room_id         = $request->room_id;
        $routine->room_no         = $request->room_no;
        $routine->room_status     = $request->room_status;

        if($routine->save()){
            return response()->json([
                'msg' => 200,
            ]);
        }
        
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function show(Routine $routine,$session)
    {
        $routine = $routine->where('session_id','=',$session)->get();
        return $routine;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function edit(Routine $routine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $routine = new Routine();
        $routine = $routine->where('id','=',$id)->first();
        $routine->day             = $request->day;
        $routine->day_id          = $request->day_id;
        $routine->course_id       = $request->course_id;
        $routine->course_code     = $request->course_code;
        $routine->per_credit      = $request->per_credit;
        $routine->remaning_credit = $request->remaning_credit;
        $routine->total_credit    = $request->total_credit;
        $routine->start_time      = $request->start_time;
        $routine->start_time_id   = $request->start_time_id;
        $routine->end_time        = $request->end_time;
        $routine->end_time_id     = $request->end_time_id;
        $routine->teacher_id      = $request->teacher_id;
        $routine->teacherS_name   = $request->teacherS_name;
        $routine->section_id      = $request->section_id;
        $routine->section         = $request->section;
        $routine->semister        = $request->semister;
        $routine->room_id         = $request->room_id;
        $routine->room_no         = $request->room_no;
        $routine->room_status     = $request->room_status;
        if($routine->update()){
            return response()->json([
                'msg' => 200,
            ]);
        }

      

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Routine  $routine
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $routine = new Routine();
        $routine = $routine->where('id','=',$id)->first();
        if($routine->delete()){
            return response()->json([
                'msg' => 200,
            ]);
        }
    }
}
