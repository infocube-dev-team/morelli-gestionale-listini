<?php
define( 'DS', DIRECTORY_SEPARATOR );
define( 'BASE_DIR', realpath( __DIR__ . DS . ".." . DS . ".." ) );
define( 'CONF_DIR', BASE_DIR . DS . "conf" );
define( 'LIB_DIR', BASE_DIR . DS . "lib" );
define( 'AMM_DIR', BASE_DIR . DS . "amministrazione" );

/**
 * @var $localhost
 * @var $localporta
 * @var $locallogin
 * @var $localpass
 * @var $localnome
 */
require_once CONF_DIR . DS . "conf.php";
require_once LIB_DIR . DS . "load.php";

$db = DB::getInstance();
$db -> connect();
$listiniHelper = ListiniHelper::getInstance();
?>

    <head>
        <link rel="stylesheet" type="text/css" href="../../style.css">
    </head>

    <fieldset>
        <legend class="titoli">Opzioni per la stampa del Listino</legend>


		<?php
		//    include("cat.php");
		//    //--------------------Seleziona Articolo dal Database-------------------
		//    $con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
		//    if (!$con)
		//    {
		//        die('Could not connect: ' . mysql_error());
		//    }
		//    mysql_select_db($localnome, $con);


		$ricarichi = $listiniHelper->getRicarichi();
		$options   = $listiniHelper->getOptions();

		if ( $options ) {
			$larghezza      = $options["larghezza"];
			$righe          = $options["righe"];
			$ordine         = $options["ordine"];
			$mostra_altezza = $options["mostra_altezza"];
			$misura         = $options["misura"];
			$contorni       = $options["contorni"];
			$moneta         = $options["moneta"];
			$separatore     = $options["separatore"];
			$font           = $options["font"];
			$font_dim       = $options["font_dim"];

			$r500  = $options["r500"];
			$r400  = $options["r400"];
			$r300  = $options["r300"];
			$r200  = $options["r200"];
			$r100  = $options["r100"];
			$r31   = $options["r31"];
			$r1    = $options["r1"];
			$rsmin = $options["rsmin"];
		}
		?>


        <form method="POST" action="opzioni_update.php">

            <div align="center">
                <table border="0" cellspacing="2" cellpadding="2" id="table1">
                    <tr>
                        <td valign="top">
                            <table border="0" cellspacing="2" cellpadding="2" id="table1">
                                <tr>
                                    <td>Larghezza Pagina</td>
                                    <td>
                                        <input type="text" name="larghezza" size="5" value="<?php echo $larghezza; ?>">px
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Numero di righe x pag.</td>
                                    <td>
                                        <input type="text" name="righe" size="5" value="<?php echo $righe; ?>"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Ordina per</td>
                                    <td><select size="1" name="ordine">
                                            <option value="nome">Nome Articolo</option>
                                        </select></td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Mostra Altezza</td>
                                    <td>

										<?php
										if ( $mostra_altezza == "ON" ) {
											$checked = "checked";
										} else {
											$checked = null;
										}
										?>

                                        <input class="radio" type="checkbox" name="mostra_altezza"
                                               value="ON" <?php echo $checked; ?>></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Unita di misura alt.</td>
                                    <td>
                                        <select size="1" name="misura">
											<?php
											if ( $misura == "mt" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="mt" <?php echo $selected; ?>>mt.</option>

											<?php
											if ( $misura == "cm" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="cm" <?php echo $selected; ?>>cm.</option>

											<?php
											if ( $misura == "mm" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="mm" <?php echo $selected; ?>>mm.</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Contorni Tabella</td>
                                    <td>
                                        <input type="text" name="contorni" size="5" value="<?php echo $contorni; ?>">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Moneta</td>
                                    <td>
                                        <input type="text" name="moneta" size="5" value="<?php echo $moneta; ?>"></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Separatore</td>
                                    <td>
                                        <input type="text" name="separatore" size="5"
                                               value="<?php echo $separatore; ?>">
                                    </td>

                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Carattere</td>
                                    <td>
                                        <select size="1" name="font">

											<?php
											if ( $font == "arial" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="arial" <?php echo $selected; ?>>Arial</option>

											<?php
											if ( $font == "curier" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="curier" <?php echo $selected; ?>>Curier</option>

											<?php
											if ( $font == "verdana" ) {
												$selected = "selected";
											} else {
												$selected = null;
											}
											?>
                                            <option value="verdana" <?php echo $selected; ?>>Verdana</option>
                                        </select>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>Dimensioni carattere</td>
                                    <td>
                                        <input type="text" name="font_dim" size="5" value="<?php echo $font_dim; ?>">
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                        <td valign="top">
                            <table border="0" cellspacing="2" cellpadding="2" id="table1">
                                <tr>
                                    <td>|</td>
                                    <td colspan="2">Ricarichi Listino</td>
                                </tr>
                                <?php
                                foreach ($ricarichi as $key => $ricarico) {
                                    $label = $ricarico['label'];
                                    $value = $ricarico['value'];
                                    ?>

                                        <tr>
                                            <td>|</td>
                                            <td><?php echo $label?></td>
                                            <td>
                                                <input type="text" name="<?php echo $key ?>" size="3" value="<?php echo $value; ?>">%
                                            </td>
                                        </tr>

                                    <?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <hr>
                            <p align="center"><b>Opzioni Sequenza Accoppiature</b></td>
                    </tr>
                    <tr>
                        <td>
                            <p align="center">Nome</td>
                        <td>
                            <p>Ordine</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>


					<?php
					$cnt    = 0;
					$query  = "SELECT id, nome, ordine FROM seq_accoppiature ORDER BY ordine";

					$accoppiature = $db -> query($query);
					foreach ($accoppiature as $accoppiatura) {

						$id = $accoppiatura['id'];
						$seq        = 'seq' . $id;
						$ordine_seq = 'ordine_seq' . $id;
						$nome       = $accoppiatura['nome'];
						$ordine     = $accoppiatura['ordine'];
						?>
                        <tr>
                            <td>
                                <input type="text" name="<?php echo $seq; ?>" value="<?php echo $nome; ?>" size="20">
                            </td>


                            <td>
                                <input type="text" name="<?php echo $ordine_seq; ?>" size="5"
                                       value="<?php echo $ordine; ?>">
                            </td>

                            <td align="left">
								<?php
								if ( $ordine == 0 ) {
									?>
                                    <a href="opzioni_update.php?operazione=elimina&id=<?php echo $id; ?>"> - </a>
									<?php
								}
								?>
                            </td>

                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
						<?php
					}
					?>


                    <tr>
                        <td colspan="2" align="center">
                            <p align="left"><a href="opzioni_update.php?operazione=aggiungi">Aggiungi Nuova Sequenza</a>
                        </td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <p align="center">

                                <input type="submit" value="Conferma" name="B1"></td>
                    </tr>
                </table>

            </div>

        </form>


    </fieldset>

<?php
DB::getInstance()->close();
