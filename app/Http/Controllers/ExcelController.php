<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use DB;
use App\ExcelSheet;

class ExcelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        Excel::load($request->file('sample_file')->getRealPath(), function($reader) use (&$excel) {
            $objExcel = $reader->getExcel();
            $sheet = $objExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            //  Loop through each row of the worksheet in turn
            for ($row = 1; $row <= $highestRow; $row++){
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL, TRUE, FALSE);
                $excel[] = $rowData[0];
            }
        });

        $allrecords  = [];
        $index = 0;
        $qty_index = 3;
        $pallet_index = 2;
        $product_code = '';
        $invoice_no = $excel[0][3];
        $pallet_id = '';
        $box_id = 1;
        $description = '';
        $model = '';
        $color = '';
        $storage = '';
        $product_details = [];

        foreach ($excel as $value) {
            if($index > 1){
                if($index == $pallet_index)
                    $pallet_id = $value[1];

                else if($index == $qty_index){
                    $product_code = $value[1];
                    $description = $value[2]; 
                    $model_description = [];
                    $model_description = explode("(",$value[2]);
                    $color = (! isset($model_description[1]))?'NA':rtrim($model_description[1],')');
                    $model_name_with_memory = [];
                    $model_name_with_memory = (! isset($model_description[0]))?'NA':explode(" ",rtrim($model_description[0]));
                    $storage = (! isset($model_name_with_memory))?'NA':$model_name_with_memory[sizeof($model_name_with_memory)-1];
                    $model = rtrim(str_replace($storage,"",rtrim($model_description[0])));
                    $qty_index += ($value[4] +2);
                    $pallet_index += ($value[4]+2);  
                    $box_id = 1;

                    $product_details[] = array(
                                                'productcode'=>$product_code,
                                                'model'=>$model,
                                                'color'=>$color ,
                                                'storage'=>$storage
                                              );
                }

                else{
                    $allrecords[] = array(
                                            'imei'=>$value[0],
                                            'product_code'=>$product_code,
                                            'invoice_no'=>$invoice_no,
                                            'pallet_id'=>$pallet_id,
                                            'box_id'=>$box_id,
                                            'description'=>$description,
                                            'model'=>$model,
                                            'color'=>$color ,
                                            'storage'=>$storage
                                        );
                    $box_id++;
                }
            }
            $index++;
        }

        if(!empty($allrecords)){
            $data=array_chunk($allrecords,5000);
            foreach($data as $item) {
                DB::table('excel_sheets')->insert($item);
            }
            // dd($product_details);
        }

        if(!empty($product_details)){
            $data=array_chunk($product_details,5000);
            foreach($data as $item) {
                DB::table('product_detail')->insert($item);
            }
            dd($product_details);
        }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('excel');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
