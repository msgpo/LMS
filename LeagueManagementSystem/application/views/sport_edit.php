 <style type="text/css">
	p1{
		color:red;
    }
</style>
<form action=<?php echo base_url()?>index.php/sportController/update method="post" accept-charset="utf-8">
<input type="hidden" name="sport_id" value="<?php echo  $row[0]->sport_id;?>">
<p>Sportname: <input type="text" name="sportname" value="<?php echo ucwords($row[0]->sportname); ?>"></p><input type="submit" name="" value="Edit Sport"></form>
<?php 

echo '<p1>'.validation_errors().'</p1>'; 
?>
