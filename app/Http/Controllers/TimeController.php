<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;

class TimeController extends Controller
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
        $times = new Time();

        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $interval_time = $request->interval_time;
        $session_id = $request->session_id;
        $timeArray = $this->generateTime($start_time,$end_time,$interval_time,$session_id);
        
        $times = $times->insert($timeArray);

        if($times)
        {
            return response()->json([
                'msg' => 200,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function show($s_id)
    {
        $times = new Time();
        $times = $times->where('session_id', '=',$s_id)->get();
        return $times;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function edit(Time $time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Time $time)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Time  $time
     * @return \Illuminate\Http\Response
     */
    public function destroy(Time $time)
    {
        //
    }


    public function generateTime($startTime,$endTime,$intervalTime,$session_id){
        $start_t = $startTime;
        $end_t   = $endTime;
        $interval_t = $intervalTime;

        $startTe  = explode (":", $start_t);
        $endTe  = explode (":", $end_t);
        $intervalTe  = explode (":", $interval_t);

        $timeArray = [];

        $intervalP1 = 0;
        $intervalP2 = 0;
        if($intervalTe[0] != 00 ){
            $intervalP1 = $intervalTe[0];
        }
        if($intervalTe[1] != 00 ){
            $intervalP2 = $intervalTe[1]/60;
        }
        $interval = $intervalP1+$intervalP2;
        for($i=$startTe[0];$i<=$endTe[0];$i=$i+$interval){
            $hour = (int)$i;
            $min = ($i - $hour)*60;
            $concate = (string)$min;
            if(strlen($concate) <2){
            $concate = $concate.'0'; 
            }
            if($hour < 12){
                $time['time'] = $hour.":".$concate." AM";
            }
            if($hour >= 12){
                if($hour == 12){
                    $time['time'] = $hour.":".$concate." PM";
                }
                else{
                    $hour = $hour%12;
                    $time['time'] = $hour.":".$concate." PM";
                }
            }
            $time['session_id'] = $session_id;
            $timeArray[] = $time;
        }
        return $timeArray;
    }
}
