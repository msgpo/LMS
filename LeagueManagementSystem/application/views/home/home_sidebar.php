<p>Welcome, 
<?php
	echo $this->session->userdata('username');
?>.
</p>
<a href="<?php echo base_url(); ?>index.php/home/editPassword">Edit League Manager Password</a>