<?php
/**
 * Variabili da esterno include
 * @var $id
 * @var $minimo
 * @var $smin
 * @var $attiva_1
 * @var $c0list
 * @var $c1list
 * @var $c2list
 * @var $c3list
 * @var $c4list
 * @var $c5list
 * @var $c6list
 * @var $modifica_articolo
 *
 */
$db             = DB::getInstance();
$articoliHelper = ArticoliHelper::getInstance();
$listiniHelper  = ListiniHelper::getInstance();
$listiniTable   = ListiniTable::getInstance();
$metratureAttive = $listiniHelper-> getMetratureAttive();
$diffsAttive = $articoliHelper-> getDiffMetratureAttive(false, false);

$isAttiva2 = $listiniHelper->isAttiva2( $smin );
$headers   = $listiniTable->getHeaders( $smin, $minimo );

//------------Seleziona ricarichi------------
$cListf = [];
$ricarichi = $listiniHelper->getRicarichi();
$r1        = $ricarichi['r1']['value'];
$r31       = $ricarichi['r31']['value'];
$r100      = $ricarichi['r100']['value'];
$r200      = $ricarichi['r200']['value'];
$r300      = $ricarichi['r300']['value'];
$r400      = $ricarichi['r400']['value'];
$r500      = $ricarichi['r500']['value'];
$rsmin     = $ricarichi['rsmin']['value'];


$totali = array(
	$c1list,
	$c2list,
	$c3list,
	$c4list,
	$c5list,
	$c6list
);


//---------------metto il ricarico----------
if ( $attiva_1 ) {
	$cListf[ArticoliHelper::COSTO_METRATURA_1] = $c0list * ( 1 + ( $r1 / 100 ) );
} else {
	$cListf[ArticoliHelper::COSTO_METRATURA_1] = "-";
}

$cListf[ArticoliHelper::COSTO_METRATURA_31] = $c1list * ( 1 + ( $r31 / 100 ) );
$cListf[ArticoliHelper::COSTO_METRATURA_100] = $c2list * ( 1 + ( $r100 / 100 ) );
$cListf[ArticoliHelper::COSTO_METRATURA_200] = $c3list * ( 1 + ( $r200 / 100 ) );
$cListf[ArticoliHelper::COSTO_METRATURA_300] = $c4list * ( 1 + ( $r300 / 100 ) );
$cListf[ArticoliHelper::COSTO_METRATURA_400] = $c5list * ( 1 + ( $r400 / 100 ) );
$cListf[ArticoliHelper::COSTO_METRATURA_500] = $c6list * ( 1 + ( $r500 / 100 ) );

$cListf[ArticoliHelper::COSTO_METRATURA_1] = ( $isAttiva2 == 1 ) ?
	round( $cListf[ArticoliHelper::COSTO_METRATURA_31] + ( $cListf[ArticoliHelper::COSTO_METRATURA_31] * $rsmin / 100 ), 2 ) :
	"";

if ( $isAttiva2 == 1 ) {
	$cListf[ArticoliHelper::COSTO_METRATURA_MIN] = $cListf[ArticoliHelper::COSTO_METRATURA_31] + ( $cListf[ArticoliHelper::COSTO_METRATURA_31] * ( $rsmin / 100 ) );
} else {
	$cListf[ArticoliHelper::COSTO_METRATURA_MIN] = "-";
}

//verifico se ci sono prezzi uguali ed applico una differenza di 0,20
$elem = array();
for ( $i = count($metratureAttive)-1; $i > 0; $i -- ) {
	if ( $cListf["cm" . $metratureAttive[$i]] == $cListf["cm" . $metratureAttive[$i - 1]] ) {
		array_push( $elem, "cm" . $metratureAttive[$i - 1]);
	}
}

for ( $f = 0; $f < count( $elem ); $f ++ ) {
	$g                 = $f + 1;
	$k                 = $elem[ $f ];
	$cListf[$k] += ( $g * 0.15 );
}

//---------arrotondamento----------

// ricavo la parte decimale
//				$intpart = floor($c1list);
//				$dec = $c1list-$intpart;

foreach ($cListf as $key => $cL) {
	$intpart[$key] = floor( $cL );
	$dec[$key] = $cL - $intpart[$key];
}

