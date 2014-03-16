<style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url()?>index.php/teamController/update" method="post" accept-charset="utf-8">
<p>Team Name: <input type="text" name="teamname" value="<?php echo $row[0]->teamname; ?>"></p>
<input type="hidden" name="league_id" value="<?php echo $league_id; ?>" />
<input type="hidden" name="team_id" value="<?php echo $row[0]->team_id; ?>" />
<p>Coach Last Name: <input type="text" name="coachlastname" value="<?php echo $row[0]->coachlastname; ?>"></p>
<p>Coach First Name: <input type="text" name="coachfirstname" value="<?php echo $row[0]->coachfirstname; ?>"></p>
<p>Coach Phone Number: <input type="text" name="coachphonenumber" value="<?php echo $row[0]->coachphonenumber; ?>"></p>
<p>Description(Optional): <input type="text" name="teamdesc" value="<?php echo $row[0]->teamdesc; ?>"> </p>

<button type="submit" class= "btn btn-primary">Update Team Information</button></form>
<?php
	$errors=$this->session->userdata('err');
	if(is_array($errors))
	{
		foreach($errors as $error)
		{
			echo '<p1>'.$error.'<br></p1>';
		}
	}
?> 