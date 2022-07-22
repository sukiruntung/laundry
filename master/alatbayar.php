<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
 

        try {

$sql=$mysqli->query("select * from alatpembayaran where alatpembayaranaktif='Y'");

$x=0;
if(mysqli_num_rows($sql)> 0){
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['alatpembayaranid']=$result['alatpembayaranid'];
   $data[$x]['alatpembayarannama']=$result['alatpembayarannama'];
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
    


//$json = file_get_contents('php://input');


?>