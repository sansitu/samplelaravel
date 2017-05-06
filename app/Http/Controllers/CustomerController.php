<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use Library\Utilities;
use App\EmployeeModel;

class CustomerController extends Controller
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
			return \View::make('customer', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }

    public function updateCustomer()
    {     
        $CustomerID = $this->request->input('CustomerID');
        $firstname = $this->request->input('firstname');
		$lastname = $this->request->input('lastname');
        $primaryno = $this->request->input('primaryno');
		$alternateno = $this->request->input('alternateno');
        $statuss = $this->request->input('status');
        
        $content = CustomerModel::updateInfo($CustomerID, $firstname, $lastname, $primaryno, $alternateno, $statuss);
        
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
    
    public function getALLCustomer()
    { 
        $content = CustomerModel::getALLCustomer();
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->customerInfo, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
	
	public function getCustomer()
    { 
		$CustomerID = $this->request->input('CustomerID');
		
        $content = CustomerModel::getCustomer($CustomerID);
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->customerInfo, $this->status);
        } else {

			$this->status = 404;
			return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function deleteCustomer()
    {
        $CustomerID = $this->request->input('CustomerID');
                
        $content = CustomerModel::deleteCustomer($CustomerID);
       
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
}
