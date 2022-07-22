<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";
include "../config/fungsi_numbering.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
$s = file_get_contents('php://input');
$obj=json_decode($s,true);
 
$t_order_customerid = $obj['t_order_customerid'];
$t_order_alatpembayaranid = $obj['t_order_alatpembayaranid'];
$t_ordernokartu = $obj['t_ordernokartu'];
$t_ordernamakartu = $obj['t_ordernamakartu'];
$t_ordertotal = $obj['t_ordertotal'];
$t_orderemail = $obj['t_orderemail'];
$t_orderusername = $obj['t_orderusername'];
$orderdetail = $obj['orderdetail'];
$t_ordercatatan = $obj['t_ordercatatan'];
$link='t_order';
$error=0;

$number=numbering($link);
try{
$mysqli->query("start transaction");
    $mysqli->query("insert into t_order(t_orderno,t_ordertanggal,t_ordercatatan,
    t_order_customerid,t_order_alatpembayaranid,t_ordernokartu,t_ordernamakartu,t_ordertotal,
    t_orderemail,t_orderusername,t_orderlastupdate)
    values
    ('$number',now(),'$t_ordercatatan','$t_order_customerid','$t_order_alatpembayaranid','$t_ordernokartu',
    '$t_ordernamakartu','$t_ordertotal','$t_orderemail','$t_orderusername',now())");
    $id=$mysqli->insert_id;

foreach($orderdetail as $h){
    $detail=$mysqli->query("insert into t_orderdetail 
    (t_orderdetail_t_orderid,t_orderdetail_pakaianid,t_orderdetailqty,t_orderdetailjmlbaju,t_orderdetailharga)
    values('$id','{$h['pakaianid']}','{$h['pakaianqty']}','{$h['t_orderdetailjmlbaju']}','{$h['harga']}')");
if(!$detail){
    $error++;
}
}
if($error > 0){
        $mysqli->query("ROLLBACK");
$data=["status" => 'Error',"notransaksi"=>''];

     }
else{
    
$mysqli->query("COMMIT");
$data=["status" => 'OK',"notransaksi"=>$number];
} 
}catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
}
echo json_encode($data,JSON_PRETTY_PRINT);
  

?>