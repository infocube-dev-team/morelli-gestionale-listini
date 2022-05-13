<?php
include("cat.php");
//--------------------Controlla login dal Database-------------------
$con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
   }
 mysql_select_db($localnome, $con);

		$query  = "SELECT id, nome FROM articoli";
		$result = mysql_query($query);
			while($row = mysql_fetch_row($result))
			{
			  $id_articolo = $row[0];
			  $nome_articolo = strtoupper($row[1]);
			  $nome_articolo1 = str_replace(".", " ", $row[1]);

			  $nome_articolo = explode(" ", $nome_articolo);
				$last = end($nome_articolo);
				$last = trim($last);

				$querya  = "SELECT nome, ordine FROM seq_accoppiature";
				$resulta = mysql_query($querya);
					while($rowa = mysql_fetch_row($resulta))
					{
					  $seq_nome = strtoupper($rowa[0]);
					  $seq_nome = trim($seq_nome);
					  $seq_ordine = $rowa[1];

						if($last==$seq_nome){
							echo $nome_articolo1."  --->   $last   ordine: $seq_ordine\n";
							   $queryt = "UPDATE articoli SET seq_accoppiature='$seq_ordine' WHERE id='$id_articolo'";
 								$resultt = mysql_query($queryt);

							   $nome_articolo = str_replace($seq_nome, "", $nome_articolo1);
							   $queryt = "UPDATE articoli SET nome='$nome_articolo' WHERE id='$id_articolo'";
 								$resultt = mysql_query($queryt);
						}

					}


			}




mysql_close($con);
?>