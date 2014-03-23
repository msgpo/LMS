<?php
	$id=$league_id;
?>
<a href="<?php echo base_url(); ?>index.php/leagueController/viewLeagueInfo/<?php echo $id; ?>">Back to League Information</a>
<?php
if ($this->credentialModel->checkIfLoggedIn($this->session->userdata('username')))
{
?>
<a href="<?php echo base_url();?>index.php/tournamentController/resetTournament/<?php echo $id ?>" onclick="return confirm('Reset this tournament?')">Reset Tournament</a>
<?php
}
?>