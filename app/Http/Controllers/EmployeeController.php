<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmployeeModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use Library\Utilities;
use App\User;

class EmployeeController extends Controller
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
			return \View::make('employee', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }
	
	public function validLogin()
    {
		$Mobileno = $this->request->input('Mobileno');
        $Password = $this->request->input('Password');
		
		if(($Mobileno) && ($Password)){
            $userData   = User::select('emp_id', 'emp_encryptpassword')
                    ->where('emp_primaryno', $Mobileno)
                    ->where('emp_status', '=', 1)
                    ->take(1)
                    ->get();
					
            if(count($userData)){
				foreach($userData as $uD){
					$usrpassword = $uD->emp_encryptpassword;
					
					//$userInfo = $uD->id.",".$uD->emp_firstname.",".$uD->emp_lastname.",".$uD->emp_type;
					$userInfo = $uD->emp_id;
				}
				
				if (strcmp(trim($Password),trim(decrypt($usrpassword))) == 0) {
					$this->request->session()->put('credentials', $userInfo);
					return redirect('dashboard');
				} else {
					return redirect('/')->with('status', 'Invalid mobile no. or password');
				}				
			} else {
				return redirect('/')->with('status', 'Invalid mobile no. or password');
			}
		}
	}

    public function updateEmployee()
    {     
        $EmployeeID = $this->request->input('EmployeeID');
        $firstname = $this->request->input('firstname');
		$lastname = $this->request->input('lastname');
        $primaryno = $this->request->input('primaryno');
		$alternateno = $this->request->input('alternateno');
        $password = $this->request->input('password');
		$types = $this->request->input('type');
        $statuss = $this->request->input('status');
        
        $content = EmployeeModel::updateInfo($EmployeeID, $firstname, $lastname, $primaryno, $alternateno, $password, $types, $statuss);
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        } else {

            if (json_decode($content)->status == "Conflict") {
				$this->status = 409;
			} else {
				$this->status = 404;
			}
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function getALLEmployee()
    { 
        $content = EmployeeModel::getALLEmployee();
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->employeeInfo, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
	
	public function getEmployee()
    { 
		$EmployeeID = $this->request->input('EmployeeID');
		
        $content = EmployeeModel::getEmployee($EmployeeID);
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->employeeInfo, $this->status);
        } else {

			$this->status = 404;
			return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function deleteEmployee()
    {
        $EmployeeID = $this->request->input('EmployeeID');
                
        $content = EmployeeModel::deleteEmployee($EmployeeID);
       
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function logout()
    {
        $this->request->session()->forget('credentials');
        $this->request->session()->flush();
        \Cache::forget('credentials');
                
        \Redirect::to('/')->send(); 
    }
    
}
