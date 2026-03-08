<?php 
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename = Vendor Outstanding Report.doc");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vendor Outstanding Report</title>
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

<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/tableExport.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/jquery.base64.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lib/js/tableExport/jspdf/libs/base64.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
         <div class="col-md-12 col-xs-12">
            <h2 style="color:black; font-family:Georgia; font-weight:600;text-align: center; margin-top: 10px;" class="box-title">Sunny Paper Mills</h2>
          </div>
    <br><br>
      <h3 style="color:green;text-align: center;">Vendor Outstanding</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Upto: <?php echo ' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>

      <div style="height:30px;"></div>
      <center>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="myTable">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:4%;">S. #</th>
                 <th style="text-align:center;">Vendor Name</th>
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

<script>
    $(function(){
      $("#pdf").click(function(){
        $("#myTable").tableExport({
          type: 'pdf',
          escape: 'false',
        })
      })
    })
</script>