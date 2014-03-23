<h1 class="logo">Options</h1>
<a href="<?php echo base_url(); ?>index.php/leagueController/index" >View Active Leagues</a>
<a href="<?php echo base_url(); ?>index.php/leagueController/deactivatedLeagueList" >View Deactivated Leagues</a>
<?php
if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
{
?>
<a href="#" id="create-league">Create New League</a>

<div id="addleague-dialog" title="Create League">
<table>
<tr><td>League Name</td><td><input type="text" id="leaguename" name="leaguename" value="" /></td></tr>
<tr><td>Sport</td>
<td><select id="sportid" name="sport_id">
<?php
if ($sportList)
{
	foreach($sportList->result() as $sport)
	{
		echo '<option value="';
		echo $sport->sport_id;
		echo '">' . ucwords($sport->sportname);
		echo '</option>';
	}
}
?>
</select></td></tr>
<tr><td>Tournament Type</td>
<td><select id="tournamenttype" name="tournamenttype">
	<option value="Unspecified">Unspecified</option>
	<option value="Single Elimination">Single Elimination</option>
	<option value="Double Elimination">Double Elimination</option>
</select></td></tr>
<tr><td>Date </td>
<td><input type="text" id="datepicker" name="registrationdeadline" value=""></td></tr>
</table>
<div id="tooltipCreateLeague">
	<!--<strong>TIP: </strong>Sport names are case insensitive.-->
</div>
<button type="button" class="btn btn-primary" id="submitCreateLeague">Create League</button>
</div>
<?php
}
?>