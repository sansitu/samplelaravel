<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use DB;
use Mail;

class EmployeeModel extends Model
{   
    public static function updateInfo($EmployeeID, $firstname, $lastname, $primaryno, $alternateno, $password, $type, $status)
    {	     
		$datas = DB::table('employees')
				->where('emp_primaryno', '=', $primaryno)
				->where('emp_status', '=', 1)
				->get();
				
		if (trim($EmployeeID) != "") {
				
				$updatedata = array('emp_firstname' => $firstname, 
									'emp_lastname' => $lastname, 
									'emp_primaryno' => $primaryno, 
									'emp_secondaryno' => $alternateno,
									'emp_type' => $type,
									'emp_status' => $status,
									);
				$datas = json_decode($datas);
				
				if ((trim($datas[0]->emp_password) != trim($password)) && (trim($password) != '')) {
					$updatedata['emp_password'] = $password;
					$updatedata['emp_encryptpassword'] = encrypt($password);
				}
									
				DB::table('employees')->where('emp_id', '=', $EmployeeID)
										->update($updatedata);
				
				$output = array("status" => "Success", "message" => 'Employee info has been updated');
		} else {

				$insertdata = array('emp_firstname' => $firstname, 
									'emp_lastname' => $lastname, 
									'emp_primaryno' => $primaryno, 
									'emp_secondaryno' => $alternateno,
									'emp_password' => $password,
									'emp_encryptpassword' => encrypt($password),
									'emp_type' => $type,
									'emp_status' => $status
									);
				$EmployeeID = DB::table('employees')->insertGetId($insertdata);

				$output = array("status" => "Success", "message" => 'Added employee successfully');
		}
		
		return json_encode($output);
    }
    
    public static function getALLEmployee()
    {
        $datas = DB::table('employees')
				->select('emp_id','emp_firstname','emp_lastname','emp_primaryno','emp_secondaryno','emp_status')
				->where('emp_status', '=', 1)
				->get();

        if ($datas) {
			
			$dataset = array();
			$i = 1;
			foreach ($datas as $data) {
				$opIcon = '<span class="fa fa-trash-o" aria-hidden="true" data-toggle="tooltip" title="Delete" id="d_'.$data->emp_id.'" onclick="deletes(this.id)"></span>&nbsp;&nbsp;&nbsp;<span class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit" id="e_'.$data->emp_id.'" onclick="edits(this.id)"></span>';
				$dataset[] = array (
						'sl_no' =>	$i,
						'firstname' => $data->emp_firstname,
						'lastname' => $data->emp_lastname,
						'primary' => $data->emp_primaryno,
						'alternate' => $data->emp_secondaryno,
						'opIcon' => $opIcon
					);
				++$i;
			}
            
			$employeeInfo = json_decode(json_encode($dataset), true);
			            
            $output = array("status" => 'Success', "employeeInfo" => $employeeInfo);
        } else {
            
            $output = array("status" => 'Success', "employeeInfo" => '');
        }
        
        return json_encode($output);
    }
	
	public static function getEmployee($emp_id)
    {
		$empid = explode("_", $emp_id);
		
        $datas = DB::table('employees')
				->select('emp_id','emp_firstname','emp_lastname','emp_primaryno','emp_secondaryno', 'emp_type', 'emp_status')
				->where('emp_id', '=', $empid[1])
				->where('emp_status', '=', 1)
				->get();

        if ($datas) {
			            
            $employeeInfo = json_decode(json_encode($datas), true);
            
            $output = array("status" => 'Success', "employeeInfo" => $employeeInfo);
        } else {
            
            $output = array("status" => 'Success', "employeeInfo" => '');
        }
        
        return json_encode($output);
    }
   
    public static function deleteEmployee($emp_id)
    {
		$empid = explode("_", $emp_id);
		
        $datas = DB::table('employees')
                ->select('emp_id')
                ->where('emp_id', '=', $empid[1])
				->where('emp_status', '=', 1)
                ->get();

        if (count($datas)>0) {
                        								
				$updatedata = array('emp_status' => 0);
                                
				$query = DB::table('employees')->where('emp_id', '=', $empid[1])
                                    ->update($updatedata);
									
				$output = array("status" => "Success", "message" => 'Employee has been deleted');
        } else {
            
            $output = array("status" => 'Fail', "error_message" => 'Data not found to delete');
        }
        
        return json_encode($output);
    }
	
	public static function getEmployeeInfo($EmployeeID)
	{
		$datas = DB::table('employees')
				->select('emp_firstname','emp_lastname', 'emp_type')
				->where('emp_id', '=', (int)$EmployeeID)
				->where('emp_status', '=', 1)
				->get();

        if ($datas) {
			            
            $employeeInfo = json_decode(json_encode($datas), true);
            
            $output = array("status" => 'Success', "employeeInfo" => $employeeInfo);
        } else {
            
            $output = array("status" => 'Error');
        }
        
        return json_encode($output);
	}
}
