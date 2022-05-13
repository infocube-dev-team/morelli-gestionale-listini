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
	    $fetch = mysql_query("SELECT * FROM articoli where nome like '%" . $_GET['term'] . "%' AND stampa='ON'");

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
			$row_array['dettagli'] = $row['dettagli'];
			
					$id_articolo = $row['id'];
					$seq_accoppiature = $row['seq_accoppiature'];
					$narticolo = $row['nome'];

				    $fetchs = mysql_query("SELECT * FROM seq_accoppiature where ordine='$seq_accoppiature'");
				    while($rows = mysql_fetch_array($fetchs, MYSQL_ASSOC)) {
				        $nriga = "  - (".$rows['nome'].") ";
				     }
				     $row_array['value'] = $narticolo.$nriga;


				    $fetchsh = mysql_query("SELECT * FROM listino where id_articolo='$id_articolo'");
				    while($rowsh = mysql_fetch_array($fetchsh, MYSQL_ASSOC)) {
				        $row_array['exdamt1'] = $rowsh['1mt'];
				        $row_array['exdamt31'] = $rowsh['31mt'];
				        $row_array['exdamt100'] = $rowsh['100mt'];
				        $row_array['exdamt200'] = $rowsh['200mt'];
				        $row_array['exdamt300'] = $rowsh['300mt'];
				        $row_array['exdamt400'] = $rowsh['400mt'];
				        $row_array['exdamt500'] = $rowsh['500mt'];
						
				     }

					
	        array_push($return_arr,$row_array);
	    }
	}

	/* Free connection resources. */
	mysql_close($conn);

	/* Toss back results as json encoded array. */
	echo json_encode($return_arr);


?>
