<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Outstanding Report</title>
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
	      <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills</h2>
              <h3 style="color:green;" class="box-title">Customer Outstanding Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
	      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:left;">Period of: <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' To '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></div>
            </div>
          </center>
            <a class="btn btn-info" href="<?php echo base_url(); ?>AccountReports/ExportCustomerOutstanding"> Export to Excel </a>
            <div style="height:30px;" class="pull-right"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:4%;">S. #</th>
                 <th style="text-align:center;">Customer Name</th>
                 <th style="text-align:center;">Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php     
	      $TotalDebit = 0;
              $TotalCredit = 0;
              $Amount = 0;
              $TotalAmount = 0;
              $SNo=1;
              
              if(isset($CustomerOutstandingReport)) {
              
              foreach($CustomerOutstandingReport as $Record) 
	      {     
              ?>
              <tr style="font-size:13px;">
               <td style="text-align:center;"><?php echo $SNo; ?></td>
               <td style="text-align:left;"><?php echo $Record['ChartOfAccountsTitle']?></td>
               <td style="text-align:right;"><?php echo $Amount = ($Record['Debit'] - $Record['Credit']); ?></td>
              </tr>
              <?php $SNo++;
              $TotalAmount += $Amount;
	      } } ?>       
              <tr style="font-size:13px;">
	       <td style="font-weight:700; text-align:right;" colspan="2">&nbsp; Grand Total:</td>
               <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($TotalAmount,0); ?></td>
              </tr> 
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