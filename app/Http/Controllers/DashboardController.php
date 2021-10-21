<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;	
use Illuminate\Http\Request;
use Auth;
class DashboardController extends Controller
{
   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
		$data['Session']=Auth::user();
	   return view('admin/dashboard/dashboard',$data);
    }

}