$arr1 = 0.15;
$arr2 = 0.35;
$arr3 = 0.55;
$arr4 = 0.75;
$arr5 = 0.95;
$arr6 = 0.99;
// todo: @infocube non è presente arr7 in quanto escluso da eventuali arrotondamenti

$n = 1;
if ( $attiva_1 == 1 ) {
	$n = 0;
};

for ( $n = 0; $n < 7; $n ++ ) {
	for ( $i = 1; $i < 6; $i ++ ) {
		$j = $i + 1;
		if ( ${"dec$n"} > ${"arr$i"} && ${"dec$n"} <= ${"arr$j"} ) {
			${"dec$n"} = ${"arr$j"};
		} elseif ( ${"dec$n"} < $arr1 ) {
			${"dec$n"} = $arr1;
		} elseif ( ${"dec$n"} > $arr6 ) {
			${"dec$n"} = 1 + $arr1;
		}
		${"c$n" . "listf"} = ${"intpart$n"} + ${"dec$n"};
	}
}

//ripasso di tutti i costi per verificare eventuali costi uguali
for ( $i = 6; $i > 0; $i -- ) {
	$k = $i - 1;
	if ( ${"c$i" . "listf"} == ${"c$k" . "listf"} ) {
		$g                 = 1;
		${"c$k" . "listf"} = ${"c$k" . "listf"} + ( $g * 0.20 );
	}
}

//verifico se le variazioni hanno comportato un disallineamento dei costi
for ( $i = 3; $i < 7; $i ++ ) {
	if ( $cListf[ArticoliHelper::COSTO_METRATURA_100] < ${"c$i" . "listf"} ) {
		$cListf[ArticoliHelper::COSTO_METRATURA_100] = $cListf[ArticoliHelper::COSTO_METRATURA_200] + 0.20;
	}
}
//echo "attiva= ".$attiva_1."  ";

$totaleRicarichi = array(
	$cListf[ArticoliHelper::COSTO_METRATURA_1],
	$cListf[ArticoliHelper::COSTO_METRATURA_31],
	$cListf[ArticoliHelper::COSTO_METRATURA_100],
	$cListf[ArticoliHelper::COSTO_METRATURA_200],
	$cListf[ArticoliHelper::COSTO_METRATURA_300],
	$cListf[ArticoliHelper::COSTO_METRATURA_400],
	$cListf[ArticoliHelper::COSTO_METRATURA_500],
);


$diffc   = array(
	'cm1'    => 0,
	'cm31'   => 0,
	'cm100'  => 0,
	'cm200'  => 0,
	'cm300'  => 0,
	'cm400'  => 0,
	'cm500'  => 0,
	'cmsmin' => 0
);
$diff    = array();
$diff[0] = 0;
if ( isset( $_GET['Ricalcola'] ) ) {
	$i = 0;
	foreach ( $diffc as $key => $valore ) {

		if ( $_GET[ $key ] != 0 ) {
			$valore     = str_replace( ",", ".", $_GET[ $key ] );
			$diff[ $i ] = $valore;
		}
		//echo $valore;
		//echo $i." ";
		$i ++;
	}
	//echo "   /".$diff[0]."/    ";

	$articoliRicalcola = array(
		"cmsmin" => empty( $diff[7] ) ? '0' : $diff[7],
		"cm1"    => $diff[0],
		"cm31"   => $diff[1],
		"cm100"  => $diff[2],
		"cm200"  => $diff[3],
		"cm300"  => $diff[4],
		"cm400"  => $diff[5],
		"cm500"  => $diff[6]
	);

	if ( ! $db->update(
		"articoli",
		$articoliRicalcola,
		"id = '$id'"
	) ) {
		echo "<strong>Errore di ricalcolo: " . $db->getError() . "</strong>";
	}

} else {
	if ( isset( $modifica_articolo ) ) {
		if ( ( $diff[7] == null || $diff[7] == 0 ) && ( $isAttiva2 == 1 ) ) {

			$diff[7] = round( $cListf[ArticoliHelper::COSTO_METRATURA_31] + ( $cListf[ArticoliHelper::COSTO_METRATURA_31] * $rsmin / 100 ), 2 );
			if ( ! $db->update(
                "articoli",
                array(
                    'cmsmin' => $diff[7]
                ),
                "id = '$id'"
            ) ) {
                echo "<strong>Errore aggioranemtno cmsmin: " . $db->getError() . "</strong>";
            }

		}
	}
}

