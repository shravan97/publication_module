<?php 
$h=mysqli_connect("localhost","root","Lordsvn_97","publications") or die("Error .....  ".mysqli_errno($h)); 
$query="select * from publications_table;";
$r=mysqli_query($h,$query) or die("Error 1	.....  ".mysqli_errno($h));

if(isset($_GET['delete'])){
	$sl = mysqli_real_escape_string($h , $_GET['delete']);
	$query_delete = "delete from publications_table where sl_no=".$sl.";";
	$r_del = mysqli_query($h,$query_delete);
	header("Location:publication_mod.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
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
$counter=0;$arr_num=array();	
$rows=mysqli_num_rows($r);
while($arr=mysqli_fetch_array($r)){$arr_num[$counter]=$arr['sl_no'];
echo "<tr>
         <td class='bordered'>".($counter+1)."</td>".
         "<td class='bordered'>".$arr['publication']."</td>".
         "<td class='bordered'>".$arr['saved_time']."</td>".
         "<td class='bordered'>".$arr['created_time']."</td>".
         "<td class='unbordered'><button> <a href='edit.php?edit=".$arr['sl_no']."'>EDIT</a> </button></td>".
         "<td class='unbordered'><button> <a href='publication_mod.php?delete=".$arr['sl_no']."'>DELETE</a></button></td>";
           
$prev=$arr['sl_no'];
$counter++;}

?>
</table>
<button><a href="order.php">REARRANGE</a></button>
<button><a href="rearrange.php?sort=1234">SORT</a></button>
</body>
<script type="text/javascript">
/*	
  $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  });
*/

function rearrange(){
  $.ajax({
    type:'POST',
    url:"rearrange.php",
    data:{arr_vals:arr},
    success:function(msg){
      if(msg=="success")
      window.location.reload();

    }
  });

}
</script>
</html>
