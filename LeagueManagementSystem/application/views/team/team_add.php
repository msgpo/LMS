<style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url()?>index.php/teamController/create" method="post" accept-charset="utf-8">
<p>Team Name: <input type="text" name="teamname" value=""></p>
<input type="hidden" name="league_id" value="<?php echo $leagueID; ?>" />
<p>Coach Last Name: <input type="text" name="coachlastname" value=""></p>
<p>Coach First Name: <input type="text" name="coachfirstname" value=""></p>
<p>Coach Phone Number: <input type="text" name="coachphonenumber" value=""></p>
<p>Description: <input type="text" name="teamdesc" value=""> </p>

<input type="submit" name="" value="Register Team"></form>
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