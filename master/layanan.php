<?php

/**
 * @author untung
 * @copyright 2021
 */
include "../config/koneksi.php";

header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: token,Content-type");
$layanannama=$_POST['layanannama'];
$layananid=$_POST['layananid'];
if($_GET['act']=='delete'){
    try{
            $mysqli->query("update layanan set layananaktif='N',layananlastupdate=NOW() where layananid='$_GET[id]'") ;
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
  $folder		= '../images/layanan/';
  $random		= rand(1,99);
  $namafile=$random.$file_name;
  move_uploaded_file($file_tmp,$folder.$namafile);
  
  $mysqli->query("insert into layanan (layanannama,layanangambar,layananlastupdate)
                        values('$layanannama','$namafile',NOW())");
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
            $folder		= '../images/layanan/';
            $random		= rand(1,99);
            $namafile=$random.$file_name;
            if(isset($file_tmp)){
                 move_uploaded_file($file_tmp,$folder.$namafile);
                 $mysqli->query("update layanan set layanannama='$layanannama',
                                                        layanangambar='$namafile',
                                                        layananlastupdate=NOW()
                                                        where layananid='$layananid'");  
            }
            else{
                    $mysqli->query("update layanan set layanannama='$layanannama',
                                                        layananlastupdate=NOW()
                                                        where layananid='$layananid'");  
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

    
$sql=$mysqli->query("SELECT * FROM layanan  where layananaktif='Y'");

$x=0;
while($result=mysqli_fetch_array($sql)){
    
   $data[$x]['layananid']=$result['layananid'];
   $data[$x]['layanannama']=$result['layanannama'];
   $data[$x]['layanangambar']=$result['layanangambar'];
   $data[$x]['layanandefault']=$result['layanandefault'];
   $x++;
}

}catch (Exception $ex) {
    die("ERROR: ".implode(":",$mysqli->errorInfo()));
}
$data=['results'=> $data];
//$hasil=[$data];
echo json_encode($data,JSON_PRETTY_PRINT);
    
}

//$json = file_get_contents('php://input');


?>