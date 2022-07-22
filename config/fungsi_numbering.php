<?php

/**
 * @author Ple-Q
 * @copyright 2017
 */
//$link='fakturretur';

  //  $number=numbering($link);
   // echo "$number";
  // $number=numbering($id);
 // $module='pemberkasan';
  
 // $number=numbering($module);
 // echo "$number";
function numbering($link){
    
include 'koneksi.php';
   // echo"$link";
$z=$mysqli->query("SELECT date_format(curdate(),'%Y' )as tahun");
   $c=mysqli_fetch_array($z);
  //  echo"$c[tanggal]";
   $a=date('Y-m-d');
   
    $b=$mysqli->query("select * from formatnumber where formatnumbermenu='$link'");
  $d=mysqli_fetch_array($b);
//  echo $d[sequen];
  $ad=date($d['formatnumberformatdate']);
  
  $fomat_date=str_replace("-","",$ad);
    if($d['formatnumbertahun']==$c['tahun']){
    $e=$d['formatnumbersequen'];
 
  }
  else{
     $e=1;
  } 
 // $e=$d[no_sales_order]+1;
  $lebar=$d['formatnumberdigitcounter'];
 $angka =str_pad($e,$lebar,"0",STR_PAD_LEFT);
 $number_format=STR_REPLACE('[formatnumberformatdate]',$fomat_date,STR_REPLACE('[formatnumbersequen]',$angka,$d['formatnumberformat']));
return $number_format;

// return $number_format;
}

?>