 <style type="text/css">
	p1{
		color:red;
    }
</style>

<form action="<?php echo base_url()?>index.php/sportController/create" method="post" accept-charset="utf-8">
<p>Sportname: <input type="text" name="sportname" value=""></p>
<input type="submit" name="" value="Add Sport"></form>
<?php echo '<p1>'.$this->session->userdata('err').'</p1>'; ?> 