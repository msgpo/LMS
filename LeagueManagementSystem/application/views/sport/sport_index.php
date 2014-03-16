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
		echo '<td><a class="btn btn-info btn-lg" id="editSport" sname="'. $sport->sport_id . '" href="#">Edit</a>';
		//	echo ' | ';
			echo '<a class="btn btn-danger btn-lg" href="' . base_url() . 'index.php/sportController/remove/' . $sport->sport_id . '" onclick="return confirm(\'Remove this sport?\')">Remove</a>';			
			echo '</td>';
			echo '</tr>';
		}

		?>
</table>

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
	function hideModal()
	{
		$("#form-content").modal('hide');
		location.reload();
	}

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
				$("#form-content").setTimeout(hideModal(), 5000);
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
	
	// Edit/Remove goes here

	$("a#editSport").click(function()
	{
		alert($("a#editSport").attr("sname"));
	
		$.ajax(
		{
			type: "POST",
			url: "<?php echo base_url(); ?>index.php/sportController/getId/",
			data: $("a#editSport").attr("sname"),
			success: function(msg){
				//alert(msg);
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

