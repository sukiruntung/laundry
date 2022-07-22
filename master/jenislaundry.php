<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
$s = file_get_contents('php://input');
$obj=json_decode($s,true);
if($_GET['act']=='delete'){
    try{
            $mysqli->query("update jenislaundry set jenislaundryaktif='N',jenislaundrylastupdate=NOW() where jenislaundryid='$_GET[id]'") ;
            $data=['status'=>'sukses'];
        }catch(Exception $ex) {
            die("ERROR: ".implode(":",$mysqli->errorInfo()));
            $data=['status'=>'error'];
        }
        echo json_encode($data,JSON_PRETTY_PRINT);
    }
else if($obj['aksi']=='Tambah'){
    $jenislaundry=$obj['jenislaundry'];
        try {
                foreach($jenislaundry as $h){
                    $mysqli->query("insert into jenislaundry (jenislaundrynama,jenislaundrylastupdate)
                        values('$h[jenislaundrynama]',NOW())");  
                }
                $data=['status'=>'Sukses'];
    
  }catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
    $data=['status'=>'error'];
}
echo json_encode($data,JSON_PRETTY_PRINT);
}
else if($obj['aksi']=='Edit'){
     $jenislaundry=$obj['jenislaundry'];
        try {
                foreach($jenislaundry as $h){
                    $mysqli->query("update jenislaundry set jenislaundrynama='$h[jenislaundrynama]',
                                                        jenislaundrylastupdate=NOW()
                                                        where jenislaundryid='$h[jenislaundryid]'");  
                }
        $data=['status'=>'Sukses'];
    
  }catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
    $data=['status'=>'error'];
    }
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else{

        try {

    
$sql=$mysqli->query("SELECT jenislaundryid,jenislaundrynama 
FROM  jenislaundry where jenislaundryaktif='Y'");

$x=0;
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['jenislaundryid']=$result['jenislaundryid'];
   $data[$x]['jenislaundrynama']=$result['jenislaundrynama'];
   $x++;
}

}catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
}
$data=['results'=> $data];
//$hasil=[$data];
echo json_encode($data,JSON_PRETTY_PRINT);
}


?>