<?php
session_start();
$return_arr = array();

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'kondor';
	$dbname = 'gestionale';

	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	mysql_select_db($dbname);

	if ($conn)
	{
	    $fetch = mysql_query("SELECT * FROM fornitori where ragione_sociale like '%" . $_GET['term'] . "%'");
	    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
			$row_array['fornitore_id'] = $row['id'];
	        $row_array['value'] = $row['ragione_sociale'];


	        array_push($return_arr,$row_array);
	        
	    }

	}

	mysql_close($conn);

	echo json_encode($return_arr);


?>
