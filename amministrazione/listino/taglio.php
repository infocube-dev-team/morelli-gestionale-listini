<?php
function TagliaStringa($stringa, $max_char){
			$stringa_tagliata=substr($stringa, 0,$max_char);
			$last_space=strrpos($stringa_tagliata," ");
			$stringa_ok=substr($stringa_tagliata, 0,$last_space);
			$lunghezza=strlen($stringa_ok);
			$stringa_dopo=substr($stringa, $lunghezza);
			$risultato=array ($stringa_ok,$stringa_dopo);
			return $risultato;
	}
	
/* 	$stringa = "Questa stringa verrà tagliata mantenendo le parole intere";
	$risultato=array();
	$risultato = TagliaStringa($stringa, 40);

	 echo "stringa: ".$stringa."<br> stringa tagliata: ".$risultato[0]."<br>".$risultato[1];
*/
?>