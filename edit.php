<?php 

$h=mysqli_connect("localhost","root","Lordsvn_97","publications")  or die("Error....".mysqli_errno($h));
    
if (isset($_POST['btn_sub'])) {
	if (!empty($_POST["new_publication"])) {
		$publication_text=mysqli_real_escape_string($h,$_POST["new_publication"]);
		$query1= "update publications_table set publication='$publication_text' , saved_time=CURRENT_TIMESTAMP where sl_no=".$_GET['edit'].";";
		$r1=mysqli_query($h,$query1) or die("Error....".mysqli_errno($h));
		header("Location:publication_mod.php");

	}
	
	else echo "Please enter in a proper publication or delete it from the publications page";
}

if(!isset($_GET['edit'])){
header("Location:publication_mod.php");
}
else{
	$edit_num= mysqli_real_escape_string($h,$_GET['edit']);
    $query="select * from publications_table where sl_no=".$edit_num.";";
    $r=mysqli_query($h,$query);
    $arr=mysqli_fetch_array($r);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" enctype="multipart/form-data" action="edit.php?edit=<?php echo $arr['sl_no'];?>">
<textarea name="new_publication"><?php echo $arr['publication'];?></textarea>
<br/>
<input type="submit" name="btn_sub" value="SUBMIT">
</form>
</body>
</html>

