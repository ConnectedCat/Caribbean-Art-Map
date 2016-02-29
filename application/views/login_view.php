<?php
$this->load->view('header_view');
?>
<body class="admin">
	
	<div id="admin-login">
		<div class="small-logo" id="login-logo"><img src="<?php echo base_url();?>/img/SmallLogo.png"/></div>
		<?php
		if($error) {
			echo '<p class="error">'.$error.'</p>';
		}
		echo form_open('login/validate');
		echo form_input(array('name' => 'email', 'placeholder' => 'Login or Email'));
		echo form_password(array('name' => 'password', 'placeholder' => 'Password'));
		echo form_checkbox(array('name' => 'remember', 'value' => 'yes'));
		echo form_label('Remember Me', 'remember');
		echo form_submit('submit', 'Log In');
		echo form_close();
		?>
	
		<?php
		echo validation_errors('<p class="errors"');
		?>
		
		<?php echo anchor('login/forgot', 'Forgot Password?', 'class="forgot"'); ?>
	</div>
</body>
<?php
$this->load->view('footer_view');
?>