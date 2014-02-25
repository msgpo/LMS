 <style type="text/css">
	p1{
		color:red;
    }
</style>
<?php 
echo form_open('sportController/create');

// an array of the fields in the student table
$field_array = array('sportname');
foreach($field_array as $field)
{
  echo '<p> Sportname: ';
  echo form_input(array('name' => $field)) . '</p>';
}

// not setting the value attribute omits the submit from the $_POST array
echo form_submit('', 'Add Sport'); 

echo form_close();
echo '<p1>'.validation_errors().'</p1>'; 
?>