<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Purchase Detail Report</title>
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
      <h3 style="color:green;text-align: center;">General Purchase Details</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></span></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url() ?>Export/ExportExcelPurchaseDetailReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Excel</a></li>
          <li><a href="<?php echo base_url()?>Export/ExportWordPurchaseDetailReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Word</a></li></ul>
          </span> &nbsp; </span>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>

	    <div style="height:30px;"></div>
              <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 100%" id="table-basic">
		<thead>
                <tr style="background:#3c8dbc; font-size:13px; color:#FFFFFF;">
                 <th style="text-align:center; width:4%;">S.#</th>
                 <th style="text-align:center; width:4%;">Vehicle.#</th>
                 <th style="text-align:center;">P.#</th>
                 <th style="text-align:center;">Date</th>
		 <th style="text-align:center;">Vendor</th>
		 <th style="text-align:center;">Product</th>
                 <th style="text-align:center;">Weight</th>
		 <th style="text-align:center;">Deduction Raw Material</th>
                 <th style="text-align:center;">Rate</th>
                 <th style="text-align:center;">Amount</th>
                 <th style="text-align:center;">GST %</th>
                 <th style="text-align:center;">GST Amount</th>
                 <th style="text-align:center;">FED %</th>
                 <th style="text-align:center;">FED Amount</th>
                 <th style="text-align:center;">Net Amount</th>
                </tr>
		</thead>
              <tbody>
              <?php
	      $TotalWeight = 0;
	      $TotalDeductionRawMaterial = 0;
	      $TotalAmount = 0;
	      $TotalFEDAmount = 0;
	      $TotalGSTAmount = 0;
	      $TotalNetAmount = 0;
	      
	      $GrandTotalWeight = 0;
	      $GrandDeductionRawMaterial = 0;
	      $GrandAmount = 0;
	      $GrandGSTAmount = 0;
	      $GrandFEDAmount = 0;
	      $GrandNetAmount = 0;
		
	      $SNo=1;
              if(isset($PurchaseDetail)) {
              foreach($PurchaseDetail as $row) {
		  
	      // If product is missing then row will be highlighted with color
	      if($row['ProductName'] == '')
	      { $background = '#f8efc0'; }
	      else
	      { $background = '#FFFFFF'; }
              ?>
              <tr style="font-size:12px; background:<?php echo $background; ?>;">
                 <td style="text-align:center;"><?php echo $SNo;?></td>
                 <td style="text-align:center;"><?php echo $row['TransportBuiltyNo']; ?></td>
                 <td style="text-align:center;"><?php echo $row['PurchaseNo']; ?></td>
                 <td style="text-align:left;"><?php echo date('M d, Y', strtotime($row['PurchaseDate'])); ?></td>
                 <td style="text-align:left;"><?php echo $row['VendorName']; ?></td>
                 <td style="text-align:left;"><?php echo $row['ProductName']; ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['Weight'],2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['DeductionRawMaterial'],2); ?></td>
                 <td style="text-align:right;"><?php echo $row['Rate']; ?></td>
                 <td style="text-align:right;"><?php echo number_format($row['Amount'],2); ?></td>
                 <td style="text-align:right;"><?php echo $row['GST']; ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['GSTAmount'],2); ?></td>
		 <td style="text-align:right;"><?php echo $row['FED']; ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['FEDAmount'],2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($row['NetAmount'],2); ?></td>
                </tr>
                <?php
                $TotalWeight += $row['Weight'];
                $TotalDeductionRawMaterial += $row['DeductionRawMaterial'];;
                $TotalAmount += $row['Amount'];
                $TotalGSTAmount += $row['GSTAmount'];
		$TotalFEDAmount += $row['FEDAmount'];
		$TotalNetAmount += $row['NetAmount'];
                $SNo++; }                   
                }
		?>
		<?php	
		$GrandTotalWeight += $TotalWeight;
		$GrandDeductionRawMaterial += $TotalDeductionRawMaterial;
		$GrandAmount += $TotalAmount;
		$GrandGSTAmount += $TotalGSTAmount;
		$GrandFEDAmount += $TotalFEDAmount;
		$GrandNetAmount += $TotalNetAmount;
	      
		$TotalWeight = 0;
		$TotalDeductionRawMaterial = 0;
		$TotalAmount = 0;
		$TotalGSTAmount = 0;
		$TotalFEDAmount = 0;
		$TotalNetAmount = 0;
                ?>
                <tr style="font-size:12px;  font-weight:600;">
		 <td colspan="14" style="text-align:right;"></td>
                </tr>
		<tr style="font-size:12px;  font-weight:600;">
		 <td colspan="5" style="text-align:right;">Grand Total:</td>
                 <td style="text-align:right;"><?php echo number_format($GrandTotalWeight,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($GrandDeductionRawMaterial,2); ?></td>
                 <td style="text-align:right;"></td>
                 <td style="text-align:right;"><?php echo number_format($GrandAmount,2); ?></td>
                 <td style="text-align:right;"></td>
		 <td style="text-align:right;"><?php echo number_format($GrandGSTAmount,2); ?></td>
		 <td style="text-align:right;"></td>
		 <td style="text-align:right;"><?php echo number_format($GrandFEDAmount,2); ?></td>
		 <td style="text-align:right;"><?php echo number_format($GrandNetAmount,2); ?></td>
                </tr>
              </tbody>
              </table>
              </div>
         </div>   
       </div>
    </div>
  </body>
</html>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Mail</h4>
        <p id="msg" style="text-align: center;">
          <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="display: none;" />
        </p>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label">From:</label>
          <div class="col-sm-8">
              <span class=""><?php echo $this->session->userdata('EmployeeName') . " ( " . $this->session->userdata('UserName') . " ) " ; ?></span>
          </div>
        </div> <br><br>

        <div class="form-group">
          <label for="Password" class="col-sm-3 control-label">Receipent:</label>
          <div class="col-sm-8">
            <select name="EmployeeId[]" id="EmployeeId" class="form-control js-example-basic-multiple" multiple="multiple" style="width: 100%">
              <option>Select Receipant</option>
                     <?php foreach ($AllEmployees as $row) { ?>
                     <option value="<?php  echo $row['EmailAddress']; ?>"><?php echo $row['EmailAddress']; ?></option>
                     <?php } ?>
              </select><span>If not in the list click here. &nbsp; &nbsp;<i class="fa fa-plus" style="cursor: pointer;" id="Show"></i></span>
          </div>
        </div> <br /><br /> <br> <br><br>
        <div class="form-group">
          <label for="OtherEmployee" class="col-sm-3 control-label"><b></b></label>
          <div class="col-sm-8">
                <input type="email" name="OtherEmployee" id="OtherEmployee" class="form-control" required="required" placeholder="Enter new email here" style="display: none;" >
          </div>
        </div> <br /><br />
        <input type="hidden" name="StartDate" id="StartDate" value="<?php echo $this->input->get('StartDate'); ?>">
        <input type="hidden" name="EndDate" id="EndDate" value="<?php echo $this->input->get('EndDate'); ?>">

<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label">Subject:</label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Purchase Detail Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
          </div>
        </div> <br /><br /><br>

        <div class="form-group">
                <label for="Comments" class="col-sm-3 control-label">Comments:</label>
                <div class="col-sm-8">
                <textarea name="Comments" id="Comments" class="form-control" rows="4" cols="50"></textarea>
                </div>
              </div> <br><br><br>

      </div><br />
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

  $("#Show").click(function(){
    $("#OtherEmployee").toggle('2000');
  })


});
</script>
<script>
  $(function(){

    $("#Submit").on('click', function(){
      var EmployeeId = $("#EmployeeId").val();
      var OtherEmployee = $("#OtherEmployee").val();
      var Subject = $("#Subject").val();
      var Comments = $("#Comments").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendPurchaseDetailReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,StartDate:StartDate,EndDate:EndDate},
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
        },
        error:function(){
          $("#msg").html('email can not be sent');
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