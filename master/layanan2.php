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
$aksi=$_POST['aksi'];
  $file_type	= array('png','jpg','jpeg');
  $file_name	= $_FILES['image']['name'];
  $file_tmp 	= $_FILES['image']['tmp_name'];
  $folder		= '../images/layanan/';
  $random		= rand(1,99);
  $namafile=$random.$file_name;
  move_uploaded_file($file_tmp,$folder.$namafile);
  $mysqli->query("insert into layanan (layanannama,layanangambar,layananlastupdate)
                        values('$layanannama','$namafile',NOW())");

?>