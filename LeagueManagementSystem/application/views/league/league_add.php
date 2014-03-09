<style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url()?>index.php/leagueController/create" method="post" accept-charset="utf-8">
<p>League Name: <input type="text" name="leaguename" value=""></p>
<p>Sport:
<select name="sport_id">
<?php
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
?>
</select></p>
<p>Tournament Type:
<select name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
</select></p>
<p>Date (YYYY-MM-DD): <input type="text" name="registrationdeadline" value=""> </p>

<input type="submit" name="" value="Create League"></form>
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