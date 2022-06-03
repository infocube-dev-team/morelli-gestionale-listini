
<head>
    <link rel="stylesheet" type="text/css" href="../../style.css">
</head>

<fieldset> <legend class="titoli">Opzioni per la stampa del Listino</legend>





    <?php
    include("cat.php");
    //--------------------Seleziona Articolo dal Database-------------------
    $con = mysql_connect($localhost.":".$localporta,$locallogin,$localpass);
    if (!$con)
    {
        die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($localnome, $con);


    $query  = "SELECT larghezza, righe, ordine, mostra_altezza, misura, contorni, moneta, separatore, font, font_dim, r500, r400, r300, r200, r100, r31, r1, rsmin FROM opzioni_listino";
    $result = mysql_query($query);
    while($row = mysql_fetch_row($result))
    {
        $larghezza = $row[0];
        $righe = $row[1];
        $ordine = $row[2];
        $mostra_altezza = $row[3];
        $misura = $row[4];
        $contorni = $row[5];
        $moneta = $row[6];
        $separatore = $row[7];
        $font = $row[8];
        $font_dim = $row[9];

        $r500 = $row[10];
        $r400 = $row[11];
        $r300 = $row[12];
        $r200 = $row[13];
        $r100 = $row[14];
        $r31 = $row[15];
        $r1 = $row[16];

        $rsmin = $row[17];
    }
    ?>





    <form method="POST" action="opzioni_update.php">

        <div align="center">
            <table border="0" cellspacing="2" cellpadding="2" id="table1">
                <tr>
                    <td>Larghezza Pagina</td>
                    <td>
                        <input type="text" name="larghezza" size="5" value="<?php echo $larghezza;?>">px</td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td colspan="2">Ricarichi Listino</td>
                </tr>
                <tr>
                    <td>Numero di righe x pag.</td>
                    <td>
                        <input type="text" name="righe" size="5" value="<?php echo $righe;?>"></td>
                    <td>&nbsp;</td>
                    <?php /*
                    <td>|</td>
                    <td>500 mt.</td>
                    <td>
                        <input type="text" name="r500" size="3" value="<?php echo $r500;?>">%</td>*/ ?>
                </tr>
                <tr>
                    <td>Ordina per </td>
                    <td><select size="1" name="ordine">
                            <option value="nome">Nome Articolo</option>
                        </select></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
                    <?php /*
                    <td>|</td>
                    <td>400 mt.</td>
                    <td><input type="text" name="r400" size="3" value="<?php echo $r400;?>">%</td> */ ?>
                </tr>
                <tr>
                    <td>Mostra Altezza</td>
                    <td>

                        <?php
                        if($mostra_altezza=="ON"){
                            $checked = "checked";
                        }else{
                            $checked = NULL;
                        }
                        ?>

                        <input class="radio" type="checkbox" name="mostra_altezza" value="ON" <?php echo $checked;?>></td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>300 mt</td>
                    <td>

                        <input type="text" name="r300" size="3" value="<?php echo $r300;?>">%</td>
                </tr>
                <tr>
                    <td>Unita di misura alt.</td>
                    <td>
                        <select size="1" name="misura">
                            <?php
                            if($misura=="mt"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="mt" <?php echo $selected;?>>mt.</option>

                            <?php
                            if($misura=="cm"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="cm" <?php echo $selected;?>>cm.</option>

                            <?php
                            if($misura=="mm"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="mm" <?php echo $selected;?>>mm.</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>200 mt</td>
                    <td>
                        <input type="text" name="r200" size="3" value="<?php echo $r200;?>">%</td>
                </tr>
                <tr>
                    <td>Contorni Tabella</td>
                    <td>
                        <input type="text" name="contorni" size="5" value="<?php echo $contorni;?>"></td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>100 mt.</td>
                    <td>
                        <input type="text" name="r100" size="3" value="<?php echo $r100;?>">%</td>
                </tr>
                <tr>
                    <td>Moneta</td>
                    <td>
                        <input type="text" name="moneta" size="5" value="<?php echo $moneta;?>"></td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>31&nbsp;&nbsp; mt.</td>
                    <td>
                        <input type="text" name="r31" size="3" value="<?php echo $r31;?>">%</td>
                </tr>
                <tr>
                    <td>Separatore</td>
                    <td>
                        <input type="text" name="separatore" size="5" value="<?php echo $separatore;?>">
                    </td>

                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>1&nbsp;&nbsp;&nbsp;&nbsp; mt.</td>
                    <td>
                        <input type="text" name="r1" size="3" value="<?php echo $r1;?>">%</td>
                </tr>
                <tr>
                    <td>Carattere</td>
                    <td>
                        <select size="1" name="font">

                            <?php
                            if($font=="arial"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="arial" <?php echo $selected;?>>Arial</option>

                            <?php
                            if($font=="curier"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="curier" <?php echo $selected;?>>Curier</option>

                            <?php
                            if($font=="verdana"){
                                $selected = "selected";
                            }else{
                                $selected = NULL;
                            }
                            ?>
                            <option value="verdana" <?php echo $selected;?>>Verdana</option>
                        </select>
                    </td>
                    <td>&nbsp;</td>
                    <td>|</td>
                    <td>smin&nbsp;&nbsp;</td>
                    <td>
                        <input type="text" name="rsmin" size="3" value="<?php echo $rsmin;?>">%</td>
                </tr>
                <tr>
                    <td>Dimensioni carattere</td>
                    <td>
                        <input type="text" name="font_dim" size="5" value="<?php echo $font_dim;?>"></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
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
                $cnt = 0;
                $query  = "SELECT id, nome, ordine FROM seq_accoppiature ORDER BY ordine";
                $result = mysql_query($query);
                while($row = mysql_fetch_row($result))
                {

                    $seq = seq.$row[0];
                    $ordine_seq = ordine_seq.$row[0];
                    $nome = $row[1];
                    $ordine = $row[2];

                    $id = $row[0];
                    ?>
                    <tr>
                        <td>
                            <input type="text" name="<?php echo $seq;?>" value="<?php echo $nome;?>" size="20">
                        </td>


                        <td>
                            <input type="text" name="<?php echo $ordine_seq;?>" size="5" value="<?php echo $ordine;?>">
                        </td>

                        <td align="left">
                            <?php
                            //$cnt = $cnt+1;
                            //if($cnt>7){

                            if($ordine==0){
                                ?>
                                <a href="opzioni_update.php?operazione=elimina&id=<?php echo $id;?>"> - </a>
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
                        <p align="left"><a href="opzioni_update.php?operazione=aggiungi">Aggiungi Nuova Sequenza</a></td>
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

    <?php
    mysql_close($con);
    ?>


</fieldset>
