<?php
/*
echo '<a href="';
				echo base_url();
				$message="";
				echo 'index.php/sportController/addSport">Add Sport</a>';
				*/
?>
<!-- twitter content -->
	<div id="form-content" class="modal hide fade in" style="display: none; ">
	        <div class="modal-header">
	              <a class="close" data-dismiss="modal">×</a>
	              <h3>Add Sport</h3>
	        </div>
		<div>
			<form class="contact">
			<fieldset>
		         <div class="modal-body">
		        	 <ul class="nav nav-list">
						<li class="nav-header">Sport Name</li>
						<li><input class="input-xlarge" placeholder="Enter a sport name here" value="" type="text" name="sportname"></li>
					</ul> 
					<div id="tooltip" class="alert alert-info">  
						<!--<a class="close" data-dismiss="alert">×</a>-->  
							<strong>TIP: </strong>Sport names are case insensitive.
					</div> 
		        </div>
			</fieldset>
			</form>
		</div>
	     <div class="modal-footer">
	         <button class="btn btn-success" id="submit">Add New Sport</button>
	         <a href="#" class="btn" data-dismiss="modal">Cancel</a>
  		</div>
	</div>

<div id="thanks"><p><a data-toggle="modal" href="#form-content" class="btn btn-primary">Add Sport</a></p></div>

