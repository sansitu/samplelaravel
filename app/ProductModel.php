<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Filesystem;
use DB;
use Mail;

class ProductModel extends Model
{    
    public static function getALLProductType()
    {
        $datas = DB::table('products')
				->select('prod_id','prod_name')
				->where('prod_status', '=', 1)
				->get();

        if ($datas) {
			
			$dataset = array();
			$i = 1;
			foreach ($datas as $data) {
				$opIcon = '<span class="fa fa-trash-o" aria-hidden="true" data-toggle="tooltip" title="Delete" id="d_'.$data->pty_id.'" onclick="deletes(this.id)"></span>&nbsp;&nbsp;&nbsp;<span class="fa fa-pencil" aria-hidden="true" data-toggle="tooltip" title="Edit" id="e_'.$data->pty_id.'" onclick="edits(this.id)"></span>';
				$dataset[] = array (
						'sl_no' =>	$i,
						'prod_name' => $data->prod_name,
						'operation' => $opIcon
					);
				++$i;
			}
            
            $productInfo = json_decode(json_encode($dataset), true);
            
            $output = array("status" => 'Success', "productInfo" => $productInfo);
        } else {
            
            $output = array("status" => 'Success', "productTypeInfo" => '');
        }
        
        return json_encode($output);
    }
}
