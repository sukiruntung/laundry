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
            $mysqli->query("update customer set customeraktif='N',customerlastupdate=NOW() where customerid='$_GET[id]'") ;
            $data=['status'=>'sukses'];
        }catch(Exception $ex) {
            die("ERROR: ".implode(":",$mysqli->errorInfo()));
            $data=['status'=>'error'];
        }
        echo json_encode($data,JSON_PRETTY_PRINT);
    }
else if($obj['aksi']=='Tambah'){
    $customer=$obj['customer'];
        try {
                foreach($customer as $h){
                    $mysqli->query("insert into customer (customernama,customeralamat,customernowa,customerlastupdate)
                        values('$h[customernama]','$h[customeralamat]','$h[customernowa]',NOW())");  
                }
                $data=['status'=>'Sukses'];
    
  }catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
    $data=['status'=>'error'];
}
echo json_encode($data,JSON_PRETTY_PRINT);
}
else if($obj['aksi']=='Edit'){
     $customer=$obj['customer'];
        try {
                foreach($customer as $h){
                    $mysqli->query("update customer set customernama='$h[customernama]',
                                                        customeralamat='$h[customeralamat]',
                                                        customernowa='$h[customernowa]',
                                                        customerlastupdate=NOW()
                                                        where customerid='$h[customerid]'");  
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

$sql=$mysqli->query("select * from customer where customeraktif='Y'");

$x=0;
if(mysqli_num_rows($sql)> 0){
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['customerid']=$result['customerid'];
   $data[$x]['customernama']=$result['customernama'];
   $data[$x]['customernowa']=$result['customernowa'];
   $data[$x]['customeralamat']=$result['customeralamat'];
   $x++;
}
$error='';
}
else{
    $error='error';
}

}catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
}
$data=['results'=> $data,'error'=>$error];
//$hasil=[$data];
echo json_encode($data,JSON_PRETTY_PRINT);
    
}

//$json = file_get_contents('php://input');


?>