<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypeModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use Library\Utilities;
use App\EmployeeModel;

class ProductTypeController extends Controller
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
			return \View::make('productType', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }

    public function updateProductType()
    {     
        $ProductTypeID = $this->request->input('ProductTypeID');
        $ProductType = $this->request->input('ProductType');
        
        $content = ProductTypeModel::updateInfo($ProductTypeID, $ProductType);
        
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
    
    public function getALLProductType()
    { 
        $content = ProductTypeModel::getALLProductType();
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->productTypeInfo, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
	
	public function getProductType()
    { 
		$ProductTypeID = $this->request->input('ProductTypeID');
		
        $content = ProductTypeModel::getProductType($ProductTypeID);
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->productTypeInfo, $this->status);
        } else {

			$this->status = 404;
			return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
    public function deleteProductType()
    {
        $ProductTypeID = $this->request->input('ProductTypeID');
                
        $content = ProductTypeModel::deleteProductType($ProductTypeID);
       
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
    
}
