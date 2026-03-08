<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Trial Balance Report</title>
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
      <h3 style="color:green;text-align: center;">Trial Balance</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></span></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url() ?>Export/ExportExcelTrialBalanceReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Excel</a></li>
          <li><a href="<?php echo base_url()?>Export/ExportWordTrialBalanceReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Word</a></li></ul>
          </span> &nbsp; </span>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>

	    <div style="height:30px;"></div>
	    <table border="0" cellspacing="0" cellpadding="3" style="width:100%; text-align:center; padding-left: 1px;">
             <thead>
	      <tr>
               <th style="border-bottom:0px solid; width:10%; padding:15px; border-bottom:1px solid;"></th>
                <th style="border-bottom:0px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold;text-align:center; border-bottom:1px solid;">Debit</th>
                <th style="border-bottom:0px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; text-align:center; border-bottom:1px solid;">Credit</th>
               </tr>
	     </thead>
	    </table>
            <?php
            $CompanyName = '';
            $dTotal_Debit = 0;
            $dTotal_Credit = 0;
            $dGrandTotal_Debit = 0;
            $dGrandTotal_Credit = 0;
            $dDebit = 0; 
            $dCredit = 0;
            ?>
            <table border="0" cellspacing="0" cellpadding="5" style="width:100%; text-align: center; padding-left:1px;">
             <?php 	    
	     if(isset($COACategories)) {
             foreach($COACategories as $COACategoriesRecord) {
	     ?> 
	     <thead>
              <tr>
               <td style="font-family:Tahoma, Arial; font-size:18px; text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;" colspan="3"><?php echo $COACategoriesRecord['CategoryName']; //$ChartOfAccountsTitle; ?></td>
	      </tr>                
              </thead>
                <?php 	    
	        if(isset($GetAllControlCodes)) {
                 foreach($GetAllControlCodes as $GetAllControlCodesRecord) {
	         if($GetAllControlCodesRecord['ChartOfAccountsCategoryId'] == $COACategoriesRecord['ChartOfAccountsCategoryId'] ) {
	        ?>
	        <tr style="font-size:16px;">
                 <td style="font-family:Tahoma, Arial; height:5px; padding-left:20px; text-align:left; height:20px; padding-left:1  5px;" colspan="7"><?php echo $GetAllControlCodesRecord['ControlName']; ?></td>
	        </tr>
                <?php
		}
		if(isset($GetAllChartOfAccounts)) {
		foreach($GetAllChartOfAccounts as $GetAllChartOfAccountsRecord) {

		$ChartOfAccountsCategoryId = $GetAllChartOfAccountsRecord['ChartOfAccountsCategoryId'];
		$ChartOfAccountsControlId = $GetAllChartOfAccountsRecord['ChartOfAccountsControlId'];
		$ChartOfAccountsId = $GetAllChartOfAccountsRecord['ChartOfAccountsId'];
		$ChartOfAccountsTitle = $GetAllChartOfAccountsRecord['ChartOfAccountsTitle'];
		$ChartOfAccountsCode = $GetAllChartOfAccountsRecord['ChartOfAccountsCode'];
		$DebitIncrease = $GetAllChartOfAccountsRecord['DebitIncrease'];
	        $dDebit = $GetAllChartOfAccountsRecord['Debit'];
                $dCredit = $GetAllChartOfAccountsRecord['Credit'];

		if($ChartOfAccountsControlId == $GetAllControlCodesRecord['ChartOfAccountsControlId'] && $ChartOfAccountsCategoryId == $COACategoriesRecord['ChartOfAccountsCategoryId'])
		{
		
		$dTotal_Debit += $dDebit;
                $dTotal_Credit += $dCredit;    
		?>
		<tr style="font-size:12px;">
                <td style="width:10%; font-family:Tahoma, Arial; text-align:left;  height:25px; padding-left:25px;"><?php echo $ChartOfAccountsCode. ' - '.$ChartOfAccountsTitle; ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php echo number_format($dTotal_Debit,2); ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php echo number_format($dTotal_Credit,2); ?></td>
                </tr>
		<?php
		   }
		 $dGrandTotal_Debit += $dTotal_Debit;
		 $dGrandTotal_Credit += $dTotal_Credit;	      
		 $dTotal_Debit = 0;
		 $dTotal_Credit = 0;
		   }
		}
		} } } }  // Category code for loop ends ?> 
               <tr style="font-size:13px;">
                <td style=" font-weight:700; width:10%; text-align: right;"></td>
                <td style="font-weight: 700; width:10%; text-align: center; border-bottom:4px double; border-top:1px solid; "><?php echo number_format($dGrandTotal_Debit,2); ?></td>
                <td style="font-weight: 700; width:10%; text-align: center; border-bottom:4px double; border-top:1px solid; "><?php echo number_format($dGrandTotal_Credit,2); ?></td>
              </tr>
              </tbody>
              <tr>
                  <td colspan="3" style="height:50px;">&nbsp;</td>
               </tr>
	       
            </table>            
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
              </select><span>If not in the list click here. &nbsp; &nbsp;<i class="fa fa-plus" style="cursor: pointer;" id="Show"></i></span>
          </div>
        </div> <br /><br />
        <div class="form-group">
          <label for="OtherEmployee" class="col-sm-3 control-label"><b></b></label>
          <div class="col-sm-8">
                <input type="email" name="OtherEmployee" id="OtherEmployee" class="form-control" required="required" placeholder="Enter new email here" style="display: none;" >
          </div>
        </div> <br /><br />
        <input type="hidden" name="StartDate" id="StartDate" value="<?php echo $this->input->get('StartDate'); ?>">
        <input type="hidden" name="EndDate" id="EndDate" value="<?php echo $this->input->get('EndDate'); ?>">
        <input type="hidden" name="CompanyId" id="CompanyId" value="<?php echo $this->input->get('CompanyId'); ?>">
        <input type="hidden" name="CId" id="CId" value="<?php echo $this->input->get('CId'); ?>">
        <input type="hidden" name="CCId" id="CCId" value="<?php echo $this->input->get('CCId'); ?>">
        <input type="hidden" name="COAId" id="COAId" value="<?php echo $this->input->get('COAId'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Trial Balance Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
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
      var Message = $("#Message").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();
      var CompanyId = $("#CompanyId").val();
      var CId = $("#CId").val();
      var CCId = $("#CCId").val();
      var COAId = $("#COAId").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendTrialBalanceReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate,CompanyId:CompanyId,CId:CId,CCId:CCId,COAId:COAId},
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
        $("#msg").html('Email can not be sent');
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
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {

  $(".table-basic").freezeTable();

  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

});
</script>