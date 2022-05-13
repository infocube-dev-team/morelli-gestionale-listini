<br>


<form method="POST" action="erase.php">


</p>

<div align="center">
	<table border="0" cellspacing="1" id="table1">
		<tr>
			<td colspan="2">
			<p align="center"><b><font color="#FF0000">Conferma Eliminazione per elemento Finissaggio:</font></b></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
			<p align="center">
			<input type="text" align="center" name="nome" size="54" value="<?php echo $_GET['nome'];?>"></p>
			<p>
			<input type="hidden" name="id" size="20" value="<?php echo $_GET['id'];?>"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<input type="submit" value="Conferma Eliminazione" name="conferma" style="color: #FF0000"></td>
			<td>
			<input type="submit" value="Annulla Eliminazione" name="reset"></td>
		</tr>
	</table>
</div>


	<p>&nbsp;</p>
</form>