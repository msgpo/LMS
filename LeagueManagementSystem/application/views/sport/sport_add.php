 <style type="text/css">
	p1{
		color:red;
    }
</style>

<form action="<?php echo base_url()?>index.php/sportController/create" method="post" accept-charset="utf-8">
<p>Sportname: <input type="text" name="sportname" value="" data-validation-required-message="<?php echo $this->session->userdata('err'); ?>" required /></p>
<!--<input type="submit" name="" value="Add Sport">-->
<button type="submit" class="btn btn-primary">Add Sport</button>
</form>
<?php echo '<p1 class="help-block">'.$this->session->userdata('err').'</p1>'; ?> 