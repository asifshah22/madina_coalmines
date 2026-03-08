<html>
<head>
<title>Inventory Management System - Login Area</title>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>lib/css/login/style.css">
<meta name="Description" content="SPM Inventory Management System"/>
<meta name="Keywords" content="SPM Inventory Management System"/>
<meta property="og:locale" content="en_US" />
</head>
<body>
     <?php echo form_open('Login/VerifyUser',array('class'=>'login-form')); ?>
	<div class="main">
	     <center> 
		 <div class="box" style="opacity:1.8;">
		     <div id="info1">
			<!-- <img width="350" height="80" src="<?php echo base_url(); ?>lib/css/login/logo.jpeg" /> -->
		     </div>
		     <div style="height:15px;">
		     	<h2 style="color: brown; font-weight: 600"> <?php echo $GetSettingInformation[0]['CompanyName']; ?></h2>
		     </div>
		      <br><br>
		     <?php echo isset($msg) ? $msg : '';?>
		      <div id="info1">User Login</div><br>
			  <div id="info3">Email:</div>
			  <input type="text" name="UserName" style="width:350px; height:30px;" autocomplete="off"/><br><br>
			  <div id="info3">Password: </div>
			  <input type="password" name="Password" style="width:350px; height:30px;" autocomplete="off"/><br><br>
			  <input class="button2" type="submit" value="Login" />
		     </div>
	     </center>
	</div>
      <?php echo form_close(); ?>
</body>
</html>