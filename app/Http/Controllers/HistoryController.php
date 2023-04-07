<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User_report;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    //fetch history fro the table
    public function fetchReport()
    {
       
        $history = User_report::where('account_no', auth()->user()->account_no)->get();

        // var_dump($history);
        // exit();

        return response()->json([
            'user_reports' => $history,
        ]);

        // $std = User_report::find($id);
        // $report=User_report::all();

        // if ($std && $report) {
        //     return response()->json([
        //             'user_reports' => $report,
        //         ]);
            
        // } else {
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'user not found'
        //     ]);
        // }
    }

    public function deleteReport($id){
        $user_repo = User_report::find($id);
        $user_repo->delete();
        return response()->json([
            'status' => 200,
            'message' => 'report deleted successfully'
        ]);
    }

}
