<?php 
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename = Product Purchase Summary Report.doc");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Product Purchase Summary Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
          <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
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
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Sunny Paper Mills</h2>
          </div>
    <br><br>
          <h3 style="color:green;text-align: center;">Product Purchase Summary</h3>          
          <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
          </div>
                <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
          <br>
      <div style="height:30px;"></div>
              <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 70%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:7%;">S. #</th>
                 <th style="text-align:left;">Product</th>
                 <th style="text-align:center;">Weight (KG)</th>
                 <th style="text-align:center;">Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php     
              $TotatalRate='';
              $TotalWeight = 0;
              $TotalNetAmount = 0;
              $SNo=1;
              
              if(isset($ProductPurchaseDetail)) {
              
              foreach($ProductPurchaseDetail as $Record) 
	      {     
              ?>
              <tr style="font-size:13px;">
               <td style="text-align:center;"><?php echo $SNo; ?></td>
               <td style="text-align:left;"><?php echo $Record['ProductName']?></td>
               <td style="text-align:right;"><?php echo number_format($Record['Weight'],0);?></td>
               <td style="text-align:right;"><?php echo number_format($Record['NetAmount'],2); ?></td>
              </tr>
              <?php $SNo++;
	      $TotalWeight += $Record['Weight'];
	      $TotalNetAmount += $Record['NetAmount'];
	      } } ?>       

              <tr style="font-size:13px;">
               <td>&nbsp;</td>
               <td style="font-weight:700; text-align:right;">Total: &nbsp;</td>
               <td style="font-weight:700; text-align:right;">&nbsp;<?php echo $TotalWeight; ?></td>
               <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalNetAmount,2); ?></td>
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