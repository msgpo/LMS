<form class="form-signin" action="<?php echo base_url()?>index.php/login/logging_in" method="post">
<h2 class="form-signin-heading">Please sign in</h2>
<input class="input-block-level" placeholder="Username" autocomplete="off" type="text" style="width:200px;height:30px" name="username" /><br>
<input class="input-block-level" placeholder="Password" type="password" style="width:200px;height:30px" name="password" /><br><br>
<button class="btn btn-large btn-primary" type="submit">Sign in</button></form>
<p><?php echo $message; ?> </p>
