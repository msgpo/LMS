 <style type="text/css">
	p1{
		color:red;
    }
</style>
<form action=<?php echo base_url()?>index.php/sportController/update method="post" accept-charset="utf-8">
<input type="hidden" name="sport_id" value="<?php echo  $row[0]->sport_id;?>">
<p>Sportname: <input type="text" name="sportname" value="<?php echo ucwords($row[0]->sportname); ?>"></p><input type="submit" name="" value="Edit Sport"></form>
<?php 
/**
echo form_open('sportController/update');
echo form_hidden('sport_id', $row[0]->sport_id);

// an array of the fields in the student table
$field_array = array('sportname');
foreach($field_array as $field_name)
{
  echo '<p>' . $field_name;
  echo form_input($field_name, $row[0]->$field_name) . '</p>';
}

// not setting the value attribute omits the submit from the $_POST array
echo form_submit('', 'Edit Sport'); 
echo form_close();
**/
echo '<p1>'.validation_errors().'</p1>'; 
?>