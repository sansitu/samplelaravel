<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use DB;
use Mail;

class CustomerModel extends Model
{   
    public static function updateInfo($CustomerID, $firstname, $lastname, $primaryno, $alternateno, $status)
    {	     
		$datas = DB::table('customers')
				->where('cust_primaryno', '=', $primaryno)
				->where('cust_status', '=', 1)
				->get();
				
		if (trim($CustomerID) != "") {
				
				$updatedata = array('cust_firstname' => $firstname, 
									'cust_lastname' => $lastname, 
									'cust_primaryno' => $primaryno, 
									'cust_secondaryno' => $alternateno,
									'cust_status' => $status,
									);
									
				DB::table('customers')->where('cust_id', '=', $CustomerID)
										->update($updatedata);
				
				$output = array("status" => "Success", "message" => 'Customer info has been updated');
		} else {

				$insertdata = array('cust_firstname' => $firstname, 
									'cust_lastname' => $lastname, 
									'cust_primaryno' => $primaryno, 
									'cust_secondaryno' => $alternateno,
									'cust_status' => $status
									);
				$CustomerID = DB::table('customers')->insertGetId($insertdata);

				$output = array("status" => "Success", "message" => 'Added customer successfully');
		}
		
		return json_encode($output);
    }
    
    public static function getALLCustomer()
    {
        $datas = DB::table('customers')
				->select('cust_id','cust_firstname','cust_lastname','cust_primaryno','cust_secondaryno','cust_status')
				->where('cust_status', '=', 1)
				->get();

        if ($datas) {
			
			$dataset = array();
			$i = 1;
			foreach ($datas as $data) {
				$opIcon = '<span class="fa fa-trash-o" aria-hidden="true" data-toggle="tooltip" title="Delete" id="d_'.$data->cust_id.'" onclick="deletes(this.id)"></span>&nbsp;&nbsp;&nbsp;<span class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit" id="e_'.$data->cust_id.'" onclick="edits(this.id)"></span>';
				$dataset[] = array (
						'sl_no' =>	$i,
						'firstname' => $data->cust_firstname,
						'lastname' => $data->cust_lastname,
						'primary' => $data->cust_primaryno,
						'alternate' => $data->cust_secondaryno,
						'opIcon' => $opIcon
					);
				++$i;
			}
            
			$customerInfo = json_decode(json_encode($dataset), true);
			            
            $output = array("status" => 'Success', "customerInfo" => $customerInfo);
        } else {
            
            $output = array("status" => 'Success', "customerInfo" => '');
        }
        
        return json_encode($output);
    }
	
	public static function getCustomer($cust_id)
    {
		$custid = explode("_", $cust_id);
		
        $datas = DB::table('customers')
				->select('cust_id','cust_firstname','cust_lastname','cust_primaryno','cust_secondaryno', 'cust_status')
				->where('cust_id', '=', $custid[1])
				->where('cust_status', '=', 1)
				->get();

        if ($datas) {
			            
            $customerInfo = json_decode(json_encode($datas), true);
            
            $output = array("status" => 'Success', "customerInfo" => $customerInfo);
        } else {
            
            $output = array("status" => 'Success', "customerInfo" => '');
        }
        
        return json_encode($output);
    }
   
    public static function deleteCustomer($cust_id)
    {
		$custid = explode("_", $cust_id);
		
        $datas = DB::table('customers')
                ->select('cust_id')
                ->where('cust_id', '=', $custid[1])
				->where('cust_status', '=', 1)
                ->get();

        if (count($datas)>0) {
                        								
				$updatedata = array('cust_status' => 0);
                                
				$query = DB::table('customers')->where('cust_id', '=', $custid[1])
                                    ->update($updatedata);
									
				$output = array("status" => "Success", "message" => 'Customer has been deleted');
        } else {
            
            $output = array("status" => 'Fail', "error_message" => 'Data not found to delete');
        }
        
        return json_encode($output);
    }
}
