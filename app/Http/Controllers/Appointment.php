<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
            ->where('locn_cde', $request->locn_cde)
            ->where('day_numb', $request->day_numb)
            ->select('mil_time', 'std_time')
            ->get();

    }

    public function save(Request $request)
    {

        $cntrl_no = $this->maximum_control_number();

        DB::table('c_appointm')
            ->insert([
                'cntrl_no' => $cntrl_no,
                'log_date' => Carbon::now(get_local_time()),
                'log_time' => Carbon::now(get_local_time())->isoFormat('HH:mm'),
                'clnt_nme' => $request->clnt_nme,
                'apnt_dte' => $request->apnt_dte,
                'apnt_tme' => '09:00 AM',
                'mil_time' => $request->apnt_tme,
                'locn_cde' => $request->locn_cde,
                'therapst' => $request->therapst,
                'treatmnt' => $request->treatmnt,
                'emailadd' => $request->emailadd,
                'cel_numb' => $request->cel_numb,
                'location' => get_ip_location()
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

    public function maximum_control_number ()
    {

        $cntrl_no = DB::table('c_appointm')
            ->max('cntrl_no');

        if (is_null($cntrl_no)){
            $cntrl_no=0;
        }

        return $cntrl_no += 1;

    }
}
