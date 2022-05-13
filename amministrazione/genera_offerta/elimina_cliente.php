<?php
  include("cat.php");

$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);
  
  $id=$_POST['id'];
  
  
  $query="DELETE FROM clienti WHERE id='$id'";
  echo $query;
  $result=mysql_query($query);
  if($result!=FALSE){ 
	header('Location: seleziona_cliente.php');
  } 
?>