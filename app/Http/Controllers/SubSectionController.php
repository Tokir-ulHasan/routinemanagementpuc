<?php

namespace App\Http\Controllers;

use App\Models\SubSection;
use Illuminate\Http\Request;

class SubSectionController extends Controller
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
        $subSection = new SubSection();
        $subSection->Subsection = $request->Subsection;
        $subSection->section_id = $request->section_id;
        $subSection->semister = $request->semister;
        $subSection->session_id = $request->session_id;
        if($subSection->save()){
            return response()->json([
                'msg' => 200,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubSection  $subSection
     * @return \Illuminate\Http\Response
     */
    public function show($s_id)
    {
        $subSections = new SubSection();
        $subSections = $subSections->where('session_id','=',$s_id)->get();
        return $subSections;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubSection  $subSection
     * @return \Illuminate\Http\Response
     */
    public function edit(SubSection $subSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubSection  $subSection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubSection $subSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubSection  $subSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubSection $subSection)
    {
        //
    }
}
