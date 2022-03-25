<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Carbon\Carbon;
use DataTables;

use App\User;
use App\Models\MasterMO;
use App\Models\GarmentId;
use App\Models\Locator;

class DashboardController extends Controller
{
    public function index(){
 		
        return view('dashboard');
    }
}
