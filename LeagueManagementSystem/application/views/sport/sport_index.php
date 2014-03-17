<table class="table table-hover">
<tr>
	<th>Sport Name</th>
	<th></th>
</tr>
<?php
// generate HTML table from query results
		foreach ($sports_query->result() as $sport)
		{
			echo '<tr>';
			echo '<td>' . ucwords($sport->sportname) . '</td>';
		//	echo '<td><a class="btn btn-info btn-lg" href="' . base_url() . 'index.php/sportController/edit/' . $sport->sport_id . '">Edit</a>';
			echo '<td><button class="btn btn-info btn-lg" id="updateSport'.$sport->sport_id.'" data-toggle="modal" data-target="#updateSport'.$sport->sport_id.'">Edit</button>';
		//	echo '<a class="btn btn-danger btn-lg" href="' . base_url() . 'index.php/sportController/remove/' . $sport->sport_id . '" onclick="return confirm(\'Remove this sport?\')">Remove</a>';
			echo '<button class="btn btn-danger btn-lg" id="removeSport'.$sport->sport_id.'" data-toggle="modal" data-target="#removeSport'.$sport->sport_id.'">Remove</button>';
			echo '</td>';
			


		?>
<!--</table>-->

<script>
$(document).ready(function()
{
	// Edit/Remove goes here
	// Edit Sport
	$("button#submitUpdate<?php echo $sport->sport_id; ?>").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/sportController/update",
			data:
				{
					sport_id: <?php echo $sport->sport_id; ?>,
					sportname: $("input#sportname<?php echo $sport->sport_id; ?>").val()
				}, 
			success: function(msg){
				if (msg == 1)
				{
					$("#form-content").modal('hide');
					location.reload();
					// alert(msg);
				}
				else
				{
					if(!($("div#tooltipEditSport<?php echo $sport->sport_id; ?>").hasClass("alert alert-danger")))
					{
						$("div#tooltipEditSport<?php echo $sport->sport_id; ?>").removeClass().addClass("alert alert-danger");
					}
				
					$("div#tooltipEditSport<?php echo $sport->sport_id; ?>").html('<strong>WARNING: </strong>' + msg);
				}
			},
			error: function(){
				alert("failure");
			}
		//	return false;
		});
	});
	
	// Remove Sport
	$("button#submitRemove<?php echo $sport->sport_id; ?>").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/sportController/remove",
			data:
				{
					sport_id: <?php echo $sport->sport_id; ?>
				}, 
			success: function(msg){
					$("#form-content").modal('hide');
					location.reload();
			},
			error: function(){
				alert("failure");
			}
		//	return false;
		});
	});
	
});
</script> 

<!-- Modals dependent on IDs go here -->
<!-- Edit Sport -->
<div class="modal fade" id="updateSport<?php echo $sport->sport_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Sport</h4>
      </div>
      <div class="modal-body">
	  <form class="contact">
        <ul class="nav nav-list">
		<li class="nav-header">Sport Name</li>
		<li><input class="form-control" placeholder="Enter a sport name here" value="<?php echo $sport->sportname; ?>" type="text" id="sportname<?php echo $sport->sport_id; ?>" name="sportname"></li>
		</ul>
		<br />
			<div id="tooltipEditSport<?php echo $sport->sport_id; ?>" class="alert alert-info">
				<strong>TIP: </strong>Sport names are case insensitive.
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitUpdate<?php echo $sport->sport_id; ?>">Edit Sport</button>
      </div>
    </div>
  </div>
</div>

<!-- Remove Sport -->
<div class="modal fade" id="removeSport<?php echo $sport->sport_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Remove Sport</h4>
      </div>
      <div class="modal-body">
			<p>Are you sure you want to remove <?php echo ucwords($sport->sportname); ?> from the list of sports? This cannot be undone.</p>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-danger" id="submitRemove<?php echo $sport->sport_id; ?>">Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        
      </div>
    </div>
  </div>
</div>

<?php
	echo '</tr>';
		}
	echo '</table>';
?>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addSport">
  Add New Sport
</button>

<!-- Modal -->
<div class="modal fade" id="addSport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Sport</h4>
      </div>
      <div class="modal-body">
	  <form class="contact">
        <ul class="nav nav-list">
		<li class="nav-header">Sport Name</li>
		<li><input class="form-control" placeholder="Enter a sport name here" value="" type="text" id="sportname" name="sportname"></li>
		</ul>
		<br />
			<div id="tooltip" class="alert alert-info">
				<strong>TIP: </strong>Sport names are case insensitive.
			</div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="submitadd">Add Sport</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function()
{
//Add Sport
	$("button#submitadd").click(function()
	{
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/sportController/create/",
			data: $('form.contact').serialize(),
			success: function(msg){
			if (msg == 1)
			{
				$("div#tooltip").removeClass().addClass("alert alert-success");
				$("div#tooltip").html('<strong>SUCCESS: </strong>Sport added.');
				// $("#form-content").setTimeout(5000).modal('hide');
				// $("#form-content").setTimeout(hideModal(), 5000);
				$("#form-content").modal('hide');
				location.reload();
			}
			else
			{
				// alert(msg);
				if(!($("div#tooltip").hasClass("alert alert-danger")))
				{
					$("div#tooltip").removeClass().addClass("alert alert-danger");
				}
				
				$("div#tooltip").html('<strong>WARNING: </strong>' + msg);
			}
			},
			error: function(){
				alert("failure");
			}
		});
	});
});
</script>

<p><?php echo $links; ?></p>
<p>Page rendered in {elapsed_time} seconds.</p>

