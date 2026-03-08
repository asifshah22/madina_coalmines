<?php 

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment; filename = Customer Sale Summary Report.doc");

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Customer Sale Summary Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
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
      <h3 style="color:green;text-align: center;">Customer Sale Summary</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
       <div style="height:30px;"></div>
              <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:4%;">S. #</th>
                 <th style="text-align:center;">Customer</th>
                 <th style="text-align:center;">Weight</th>
		 <th style="text-align:center;">Quantity</th>
		 <th style="text-align:center;">Amount</th>
               <th style="text-align:center;">FED Amount</th>
		 <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
              <?php     
              $TotatalRate='';
	      $TotalWeight = 0;
              $TotalQuantity = 0;
	      $TotalAmount = 0;
	      $TotalFEDAmount = 0;
              $TotalNetAmount = 0;
              $SNo=1;
              
              if(isset($CustomerSaleSummary)) {
              
              foreach($CustomerSaleSummary as $Record) 
	      {     
              ?>
              <tr style="font-size:13px;">
               <td style="text-align:center;"><?php echo $SNo; ?></td>
               <td style="text-align:left;"><?php echo $Record['CustomerName']?></td>
               <td style="text-align:right;"><?php echo number_format($Record['Weight'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['Quantity'],0); ?></td>
               <td style="text-align:right;"><?php echo number_format($Record['Amount'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['FEDAmount'],0); ?></td>
	       <td style="text-align:right;"><?php echo number_format($Record['NetAmount'],0); ?></td>
              </tr>
              <?php $SNo++;
	      $TotalWeight += $Record['Weight'];
	      $TotalQuantity += $Record['Quantity'];
	      $TotalAmount += $Record['Amount'];
	      $TotalFEDAmount += $Record['FEDAmount'];
	      $TotalNetAmount += $Record['NetAmount'];
	      } } ?>       
              <tr style="font-size:13px;">
	       <td style="font-weight:700; text-align:right;" colspan="2">&nbsp; Grand Total:</td>
               <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($TotalWeight,0); ?></td>
	       <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($TotalQuantity,0); ?></td>
               <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalAmount,0); ?></td>
	       <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalFEDAmount,0); ?></td>
	       <td style="font-weight:700; text-align:right;"><?php echo number_format($TotalNetAmount,0); ?></td>
              </tr> 
              </tbody>
              </table>
            </div>
         </div>   
       </div>
    </div>
  </body>
</html>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Email</h4>
        <p id="msg" style="text-align: center;">
          <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="display: none;" />
        </p>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>From:</b></label>
          <div class="col-sm-8">
              <span class=""><?php echo $this->session->userdata('EmployeeName') . " ( " . $this->session->userdata('UserName') . " ) " ; ?></span>
          </div>
        </div> <br><br>

        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label"><b>Receipent:</b></label>
          <div class="col-sm-8">
            <select name="EmployeeId[]" id="EmployeeId" class="form-control js-example-basic-multiple" multiple="multiple" style="width: 100%">
              <option>Select Receipant</option>
                     <?php foreach ($AllEmployees as $row) { ?>
                     <option value="<?php  echo $row['EmailAddress']; ?>"><?php echo $row['EmailAddress']; ?></option>
                     <?php } ?>
              </select>
          </div>
        </div> <br /><br />
        <input type="hidden" name="StartDate" id="StartDate" value="<?php echo $this->input->get('StartDate'); ?>">
        <input type="hidden" name="EndDate" id="EndDate" value="<?php echo $this->input->get('EndDate'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Customer Sale Summary Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
          </div>
        </div> <br /><br />

                <div class="form-group">
                <label for="Comments" class="col-sm-3 control-label"><b>Comments:</b></label>
                <div class="col-sm-8">
                <textarea name="Comments" id="Comments" class="form-control" rows="4" cols="45"></textarea>
                </div>
              </div> <br> <br>

      </div><br /><br><br>
      <div class="modal-footer">
        <button type="button" id="Submit" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
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
    $("#Submit").on('click', function(){
      var EmployeeId = $("#EmployeeId").val();
      var Subject = $("#Subject").val();
      var Comments = $("#Comments").val();
      var Message = $("#Message").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendCustomerSaleSummaryReport',
        data: {EmployeeId:EmployeeId,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate},
        type: 'post',
        dataType: 'html',

        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
      success:function(data){
        $("#loader").css('display', 'none');
        $('input').val('');
        $('textarea').val('');
        $("#msg").html(data)
        }
      })
    })
  })
</script>

<script>
  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
</script>