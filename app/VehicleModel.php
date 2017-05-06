<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use DB;
use Mail;

class VehicleModel extends Model
{   
    public static function updateInfo($VehicleID, $Vehicle)
    {	     
		$datas = DB::table('vehicles')
				->where('v_number', '=', $Vehicle)
				->where('v_status', '=', 1)
				->get();
				
		if (count($datas) == 0) {
			if (trim($VehicleID) != "") {

				$updatedata = array('v_number' => $Vehicle);
									
				DB::table('vehicles')->where('v_id', '=', $VehicleID)
										->update($updatedata);
				
				$output = array("status" => "Success", "message" => 'Product type has been updated');
			} else {

				$insertdata = array('v_number' => $Vehicle);
				$VehicleID = DB::table('vehicles')->insertGetId($insertdata);

				$output = array("status" => "Success", "message" => 'Vehicle has been saved');
			}
		} else {
			$output = array("status" => "Conflict", "message" => 'Vehicle already exist');
		}

        return json_encode($output);
    }
    
    public static function getALLVehicle()
    {
        $datas = DB::table('vehicles')
				->select('v_id','v_number')
				->where('v_status', '=', 1)
				->get();

        if ($datas) {
			
			$dataset = array();
			$i = 1;
			foreach ($datas as $data) {
				$opIcon = '<span class="fa fa-trash-o" aria-hidden="true" data-toggle="tooltip" title="Delete" id="d_'.$data->v_id.'" onclick="deletes(this.id)"></span>&nbsp;&nbsp;&nbsp;<span class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit" id="e_'.$data->v_id.'" onclick="edits(this.id)"></span>';
				$dataset[] = array (
						'sl_no' =>	$i,
						'v_number' => $data->v_number,
						'operation' => $opIcon
					);
				++$i;
			}
            
			$vehicleInfo = json_decode(json_encode($dataset), true);
			            
            $output = array("status" => 'Success', "vehicleInfo" => $vehicleInfo);
        } else {
            
            $output = array("status" => 'Success', "vehicleInfo" => '');
        }
        
        return json_encode($output);
    }
	
	public static function getVehicle($v_id)
    {
		$vid = explode("_", $v_id);
		
        $datas = DB::table('vehicles')
				->select('v_id','v_number')
				->where('v_id', '=', $vid[1])
				->where('v_status', '=', 1)
				->get();

        if ($datas) {
			            
            $vehicleInfo = json_decode(json_encode($datas), true);
            
            $output = array("status" => 'Success', "vehicleInfo" => $vehicleInfo);
        } else {
            
            $output = array("status" => 'Success', "vehicleInfo" => '');
        }
        
        return json_encode($output);
    }
   
    public static function deleteVehicle($v_id)
    {
		$vid = explode("_", $v_id);
		
        $datas = DB::table('vehicles')
                ->select('v_id')
                ->where('v_id', '=', $vid[1])
				->where('v_status', '=', 1)
                ->get();

        if (count($datas)>0) {
                        								
				$updatedata = array('v_status' => 0);
                                
				$query = DB::table('vehicles')->where('v_id', '=', $vid[1])
                                    ->update($updatedata);
									
				$output = array("status" => "Success", "message" => 'Vehicle has been deleted');
        } else {
            
            $output = array("status" => 'Fail', "error_message" => 'Data not found to delete');
        }
        
        return json_encode($output);
    }
}
