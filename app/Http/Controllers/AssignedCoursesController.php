<?php

namespace App\Http\Controllers;

use App\Models\AssignedCourses;
use Illuminate\Http\Request;

class AssignedCoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teacher_id,$session_id)
    {
        $assignedCourses = new AssignedCourses();
        $assignedCourses = $assignedCourses->where('teacher_id', '=',$teacher_id)->where('session_id', '=',$session_id)->get();
        return $assignedCourses;
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
        $assignedCourses = new AssignedCourses();
        $assignedCourses->teacher_id = $request->teacher_id;
        $assignedCourses->session_id = $request->session_id;
        $assignedCourses->course_id = $request->course_id;
        if($assignedCourses->save())
        {
            return response()->json([
                'msg' => 200,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssignedCourses  $assignedCourses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $assignedCourses = new AssignedCourses();
        $assignedCourses = $assignedCourses->where('session_id', '=',$id)->get();
        return $assignedCourses;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AssignedCourses  $assignedCourses
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignedCourses $assignedCourses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssignedCourses  $assignedCourses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignedCourses $assignedCourses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssignedCourses  $assignedCourses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $assignedCourses = new AssignedCourses();
        $assignedCourses = $assignedCourses->where('id', '=',$id);
        if($assignedCourses->delete()){
            return response()->json([
                'msg' => 200,
            ]);
        }
    }
}
