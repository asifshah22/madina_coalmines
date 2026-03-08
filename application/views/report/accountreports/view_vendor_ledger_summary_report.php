<style type="text/css">
  body{
    font-family: Calibri;
  }
  tr{
    border-left: 0px;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 1px solid;
  }
</style>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
    $(function(){
      $('#functionName').text( $('#functionName').text().replace(/([A-Z])/g, " ") );
    })
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<style type="text/css">

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <div class="col-xs-2 col-sm-2">
              <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;" class="box-title text-center"><?php echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div>
    <br><br>
      <h3 style="color:green;text-align: center;" id="functionName">
        <?php $FunctionName = $this->uri->segment(2);
//          $FunctionName = 'CodexWorldWebsite';
          $WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
          echo $WithSpace;
          ?>
        </h3>      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>

<?php

            $SNo=1;
            $CompanyName = '';
            $dTotal_Debit = 0;
            $dTotal_Credit = 0;
            $dGrandTotal_Debit = 0;
            $dGrandTotal_Credit = 0;
            $GrandBalance = 0;
            
            $dDebit = 0; 
            $dCredit = 0;
            $dTransBalance = 0;
            $dBalance = 0;
            $dClosingBalance = 0;

            if(isset($LedgerReport)) {
            foreach($LedgerReport as $LedgerReportRecord) {
            
//          $AccountGroupId = $LedgerReportRecord['AccountGroupId'];
            $ChartOfAccountId = $LedgerReportRecord['ChartOfAccountId'];
            $ChartOfAccountTitle = $LedgerReportRecord['ChartOfAccountTitle'];
            $DebitIncrease = $LedgerReportRecord['DebitIncrease'];
	    $CreditIncrease = $LedgerReportRecord['CreditIncrease'];
	    
	    if(isset($OpenningBalance))
	    {
		foreach($OpenningBalance as $OpenningBalanceRecord)
		{
		    if($OpenningBalanceRecord['ChartOfAccountId'] === $ChartOfAccountId) 
		    {
			$dBalance = $OpenningBalanceRecord['Balance']; 
		    }
		}
	    }
	    ?>
            <table style="width:100%; text-align: center; padding-left: 1px; border-bottom: 0px;">
              <thead>
                <tr style="border-bottom: 0px; border-top: 0px; border-right: 0px; border-left: 0px;">
                 <th style="font-family:Calibri; font-size:15px; padding-left:10px; height: 40px;" align="left" colspan="7">General Ledger - <?php echo $ChartOfAccountTitle; ?></th>
		</tr>
		<tr>
		   <th style="font-family:Calibri; font-size:15px; padding-left:10px; height: 40px; border: none;" align="left" colspan="7">Opening Balance  <?php echo number_format($dBalance, 0); ?></th> 
		</tr>
                <tr style="background-color: #205081; color: #fff; height: 30px;border-bottom: 1px solid;">
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Date</th>
                 <th style="border-bottom:1px solid; width:35%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Detail</th>
                 <th style="border-bottom:1px solid; width:5%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Ref No.</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Debit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Credit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Calibri; font-weight:bold; font-size:12px; text-align: center;">Balance</th>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach($SubLedgerReport as $SubLedgerReportRecord) {
            
              if($SubLedgerReportRecord['ChartOfAccountId'] == $LedgerReportRecord['ChartOfAccountId']) 
              {
	      
	      $ChartOfAccountId = $SubLedgerReportRecord['ChartOfAccountId'];
              $GeneralJournalId = $SubLedgerReportRecord['GeneralJournalId'];
	      $PurchaseId = $SubLedgerReportRecord['PurchaseId'];
              $Reference = $SubLedgerReportRecord['Reference'];
              $dTransactionDate = $SubLedgerReportRecord['TransactionDate'];
              $sTransactionDate = date("M j, Y", strtotime($dTransactionDate));
              $Detail = $SubLedgerReportRecord['Detail'];
              $dDebit = $SubLedgerReportRecord['Debit'];
              $dCredit = $SubLedgerReportRecord['Credit'];
//              $CompanyName = $SubLedgerReportRecord['CompanyName'];
              $ChartOfAccountTitle = $SubLedgerReportRecord['ChartOfAccountTitle'];
	      $voucherType = $SubLedgerReportRecord['VoucherType'];
	
	      
              if($DebitIncrease == 1)
	      {
		  $dTransBalance = $dDebit - $dCredit;
	      }
              
	      if($CreditIncrease == 1)
	      {
		$dTransBalance = $dCredit - $dDebit;
	      }
	      
	      if($DebitIncrease == 1)
	      {
		  $dBalance += $dTransBalance; 
	      }
	     
	      if($CreditIncrease == 1)
	      {
		  $dBalance += $dTransBalance;
	      }	 
	      
	      /*
	      if($DebitIncrease == 1)
	      {
		  $dBalance += $dTransBalance;
	      }
              else
	      { 
		  $dBalance -= $dTransBalance;
	      }
              */
              
              $dTotal_Debit += $dDebit;
              $dTotal_Credit += $dCredit;

              $sDebit = number_format($dDebit, 0);
              $sCredit = number_format($dCredit, 0);
              
              if ($dDebit == 0) $sDebit = '';
              if ($dCredit == 0) $sCredit = '';
              
	      $dClosingBalance = 0;
	      /*
	      if($DebitIncrease == '1') 
	      { 
		  $dClosingBalance = $dTotal_Debit - $dTotal_Credit; 
	      }
              else 
	      {
		  $dClosingBalance = $dTotal_Credit - $dTotal_Debit;			
	      }
	      */
	      ?>
              <tr style="font-size:12px; height: 30px;">
                <td style="text-align: left; padding-left:10px; font-weight: 600"><?php echo $sTransactionDate; ?></td>
		<td style="text-align: left; padding-left:10px;"><?php if ($PurchaseId != 0) { 
		echo '<a href="#" onclick="window.open(\''.base_url().'AccountReports/ViewVendorPurchaseInvoice/'.$PurchaseId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">'.'PI '.$PurchaseId.'</a>';
		}; ?></td>
		
                
		<td style=" text-align: center; font-weight: 600"><?php echo $Reference; // if ($SaleId != 0) { echo 'SI '.$SaleId; };  /* if($SaleId == 0 || $SaleId == '') { echo $Reference; } else {  echo 'SI '.$SaleId; } */  //'<a href="javascript:void(0)" onclick="window.open(\''.base_url().'GeneralJournal/ViewVoucher/'.$GeneralJournalId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">'.$Reference.'</a>'; ?></td>
                <td style="text-align: center;"><?php echo $sDebit; ?></td>
                <td style="text-align: center;"><?php echo $sCredit; ?></td>
                <td style="text-align: center;"><?php echo number_format($dBalance,0); ?></td>                
              </tr>
              <?php
              $dGrandTotal_Debit += $dDebit;
              $dGrandTotal_Credit += $dCredit;
              $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
              } }
              ?>
              <tr style="font-size:12px; height: 30px;">
                <td colspan="3" style=" font-weight:700; text-align: right;">Total:</td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dTotal_Debit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dTotal_Credit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php echo number_format($dBalance,0); ?></td>
              </tr>
              <?php
              $sDebit = 0;
              $sCredit = 0;
	      $dBalance = 0;
              $dTotal_Debit = 0;
              $dTotal_Credit = 0;
              $dBalance = 0;
              ?> 

            <?php } // for loop ends 
            } // main codition end
            ?> 
               
              </tbody>
              <tr>
                  <td colspan="7">&nbsp;</td>
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
              <option value="">Select Recipient</option>
               <?php foreach ($AllEmployees as $row) { ?>
               <option value="<?php  echo $row['EmailAddress']; ?>"><?php echo $row['EmailAddress']; ?></option>
               <?php } ?>
               <option value="sarmadsoomro94@gmail.com">sarmadsoomro94@gmail.com</option>
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
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Sale Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
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

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendSaleDetailReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate},
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