<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">               
          <center>
            <div class="box-header">
              <h3 style="color:#000000;" class="box-title">Customer Report</h3>
            </div>
          </center>
             <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th>S.#</th>
                 <th>Customer Name</th>
                 <th>Contact Name</th>
                 <th>Address</th>
                 <th>Email</th>
                 <th>Cell No</th>
                 <th>Phone No</th>
                </tr>
              </thead>
              <tbody>
              <?php
			  $SNo=1; 
              if(isset($CustomerReport)) {
              
                foreach($CustomerReport as $row) {
			  ?>
                <tr style="font-size:13px;">
                 <td><?php echo $SNo; ?></td>
                 <td><?php echo $row['CustomerName']?></td>
                 <td><?php echo $row['ContactName']?></td>
                 <td><?php echo $row['Address']?></td>
                 <td><?php echo $row['Email']?></td>
                 <td><?php echo $row['CellNo']?></td>
                 <td><?php echo $row['PhoneNo']?></td>
                </tr>
              <?php $SNo++; } }?>  
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

});
</script>