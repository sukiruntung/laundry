<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
$pakaiannama=$_POST['pakaiannama'];
$pakaianid=$_POST['pakaianid'];
$pakaian_jenislaundryid=$_POST['pakaian_jenislaundryid'];
$pakaian_layananid=$_POST['pakaian_layananid'];
$harga=$_POST['harga'];
if($_GET['act']=='delete'){
    try{
            $mysqli->query("update pakaian set pakaianaktif ='N',pakaianlastupdate=NOW() where pakaianid='$_GET[id]'") ;
            $data=['status'=>'sukses'];
        }catch(Exception $ex) {
            die("ERROR: ".implode(":",$mysqli->errorInfo()));
            $data=['status'=>'error'];
        }
        echo json_encode($data,JSON_PRETTY_PRINT);
    }
else if($_POST['aksi']=='Tambah'){
    try{
  $file_type	= array('png','jpg','jpeg');
  $file_name	= $_FILES['image']['name'];
  $file_tmp 	= $_FILES['image']['tmp_name'];
  $folder		= '../images/pakaian/';
  $random		= rand(1,99);
  $namafile=$random.$file_name;
  move_uploaded_file($file_tmp,$folder.$namafile);
  
  $mysqli->query("insert into pakaian (pakaian_jenislaundryid,pakaian_layananid,pakaiannama,pakaiangambar,harga,pakaianlastupdate)
                        values('$pakaian_jenislaundryid','$pakaian_layananid','$pakaiannama','$namafile','$harga',NOW())");
  }catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
    $data=['status'=>'error'];
    }
}
else if($_POST['aksi']=='Edit'){
        try {

            $file_type	= array('png','jpg','jpeg');
            $file_name	= $_FILES['image']['name'];
            $file_tmp 	= $_FILES['image']['tmp_name'];
            $folder		= '../images/pakaian/';
            $random		= rand(1,99);
            $namafile=$random.$file_name;
            if(isset($file_tmp)){
                 move_uploaded_file($file_tmp,$folder.$namafile);
                 $mysqli->query("update pakaian set pakaiannama='$pakaiannama',
                                                        pakaian_layananid='$pakaian_layananid',
                                                        pakaian_jenislaundryid='$pakaian_jenislaundryid',
                                                        pakaiangambar='$namafile',
                                                        harga='$harga',
                                                        pakaianlastupdate=NOW()
                                                        where pakaianid='$pakaianid'");  
            }
            else{
                echo "hehe";
                    $mysqli->query("update pakaian set pakaiannama='$pakaiannama',
                                                        pakaian_layananid='$pakaian_layananid',
                                                        pakaian_jenislaundryid='$pakaian_jenislaundryid',
                                                        harga='$harga',
                                                        pakaianlastupdate=NOW()
                                                        where pakaianid='$pakaianid'");  
            }
 
                
        $data=['status'=>'Sukses'];
    
  }catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
    $data=['status'=>'error'];
    }
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else if($_GET['act']=='tampil'){
    try {

$sql=$mysqli->query("select pakaian.*,0 as pakaianqty,0 as pakaianjumlahbaju,layanannama,jenislaundrynama from pakaian
join jenislaundry on jenislaundryid=pakaian_jenislaundryid
join layanan on pakaian_layananid=layananid
where pakaianaktif='Y'");

$x=0;
if(mysqli_num_rows($sql)> 0){
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['pakaianid']=$result['pakaianid'];
   $data[$x]['pakaiannama']=$result['pakaiannama'];
   $data[$x]['pakaiangambar']=$result['pakaiangambar'];
   $data[$x]['pakaian_jenislaundryid']=$result['pakaian_jenislaundryid'];
   $data[$x]['jenislaundrynama']=$result['jenislaundrynama'];
   $data[$x]['pakaian_layananid']=$result['pakaian_layananid'];
   $data[$x]['layanannama']=$result['layanannama'];
   $data[$x]['harga']=$result['harga'];
   $data[$x]['pakaianqty']=$result['pakaianqty'];
   $data[$x]['pakaianjumlahbaju']=$result['pakaianjumlahbaju'];
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
echo json_encode($data,JSON_PRETTY_PRINT);
}
else {
 $layananid=(($_GET['layananid'])==0 ? 'layananid="1"':'pakaian_layananid="'.$_GET['layananid'].'"');
 $jenislaundryid=($_GET['jenislaundryid']==0 ? 'jenislaundrydefault="1"': 'pakaian_jenislaundryid="'.$_GET['jenislaundryid'].'"');
 


        try {

$sql=$mysqli->query("select pakaian.*,0 as pakaianqty,0 as pakaianjumlahbaju,layanannama,jenislaundrynama from pakaian
join jenislaundry on jenislaundryid=pakaian_jenislaundryid
join layanan on pakaian_layananid=layananid
where $layananid and $jenislaundryid and pakaianaktif='Y'");

$x=0;
if(mysqli_num_rows($sql)> 0){
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['pakaianid']=$result['pakaianid'];
   $data[$x]['pakaiannama']=$result['pakaiannama'];
   $data[$x]['pakaiangambar']=$result['pakaiangambar'];
   $data[$x]['pakaian_jenislaundryid']=$result['pakaian_jenislaundryid'];
   $data[$x]['jenislaundrynama']=$result['jenislaundrynama'];
   $data[$x]['pakaian_layananid']=$result['pakaian_layananid'];
   $data[$x]['layanannama']=$result['layanannama'];
   $data[$x]['harga']=$result['harga'];
   $data[$x]['pakaianqty']=$result['pakaianqty'];
   $data[$x]['pakaianjumlahbaju']=$result['pakaianjumlahbaju'];
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
echo json_encode($data,JSON_PRETTY_PRINT);
}



?>