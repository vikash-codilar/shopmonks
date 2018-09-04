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
        // dd($excel);
        $limit = 4;
        $qty   = 0;
        $box   = 1;
        $tc    = $excel[3][4];       // first time count
        $invoiceno   = $excel[0][3]; // first time count
        $palletid    = $excel[2][1]; // Pallet Id
        $productcode = $excel[3][1]; // Product Code
        $description = $excel[3][2]; // product description
        $model       = "";
        $storage     = "";
        $color       = "";
        $allrecords  = [];

        $lim = 3;
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

        foreach ($excel as $value) {
            if($index > 1){
                if($index == $pallet_index){
                    // echo($value[1].'<br>');
                    $pallet_id = $value[1];
                }

                else if($index == $qty_index){
                    // echo ('<br>');
                    // echo($value[0].'<br>');
                    $product_code = $value[1];
                    // echo($value[1].'<br>');
                    // echo($value[2].'<br>');
                    $description = $value[2]; 
                    $model_description = [];
                    $model_description = explode("(",$value[2]);

                    $color = (! isset($model_description[1]))?'NA':rtrim($model_description[1],')');

                   

                    // echo rtrim($model_description[1],')').'<br>';
                    // $color = rtrim($model_description[1],')');

                    // echo rtrim($model_description[0]);
                    
                    $model_name_with_memory = [];
                    $model_name_with_memory = explode(" ",rtrim($model_description[0]));
                    // dd(sizeof($model_name_with_memory));
                    // echo($model_name_with_memory[]);
                    $storage = $model_name_with_memory[sizeof($model_name_with_memory)-1];
                    
                    $model = rtrim(str_replace($storage,"",rtrim($model_description[0])));

                    // dd($model);
// dd($model_description);

                    // $model_description = explode(" ",$value[2]);
                    // $model = $model_description[0]." ".$model_description[1];
                    // $color = explode("(",$model_description[2])[0];
                    // $storage = rtrim(explode("(",$model_description[2])[1],')');


                    // dd(rtrim(explode("(",$model_description[2])[1],')'));
                    // echo($value[3].'<br>');
                    // echo($value[4].'<br>');

//                     array:3 [▼
                    //   0 => "iPhone"
                    //   1 => "4S"
                    //   2 => "16GB(Black)"
                    // ]

                    $qty_index += ($value[4] +2);
                    $pallet_index += ($value[4]+2);  
                    // echo ('<br>');
                    $box_id = 1;
                    // echo ($pallet_index.'<br>');
                    // echo($qty_index.'<br>');

                }

                else{
                    // echo($value[0].'<br>');
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
            $srcarr=array_chunk($allrecords,5000);
            foreach($srcarr as $item) {
                DB::table('excel_sheets')->insert($item);
            }
            dd($allrecords);
        }

        dd($allrecords);

        // $initial_count = 4;
        // $count = $excel[3][4];
        // $p = 1;

        echo "Box No: ".$box.'<br>';
        $arr = (array)$this->getProductdetails($productcode);
        $allrecords =[];
        for ($exrow = $limit; $exrow <= sizeof($excel); $exrow++){
            $qty++;
            //echo $qty."-".$tc;
                if($excel[$exrow][0]!=''){
                    if($qty==$tc+1 || $qty==$tc+2){
                        // echo"<br/>";
                        if($qty==($tc+2)){
                            // echo "Box No: ".++$box.'<br/>';
                            $tc+= ($excel[$exrow][4]+2);
                            // echo $productcode = $excel[$exrow][1];
                            $arr = (array)$this->getProductdetails($productcode);
                            // echo"<br/>";
                        }
                    }else{
                        
                        // if($excel[$exrow][0][4] != ""){
                        //     $temp_e = $e;
                        //     echo ($e).' if E <br>';
                        //     echo ($pallet_box_index == $i);
                        // }

                        // $allrecords[] = array_merge(array('imei'=>$excel[$exrow][0],'product_code'=>$productcode,'invoice_no'=>$invoiceno,'pallet_id'=>$palletid,'box_id'=>$box,'description'=>$description),$arr);
                        // echo"<br/>";
                       
                        
                    }
                }else{
                    break;
                }
        }
        dd($allrecords);
         //dd('Read all records successfully.');
        
        if(!empty($allrecords)){
            $srcarr=array_chunk($allrecords,5000);
            foreach($srcarr as $item) {
                // DB::table('excel_sheets')->insert($item);
            }
            dd('Insert Recorded successfully.');
        }
     
 }


 public function getProductdetails($productcode){
    // $productdetails = DB::table('product_detail')->where('productcode', $productcode)->first(['model', 'color','storage']);
    // if(!empty((array)$productdetails)){
    //     return $productdetails;
    // }else{
        return array('model'=>'NA','color'=>'NA','storage'=>'NA');
    // }
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
