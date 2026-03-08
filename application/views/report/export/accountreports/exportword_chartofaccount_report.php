<?php 
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename = Chart of Account Report.doc");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chart of Account Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
   <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">               
          <center>
              <div class="box-header">
            <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills
            </h2>
            <h3 style="color:green;" class="box-title">Chart of Account Report</h3>
            <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
            </div>
          </center>
            <table class="table table-bordered">
              <thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align: center;">Number</th>
          				<th>Description (Control Name)</th>
          				<th>Account Type</th>
          				<th>Finincial Statement (CoA Title)</th>
          		 </tr>
	      </thead>
	      <tbody>
		<?php

		if(isset($GetAllChartOfAccounts)) {
		foreach($GetAllChartOfAccounts as $ChartOfAccountsReport)
		{
		?>
	    <tr style="font-size:12px;">
    		<td style="text-align: center;"><?php echo $ChartOfAccountsReport['ChartOfAccountsCode']; ?></td>
		 	<td style="text-align:left;"><?php echo $ChartOfAccountsReport['ControlName']; ?></td>
		 	<td style="text-align:left;"><?php echo $ChartOfAccountsReport['CategoryName']; ?></td>
		 	<td style="text-align:left;"><?php echo $ChartOfAccountsReport['ChartOfAccountsTitle']; ?></td>
        </tr>
	        <?php
		} } ?>
              </tbody>
              </table>
         </div>   
       </div>
    </div>
  </body>
</html>