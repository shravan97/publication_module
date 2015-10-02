<?php 
include "db_connect.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>Rearrange</title>
	<style type="text/css">
	table, .bordered{
     border:1px solid black;
     padding: 2px;
     cursor: pointer;
     }
     thead{
     	font-weight: bold;
     }
     a{
     	text-decoration: none;
     	color: white;
     	font-weight: bold;
     	font-size: 1.2em;
     }
     button{
     	background: #0B4118;
     	height: 3em;
     }
     .big{
     	font-size: 1em;
     	font-weight: bolder;
     	color: white;
     }

	</style>
	 <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script> 
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>    
</head>
<body>

<table id='publications'>
  <thead>
  	<td class="bordered">
  		sl_no
  	</td>
  	<td class="bordered">
  		Publication
  	</td>
  	<td class="bordered">
  		Saved Time
  	</td>
    <td class="bordered">
      Created Time
    </td>
  </thead>
<?php 
$query="select * from publications_table;";
$r=mysqli_query($h,$query) or die("Error 1	.....  ".mysqli_errno($h));
$counter=0;$arr_num=array();	
$rows=mysqli_num_rows($r);
while($arr=mysqli_fetch_array($r)){$arr_num[$counter]=$arr['sl_no'];
echo "<tr id='".($arr['sl_no'])."'>
         <td class='bordered'>".($counter+1)."</td>".
         "<td class='bordered' id='publication".($counter+1)."'>".$arr['publication']."</td>".
         "<td class='bordered'id='timer".($counter+1)."'>".$arr['saved_time']."</td>
          <td class='bordered' id='ctime".($counter+1)."'>".$arr['created_time']."</td>";
         if($counter!=$rows-1)
         echo"<td class='unbordered'><button onclick='change_position(".($counter+1).",1,".$arr['sl_no'].");'> <span class='big'>&#x2193;</span></button></td>";
         if($counter>0)
         echo"<td class='unbordered'><button onclick='change_position(".($counter+1).",-1,".$arr['sl_no'].");'> <span class='big'>&#x2191;</span></button></td>".
      "</tr class='bordered'>
     ";   
$prev=$arr['sl_no'];
$counter++;}



?>
</table>
<button class='big' onclick="request();">DONE</button>
</body>
<script type="text/javascript">
	var arr=[];
<?php 
for($i=0;$i<sizeof($arr_num);$i++){
  echo "arr[".$i."]=".$arr_num[$i].";";
}
?>
function change_arr(x1,x2){
var temp;
temp = arr[x1];
arr[x1]=arr[x2];
arr[x2]=temp;


}

function change_position(sl_num , move , sl_no) 
  {
	
var rows = document.getElementsByTagName('tr');
var temp;
temp= rows[sl_num].cells[1].innerHTML;
rows[sl_num].cells[1].innerHTML = rows[sl_num+move].cells[1].innerHTML;
rows[sl_num+move].cells[1].innerHTML = temp;
 
temp = rows[sl_num].cells[2].innerHTML;
rows[sl_num].cells[2].innerHTML = rows[sl_num+move].cells[2].innerHTML;
rows[sl_num+move].cells[2].innerHTML = temp;

temp = rows[sl_num].cells[3].innerHTML;
rows[sl_num].cells[3].innerHTML = rows[sl_num+move].cells[3].innerHTML;
rows[sl_num+move].cells[3].innerHTML = temp;


change_arr(sl_num-1,sl_num-1+move);

$("#publication"+String(sl_num)+" , "+"#timer"+String(sl_num)+" , "+"#ctime"+String(sl_num)).animate({
  backgroundColor:"blue"
});
setTimeout( function(){
$("#publication"+String(sl_num)+" , "+"#timer"+String(sl_num)+" , "+"#ctime"+String(sl_num)).animate({
  backgroundColor:"white"
});
	} , 1000);	
  // body...
$("#publication"+String((sl_num+move))+" , "+"#timer"+String((sl_num+move))+" , "+"#ctime"+String((sl_num+move))).animate({
  backgroundColor:"yellow"
});
setTimeout( function(){
$("#publication"+String((sl_num+move))+" , "+"#timer"+String((sl_num+move))+" , "+"#ctime"+String((sl_num+move))).animate({
  backgroundColor:"white"
});
  } , 1000);  
  

}
function request(){
$.ajax({
    type:'POST',
    url:"rearrange.php",
    data:{arr_vals:arr},
    success:function(msg){
      if(msg=="success")
      window.location.href='publication_mod.php';

    }
});
}
</script>
</html>
