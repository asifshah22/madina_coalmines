<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Customer Outstanding Report.xls");
?>
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
	      <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Hilife Electronics</h2>
              <h3 style="color:green;" class="box-title">Customer Outstanding Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
<div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
            </div>
          </center>
          <br>
            <div style="height:30px;" class="pull-right"></div>
                  <center>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 70%" id="table-basic">
              <thead>
                <tr style="background:#205081; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:7%;">S. #</th>
                 <th style="text-align:center;">Customer Name</th>
                 <th style="text-align:center;">Area</th>
                 <th style="text-align:center;">Contact No</th>
                 <th style="text-align:center;">Opening Balance</th>
                 <th style="text-align:center;">Sales Amount</th>
                 <th style="text-align:center;">Payment Received</th>
                 <th style="text-align:center;">Due Amount</th>
                 
                </tr>
              </thead>
              <tbody>
              <?php     
              $Amount = 0;
              $Sale = 0;
              $Receipt = 0;
              $DueAmount = 0;
              $SNo=1;
			  
			  $dBalance = "";
              
              if(isset($CustomerOutstandingReport)) {
              $i = 0;
              foreach($CustomerOutstandingReport as $Record) 
	      {
              $Sale = $Record['Credit'];
              $Receipt = $Record['Debit'];
              $Amount = ($Receipt - $Sale);
              if($Amount == 0 || $Amount == '0.00'){
                continue;
              }
			
			$ChartOfAccountId = $Record['ChartOfAccountId'];
			
			foreach($OpenningBalance as $Balance)
			{
				if($Balance['ChartOfAccountId'] == $ChartOfAccountId)
				{  
					$dBalance = $Balance['Balance']; 
				}
//				$dBalance = $Balance['Balance']; 
			}

              ?>
              <tr style="font-size:13px;">
                <td style="text-align:center;"><?php echo $SNo; ?></td>
                <td style="text-align:left;"><?php echo $Record['ChartOfAccountTitle']?></td>
                <td style="text-align:left;"><?php echo $Record['Address'] == "" ? '---' : $Record['Address']?></td>
                <td style="text-align:left;"><?php echo $Record['CellNo'] == "" ? '---' : $Record['CellNo']?></td>
                <td style="text-align:center;"><?php echo $dBalance; // ($OpenningBalance[$i]['Debit'] - $OpenningBalance[$i]['Credit']) ?></td>
                <td style="text-align:right;"><?php echo number_format($Receipt,2); ?></td>
                <td style="text-align:right;"><?php echo number_format($Sale,2); ?></td>
                <td style="text-align:right;"><?php echo number_format($Amount,2); ?></td>
              </tr>
              <?php
              $i++;
              $SNo++;
              $DueAmount += $Amount;

	      }
        } ?>
        <tr style="font-size:13px;">
         <td style="font-weight:700; text-align:right;" colspan="7">&nbsp; Grand Total:</td>
          <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($DueAmount,2); ?></td>
        </tr> 
              </tbody>
              </table>
            </div>
          </center>
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