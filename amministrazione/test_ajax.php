<link rel="stylesheet" type="text/css" href="ajax/jquery-ui.css">
<script src="ajax/jquery.min.js"></script>
<script src="ajax/jquery-ui.min.js"></script>

<form action="<?php echo $PHP_SELF;?>"  method="post">
<fieldset>
<legend>jQuery UI Autocomplete Example - PHP Backend</legend>
<p>Start typing the name of a state or territory of the United States</p>
<p class="ui-widget"><label for="state">State (abbreviation in separate field): </label>
    <input type="text" id="state"  name="state" /> <input readonly="readonly" type="text" id="abbrev" name="abbrev" maxlength="2" size="2"/></p>
    <input type="text" id="state_id" name="state_id" />
	<p><input type="submit" name="submit" value="Submit" /></p>
	</fieldset>
	</form>




<?php
if (isset($_POST['submit'])) {
echo "<p>";
    while (list($key,$value) = each($_POST)){
    echo "<strong>" . $key . "</strong> = ".$value."<br />";
    }
echo "</p>";
}
?>


<script>
$(function() {
	 
	            $('#abbrev').val("");
	 
	            $("#state").autocomplete({
	                source: "ajax/states.php",
	                minLength: 2,
	                select: function(event, ui) {
	                    $('#state_id').val(ui.item.id);
	                    $('#abbrev').val(ui.item.abbrev);
	                }
	            });
	        });
</script>



