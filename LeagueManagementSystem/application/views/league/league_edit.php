<style type="text/css">
	p1{
		color:red;
    }
</style>
<form action="<?php echo base_url()?>index.php/leagueController/update" method="post" accept-charset="utf-8">
 <input type="hidden" name="league_id" value="<?php echo $row[0]->league_id; ?>">
<p>League Name: <input type="text" name="leaguename" value="<?php echo $row[0]->leaguename; ?>"></p>
<p>Sport:
<select name="sport_id">
<?php
	foreach($sportList->result() as $sport)
	{
		if($row[0]->sport_id==$sport->sport_id)
			echo '<option value="'.$sport->sport_id.'"selected="selected">'.ucwords($sport->sportname).'</option>';
		else 
			echo '<option value="'.$sport->sport_id.'">'.ucwords($sport->sportname).'</option>';
	}?>
</select></p>
<p>Tournament Type:
<select name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<?php
		if($row[0]->tournamenttype=="single elimination")
		{
			echo '<option value="single elimination" selected="selected">Single Elimination</option>';
			echo '<option value="double elimination">Double Elimination</option>';
		}
		else
		{
			echo '<option value="double elimination" selected="selected">Double Elimination</option>';
			echo '<option value="single elimination">Single Elimination</option>';
		}
	?>
</select></p>
<p>Date (YYYY-MM-DD): <input type="text" name="registrationdeadline" value="<?php echo $row[0]->registrationdeadline; ?>"> </p>
<input type="submit" name="" value="Edit League"></form>
<?php
	$errors=$this->session->userdata('err');
	if(is_array($errors))
	{
		foreach($errors as $error)
			echo '<p1>'.$error.'<br></p1>';
	}
?> 