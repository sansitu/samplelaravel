<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use DB;
use Library\Utilities;
use App\EmployeeModel;

class CommonController extends Controller
{
    protected $request;
	
    protected $status;

    protected $url;
    
    public function __construct(Request $request, UrlGenerator $url) {
        
        $this->request = $request;
        $this->url = $url;
    }
	
	public function index()
    {
		$EmployeeID = $this->request->session()->get('credentials');
		$empDetails = EmployeeModel::getEmployeeInfo($EmployeeID);
		
		if (json_decode($empDetails)->status == "Success") {
			return \View::make('dashboard', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }

    public function getStat()
    {     
		$emp = 0;
		$cust = 0;
		$prod = 0;
		
        $datas = DB::table('customers')
				->where('cust_status', '=', 1)
				->count();

        if ($datas) {
			$cust = $datas;
        } 
		
		$datas = DB::table('employees')
				->where('emp_status', '=', 1)
				->count();

        if ($datas) {
			$emp = $datas;
        } 
		
		$datas = DB::table('products')
				->where('pro_status', '=', 1)
				->count();

        if ($datas) {
			$prod = $datas;
        } 
		
		$statOutput[] = $emp;
		$statOutput[] = $cust;
		$statOutput[] = $prod;
		
		$this->status = 200;
        return Utilities::sendResponse($statOutput, $this->status);
    }
        
    public function logout()
    {
        $request->session()->forget('Customer_Id');
        $request->session()->forget('Email_Id');
        $request->session()->flush();
        \Cache::forget('Customer_Id');
        \Cache::forget('Email_Id');
        
        \Redirect::to('login')->send(); 
    }
    
}
