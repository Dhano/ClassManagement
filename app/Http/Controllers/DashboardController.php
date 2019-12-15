<?php

namespace App\Http\Controllers;

use App\Mail\FollowUpReminder;
use App\Services\StaffService;
use App\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{


    public function __construct()
    {

    }
    //
    public function index(){

        $user = Auth::user();

        if($user->hasRole('Admin')){
            return view('dashboard.admin');
        } else{
            abort(404);
        }
    }

    public function mail(){
        Mail::to('dhananjay62.dg@gmail.com')->send(new FollowUpReminder(10));
    }
}
