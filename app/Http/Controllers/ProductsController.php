<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\ProductTypeModel;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use Storage;
use Session;
use Library\Utilities;
use App\EmployeeModel;

class ProductsController extends Controller
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
			return \View::make('product', array( "employeeInfo" => json_decode($empDetails)->employeeInfo));
		} else {
			$this->logout();
		}
    }

	public function getALLProduct()
    { 
        $content = ProductModel::getALLProduct();
        
        if (json_decode($content)->status == "Success") {

            $this->status = 200;
            return Utilities::sendResponse(json_decode($content)->productInfo, $this->status);
        } else {

            $this->status = 404;
            return Utilities::sendResponse(json_decode($content)->message, $this->status);
        }
    }
}
