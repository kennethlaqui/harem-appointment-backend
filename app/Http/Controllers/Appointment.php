<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redis;
use DB;
use Carbon\Carbon;

class Appointment extends Controller
{
    public function locations (Request $request)
    {

        return DB::table('c_locn_cde')
            ->select('locn_cde', 'locn_nme')
            ->where('stor_nme', $request->stor_nme)
            ->distinct()
            ->get();

    }

    public function time (Request $request)
    {

        return DB::table('c_validtme')
            ->select('mil_time', 'std_time')
            ->where('locn_cde', $request->locn_cde)
            ->where('day_numb', $request->day_numb)
            ->get();

    }

    public function save(Request $request)
    {

        DB::table('c_appointm')
            ->insert([
                'log_date' => Carbon::now(get_local_time()),
                'log_time' => Carbon::now(get_local_time())->isoFormat('HH:mm'),
                'clnt_nme' => $request->clnt_nme,
                'apnt_dte' => $request->apnt_dte,
                'mil_time' => $request->apnt_tme,
                'locn_cde' => $request->locn_cde,
                'therapst' => $request->therapst,
                'treatmnt' => $request->treatmnt,
                'emailadd' => $request->emailadd,
                'cel_numb' => $request->cel_numb,
                'stor_nme' => $request->stor_nme
            ]);

    }

    public function appointments (Request $request)
    {

        return DB::table('c_appointm')
            ->where('c_locn_cde.stor_nme', $request->stor_nme)
            ->join('c_locn_cde', 'c_locn_cde.locn_cde', '=', 'c_appointm.locn_cde')
            ->select('c_appointm.*', 'c_locn_cde.locn_nme')
            ->orderBy('cntrl_no', 'DESC')
            ->get();

    }

}
