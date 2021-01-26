<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Carbon\Carbon;

class Appointment extends Controller
{
    public function locations ()
    {

        $locations = DB::table('c_locn_cde')
            ->select('locn_cde', 'locn_nme')
            ->get();

        return response()->json($locations, 200);

        // return response()->json($locations, 200);
        
        // return View::make('example', ['locations' => $locations]);

    }

    public function findTheLocation (Request $request)
    {

        $locations = DB::table('c_locn_cde')
            ->where('locn_cde', $request->locn_cde)
            ->value('locn_cde')
            ->get();
        
        return View::make('example', ['locations' => $locations]);

    }

    public function time (Request $request)
    {

        $time = DB::table('c_validtme')
            ->where('locn_cde', $request->locn_cde)
            ->where('day_numb', $request->day_numb)
            ->select('mil_time', 'std_time')
            ->get();
        
        return response()->json($time, 200);

    }

    public function save(Request $request)
    {
        return $request->validate([
            'clnt_nme' => 'required|max:100',
        ]);

        $mil_time = '23:59';
        $cntrl_no = DB::table('c_appointm')
            ->max('cntrl_no');

        if (is_null($cntrl_no)){
            $cntrl_no=0;
        }

        $cntrl_no++;
        $log_time ='11:23:58';

        DB::table('c_appointm')
            ->insert([
                'cntrl_no' => $cntrl_no,
                'log_date' => Carbon::now(),
                'log_time' => $log_time,
                'clnt_nme' => $request->clnt_nme,
                'apnt_dte' => $request->apnt_dte,
                'mil_time' => $request->apnt_tme,
                'locn_cde' => $request->locn_cde,
                'therapst' => $request->therapst,
                'treatmnt' => $request->treatmnt,
                'emailadd' => $request->emailadd
        ]);

    }
}