?>

<fieldset>


    <legend class="info"> Listino:</legend>

    <div align="center">
        <table border="2" cellspacing="1" id="table7">
            <tr>
                <td>Metrature:</td>
				<?php
				foreach ( $headers as $header ) {
					?>
                    <td align="center"><b><?php echo $header ?></b></td>
					<?php
				}
				?>
            </tr>
            <tr>
                <td>Totali:</td>
                <td align="center"><?php echo "-" ?></td>
				<?php
				foreach ( $totali as $totale ) {
					?>
                    <td align="center"><b><?php echo $totale ?></b></td>
					<?php
				}
				?>
            </tr>
            <tr>
                <td>Ricarico:</td>
				<?php
				foreach ( $totaleRicarichi as $totaleRicarico ) {
					?>
                    <td align="center"><b><?php echo $totaleRicarico ?></b></td>
					<?php
				}
				?>
            </tr>

			<?php

			//-------------------Definisco le differenze conti manuali------------
			$diffs = $articoliHelper->getDiffs( $id );
			foreach ( $diffs as $key => &$diff ) {

				if ( $diff == 0 ) {
					$color[ $key ] = "#66CCFF";
					$diff  = "0";
				} else {
					if ( $diff < 0 ) {
						$color[ $key ] = "#FF0000";
					}
					if ( $diff > 0 ) {
						$color[ $key ] = "#00FF00";
					}
				}
			}
			?>


            <tr>
                <td>
                    <p align="right">Diff.</p>
                </td>

                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_MIN ]; ?>">
                        <?php echo ( $isAttiva2 == 1 ) ? round( $diffs[ArticoliHelper::COSTO_METRATURA_MIN] - $cListf[ArticoliHelper::COSTO_METRATURA_MIN], 2 ) : "-"; ?>
                    </span>
                </td>

                <?php
                foreach ($diffsAttive as $diffAttiva) {
                ?>

                    <td align="center">
                        <span style="color: <?php echo $color[ $diffAttiva ]; ?>">
                            <?php echo round( $diffs[$diffAttiva] - $cListf[$diffAttiva], 2 ); ?>
                        </span>
                    </td>

                <?php
                }
                ?>

                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_31 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_31] - $cListf[ArticoliHelper::COSTO_METRATURA_31], 2 ); ?>
                    </span>
                </td>

                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_100 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_100] - $cListf[ArticoliHelper::COSTO_METRATURA_100], 2 ); ?>
                    </span>
                </td>
                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_200 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_200] - $cListf[ArticoliHelper::COSTO_METRATURA_200], 2 ); ?>
                    </span>
                </td>
                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_300 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_300] - $cListf[ArticoliHelper::COSTO_METRATURA_300], 2 ); ?>
                    </span>
                </td>
                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_400 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_400] - $cListf[ArticoliHelper::COSTO_METRATURA_400], 2 ); ?>
                    </span>
                </td>
                <td align="center">
                    <span style="color: <?php echo $color[ ArticoliHelper::COSTO_METRATURA_500 ]; ?>">
                        <?php echo round( $diffs[ArticoliHelper::COSTO_METRATURA_500] - $cListf[ArticoliHelper::COSTO_METRATURA_500], 2 ); ?>
                    </span>
                </td>
            </tr>


			<?php
			if ( $attiva_1 == 0 ) {
				$disabil = "Disabled";
			} else {
				$disabil = null;
			}
			if ( $isAttiva2 == 0 ) {
				$disabil2 = "Disabled";
			} else {
				$disabil2 = null;
			}
			?>

            <tr>
                <td>Modifiche Manuali:</td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_MIN ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_MIN]; ?>" <?php echo $disabil2 ?> />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_31 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_31]; ?>" />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_100 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_100]; ?>" />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_200 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_200]; ?>" />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_300 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_300]; ?>" />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_400 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_400]; ?>" />
                </td>
                <td align="center">
                    <input type="text" name="<?php echo ArticoliHelper::COSTO_METRATURA_500 ?>" size="5" value="<?php echo $diffs[ArticoliHelper::COSTO_METRATURA_500]; ?>" />
                </td>
            </tr>
        </table>
    </div>


</fieldset>
