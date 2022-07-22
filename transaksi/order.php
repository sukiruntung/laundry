<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
 $json = file_get_contents('php://input');
$data=isset ($array['index_array']) ? $array['index_array']:'';
$pakaiandetail=[];
        try {

    
$sql=$mysqli->query("SELECT t_order.*,customer.customernama,customernowa,customeralamat,alatpembayaran.*
FROM t_order 
join t_orderdetail on t_orderid=t_orderdetail_t_orderid
                    join alatpembayaran on t_order_alatpembayaranid=alatpembayaranid
                    join customer on customerid=t_order_customerid and customeraktif='Y'
                    where t_orderaktif='Y'
                    group by t_orderid
                    order by t_orderid desc
                    limit 10");

$x=0;
while($result=mysqli_fetch_array($sql)){
$total=0;
  $detail=[];
$y=0;
   $data[$x]['t_orderid']=$result['t_orderid'];
   $data[$x]['t_orderno']=$result['t_orderno'];
   $data[$x]['t_ordertanggal']=$result['t_ordertanggal'];
   $data[$x]['t_ordercatatan']=$result['t_ordercatatan'];
   $data[$x]['t_order_customerid']=$result['t_order_customerid'];
   $data[$x]['customernama']=$result['customernama'];
   $data[$x]['customeralamat']=$result['customeralamat'];
   $data[$x]['customernowa']=$result['customernowa'];
   $data[$x]['t_ordertotal']=$result['t_ordertotal'];
   $data[$x]['alatpembayaranid']=$result['alatpembayaranid'];
   $data[$x]['nokartu']=$result['t_ordernokartu'];
   $data[$x]['namaKartu']=$result['t_ordernamakartu'];
  $sql2= $mysqli->query("select t_orderdetail.*,pakaian.*,jenislaundry.*,
                layanan.* from t_orderdetail 
                join pakaian on t_orderdetail_pakaianid=pakaianid and pakaianaktif='Y'
                join jenislaundry on jenislaundryid=pakaian_jenislaundryid
                join layanan on layananid=pakaian_layananid
                where t_orderdetail_t_orderid='{$result['t_orderid']}' and  t_orderdetailaktif ='Y'");
  while($hasildetail=mysqli_fetch_array($sql2)){
    $total=$total+$hasildetail['t_orderdetailqty'];
    $detail[$y]=[
    'pakaianid' => $hasildetail['t_orderdetail_pakaianid'],
    'pakaiannama' => $hasildetail['pakaiannama'],
    'pakaiangambar' =>$hasildetail['pakaiangambar'],
    'pakaian_jenislaundryid'=>$hasildetail['pakaian_jenislaundryid'],
    'jenislaundrynama'=>$hasildetail['jenislaundrynama'],
    'pakaian_layananid'=>$hasildetail['pakaian_layananid'],
    'layanannama'=>$hasildetail['layanannama'],
    'harga'=>$hasildetail['harga'],
    'pakaianqty'=>$hasildetail['t_orderdetailqty'],
    'pakaianjumlahbaju'=>$hasildetail['t_orderdetailjmlbaju']
    ];
    $data[$x]['jenislaundryid']=$hasildetail['jenislaundryid'];
    $data[$x]['jenislaundrynama']=$hasildetail['jenislaundrynama'];
    $data[$x]['layananid']=$hasildetail['layananid'];
    $data[$x]['layanannama']=$hasildetail['layanannama'];
    $y++;
  }
  $data[$x]['pakaiandetail']=$detail;
  $data[$x]['totalqty']=$total;
   $x++;
}

}catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));

}
$data=["status" => 'OK','results'=> $data];
//$hasil=[$data];
echo json_encode($data,JSON_PRETTY_PRINT);
    
 $productitems[] = array(
       't_orderdetail_pakaianid' => $result['t_orderdetail_pakaianid'],
       't_orderdetailqty'  => $result['t_orderdetailqty'],
       't_orderdetailjmlbaju'  => $result['t_orderdetailjmlbaju'],
       't_orderdetailharga'=>$result['t_orderdetailharga']
    );

//$json = file_get_contents('php://input');


?>