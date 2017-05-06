<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use Library\Utilities;
use App\EmployeeModel;

class VehicleController extends Controller
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
			return \View::make('vehicle', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }

    public function updateVehicle()
    {     
        $VehicleID = $this->request->input('VehicleID');
        $Vehicle = $this->request->input('Vehicle');
        
        $content = VehicleModel::updateInfo($VehicleID, $Vehicle);
        
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
    
    public function getALLVehicle()
    { 
        $content = VehicleModel::getALLVehicle();
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->vehicleInfo, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
	
	public function getVehicle()
    { 
		$VehicleID = $this->request->input('VehicleID');
		
        $content = VehicleModel::getVehicle($VehicleID);
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->vehicleInfo, $this->status);
        } else {

			$this->status = 404;
			return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function deleteVehicle()
    {
        $VehicleID = $this->request->input('VehicleID');
                
        $content = VehicleModel::deleteVehicle($VehicleID);
       
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
}
