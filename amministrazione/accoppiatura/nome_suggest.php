<?php
$return_arr = array();

	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'kondor';
	$dbname = 'gestionale';

	$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
	mysql_select_db($dbname);

	/* If connection to database, run sql statement. */
	if ($conn)
	{
	    $fetch = mysql_query("SELECT * FROM accoppiatura where descrizione like '%" . $_GET['term'] . "%'");

	    /* Retrieve and store in array the results of the query.*/

	    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
			$row_array['id'] = $row['id'];
	        $row_array['value'] = $row['descrizione'];
	        

	        array_push($return_arr,$row_array);
	    }
	}

	/* Free connection resources. */
	mysql_close($conn);

	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);


?>
