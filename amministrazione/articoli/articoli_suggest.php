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
	    $fetch = mysql_query("SELECT * FROM articoli where nome like '%" . $_GET['term'] . "%'");

	    /* Retrieve and store in array the results of the query.*/

	    while ($row = mysql_fetch_array($fetch, MYSQL_ASSOC)) {
	    
	     $nriga = NULL;
	    
			$row_array['id'] = $row['id'];
	        $row_array['value'] = $row['nome'];
	        $row_array['codice'] = $row['codice'];
	        $row_array['collezione'] = $row['collezione'];
	        $row_array['composizione'] = $row['composizione'];
	        $row_array['altezza'] = $row['altezza'];
	        $row_array['seq_accoppiature'] = $row['seq_accoppiature'];

					
					$seq_accoppiature = $row['seq_accoppiature'];
					$narticolo = $row['nome'];
	
				    $fetchs = mysql_query("SELECT * FROM seq_accoppiature where ordine='$seq_accoppiature'");

				    while($rows = mysql_fetch_array($fetchs, MYSQL_ASSOC)) {
				        //$row_array['value'] = $row['nome']." -> ".$rows['nome'];
				        
				        $nriga = "  - (".$rows['nome'].") ";
				     }
				     
				     $row_array['value'] = $narticolo.$nriga;


	        array_push($return_arr,$row_array);
	    }
	}


	/* Free connection resources. */
	mysql_close($conn);

	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);


?>
