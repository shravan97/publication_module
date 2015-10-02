<?php
include "db_connect.php";

if(isset($_POST['arr_vals'])&& !empty($_POST['arr_vals'])){
	
$arr1 = array();
$arr1=$_POST['arr_vals'];
sort($arr1);

$query_1 = "select * from publications_table order by sl_no desc";
$r_1 = mysqli_query($h,$query_1);
$arr_1 = mysqli_fetch_array($r_1);
$highest = mysqli_real_escape_string($h , $arr_1['sl_no']);


for ($i=0; $i < sizeof($arr1); $i++) { 
	# code...
	$val1 =  $_POST['arr_vals'][$i];
	$val = mysqli_real_escape_string($h , $arr1[$i]);
    $new_sum = mysqli_real_escape_string($h , $highest+$val);
$query_change = "update publications_table set sl_no=".$new_sum." where sl_no=".$val1." ;";
$r_change = mysqli_query($h,$query_change);
}
for ($i=0; $i < sizeof($arr1); $i++) { 
	$val = mysqli_real_escape_string($h , $arr1[$i]);
    $new_sum = mysqli_real_escape_string($h , $highest+$val);

$query_change = "update publications_table set sl_no=".$val." where sl_no=".$new_sum." ;";
$r_change = mysqli_query($h,$query_change);

}
echo "success";
}

if(isset($_GET['sort'])){
	$query = "select sl_no from publications_table order by created_time asc;";
	$arr_slnums  = array();
	$r = mysqli_query($h,$query);
	while ($arr=mysqli_fetch_array($r)) {
	
		# code...
	   array_push($arr_slnums, $arr['sl_no']); 
	   print_r($arr_slnums);
	}
    
	$query2 = "select sl_no from publications_table order by sl_no desc;";
	$r_2 = mysqli_query($h,$query2);
    $arr2=mysqli_fetch_array($r_2);
    $highest = $arr2['sl_no'];

    $query4 = "select sl_no from publications_table;";
	$r_4 = mysqli_query($h,$query4);
    
    $count=0;
	while ($arr=mysqli_fetch_array($r_4)) {
		# code...
		$num = mysqli_real_escape_string($h,($highest+$arr['sl_no']));
       $query_up = "update publications_table set sl_no=".$num." where sl_no=".$arr_slnums[$count]." ;";
       $r_up = mysqli_query($h,$query_up);
       $count++;
      
	}
	$count=0;
   while ($count!=sizeof($arr_slnums)) {
   	# code...
  $num = mysqli_real_escape_string($h,($highest+$arr_slnums[$count]));
   $query_up = "update publications_table set sl_no=".$arr_slnums[$count]." where sl_no=".$num." ;" ; 
   $r_up = mysqli_query($h,$query_up);
   $count++;
   }
  header("Location:publication_mod.php");
}

?>
