<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use DB;
use Mail;

class ProductTypeModel extends Model
{   
    public static function updateInfo($ProductTypeID, $ProductType)
    {	     
		$datas = DB::table('product_types')
				->where('pty_name', '=', $ProductType)
				->where('pty_status', '=', 1)
				->get();
				
		//$output = array("status" => "Conflict", "message" => count($datas));

        if (count($datas) == 0) {
			if (trim($ProductTypeID) != "") {

				$updatedata = array('pty_name' => $ProductType);
									
				DB::table('product_types')->where('pty_id', '=', $ProductTypeID)
										->update($updatedata);
				
				$output = array("status" => "Success", "message" => 'Product type has been updated');
			} else {

				$insertdata = array('pty_name' => $ProductType);
				$ProductTypeID = DB::table('product_types')->insertGetId($insertdata);

				$output = array("status" => "Success", "message" => 'Product type has been saved');
			}
		} else {
			$output = array("status" => "Conflict", "message" => 'Product type already exist');
		}

        return json_encode($output);
    }
    
    public static function getALLProductType()
    {
        $datas = DB::table('product_types')
				->select('pty_id','pty_name')
				->where('pty_status', '=', 1)
				->get();

        if ($datas) {
			
			$dataset = array();
			$i = 1;
			foreach ($datas as $data) {
				$opIcon = '<span class="fa fa-trash-o" aria-hidden="true" data-toggle="tooltip" title="Delete" id="d_'.$data->pty_id.'" onclick="deletes(this.id)"></span>&nbsp;&nbsp;&nbsp;<span class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit" id="e_'.$data->pty_id.'" onclick="edits(this.id)"></span>';
				$dataset[] = array (
						'sl_no' =>	$i,
						'pty_name' => $data->pty_name,
						'operation' => $opIcon
					);
				++$i;
			}
            
            $productTypeInfo = json_decode(json_encode($dataset), true);
            
            $output = array("status" => 'Success', "productTypeInfo" => $productTypeInfo);
        } else {
            
            $output = array("status" => 'Success', "productTypeInfo" => '');
        }
        
        return json_encode($output);
    }
	
	public static function getProductType($pty_id)
    {
		$ptyid = explode("_", $pty_id);
		
        $datas = DB::table('product_types')
				->select('pty_id','pty_name')
				->where('pty_id', '=', $ptyid[1])
				->where('pty_status', '=', 1)
				->get();

        if ($datas) {
			            
            $productTypeInfo = json_decode(json_encode($datas), true);
            
            $output = array("status" => 'Success', "productTypeInfo" => $productTypeInfo);
        } else {
            
            $output = array("status" => 'Success', "productTypeInfo" => '');
        }
        
        return json_encode($output);
    }
   
    public static function deleteProductType($pty_id)
    {
		$ptyid = explode("_", $pty_id);
		
        $datas = DB::table('product_types')
                ->select('pty_id')
                ->where('pty_id', '=', $ptyid[1])
				->where('pty_status', '=', 1)
                ->get();

        if ($datas) {
                        								
				$updatedata = array('pty_status' => 0);
                                
				$query = DB::table('product_types')->where('pty_id', '=', $ptyid[1])
                                    ->update($updatedata);
									
				$output = array("status" => "Success", "message" => 'Product type has been deleted');
        } else {
            
            $output = array("status" => 'Fail', "error_message" => 'Data not found to delete');
        }
        
        return json_encode($output);
    }
}
