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
                        // echo"IMEI => ".$excel[$exrow][0];
                        
                        $allrecords[] = array_merge(array('imei'=>$excel[$exrow][0],'product_code'=>$productcode,'invoice_no'=>$invoiceno,'pallet_id'=>$palletid,'box_id'=>$box,'description'=>$description),$arr);
                        // echo"<br/>";
                       
                        
                    }
                }else{
                    break;
                }
        }
         //dd('Read all records successfully.');
        
        if(!empty($allrecords)){
            $srcarr=array_chunk($allrecords,5000);
            foreach($srcarr as $item) {
                DB::table('excel_sheets')->insert($item);
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
