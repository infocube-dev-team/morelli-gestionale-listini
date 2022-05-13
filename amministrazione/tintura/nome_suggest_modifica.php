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
	    $fetch = mysql_query("SELECT * FROM tintura where descrizione like '%" . $_GET['term'] . "%'");

	    /* Retrieve and store in array the results of the query.*/

	    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
			$row_array['id'] = $row['id'];
	        $row_array['value'] = $row['descrizione'];
	        $row_array['cod_art_fornitore'] = $row['cod_art_fornitore'];
	        $row_array['id_fornitore'] = $row['id_fornitore'];
	        $row_array['m1'] = $row['m1'];
	        $row_array['m2'] = $row['m2'];
	        $row_array['m3'] = $row['m3'];
	        $row_array['m4'] = $row['m4'];
	        $row_array['m5'] = $row['m5'];
	        $row_array['m6'] = $row['m6'];
	        $row_array['m7'] = $row['m7'];
	        $row_array['m8'] = $row['m8'];
	        $row_array['c1'] = $row['c1'];
	        $row_array['c2'] = $row['c2'];
	        $row_array['c3'] = $row['c3'];
	        $row_array['c4'] = $row['c4'];
	        $row_array['c5'] = $row['c5'];
	        $row_array['c6'] = $row['c6'];
	        $row_array['c7'] = $row['c7'];
	        $row_array['c8'] = $row['c8'];

	        $id_fornitore = $row['id_fornitore'];

				    $fetchs = mysql_query("SELECT * FROM fornitori where id='$id_fornitore'");
			
				    while ($rows = mysql_fetch_array($fetchs, MYSQL_ASSOC)) {
				        $row_array['fornitore'] = $rows['ragione_sociale'];
				     }

	        array_push($return_arr,$row_array);
	    }
	}

	/* Free connection resources. */
	mysql_close($conn);

	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);


?>
