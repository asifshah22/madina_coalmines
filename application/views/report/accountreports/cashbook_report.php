<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cash Book Report</title>
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
      <h3 style="color:green;text-align: center;">Cash Book</h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></span></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url() ?>Export/ExportExcelCashBookReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Excel</a></li>
          <li><a href="<?php echo base_url()?>Export/ExportWordCashBookReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>">Word</a></li></ul>
          </span> &nbsp; </span>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
           </div>
           
      <div style="height:30px;"></div>
            <?php
            $SNo=1;
            $CustomerName = '';
            $dTotal_Debit = 0;
            $dTotal_Credit = 0;
            $InvoicePaidStatus = 0;
            $dGrandTotal_Debit = 0;
            $dGrandTotal_Credit = 0;
            $GrandBalance = 0;
      $NewDetail = '';
            
            $dDebit = 0; 
            $dCredit = 0;
            $dTransBalance = 0;
            $dBalance = 0;
            $dClosingBalance = 0;

            if(isset($CashBookReport)) {
            foreach($CashBookReport as $CashBookReportRecord) {
            
            $ChartOfAccountsCategoryId = $CashBookReportRecord['ChartOfAccountsCategoryId'];
          //  $PurchaseId = $CashBookReportRecord['PurchaseId'];
      $ChartOfAccountsId = $CashBookReportRecord['ChartOfAccountsId'];
            $ChartOfAccountsTitle = $CashBookReportRecord['ChartOfAccountsTitle'];
            $ChartOfAccountsCode = $CashBookReportRecord['ChartOfAccountsCode'];
            $DebitIncrease = $CashBookReportRecord['DebitIncrease'];
      $CreditIncrease = $CashBookReportRecord['CreditIncrease'];
      
      
      
      foreach($OpenningBalanceOne as $OpenningBalanceOneRecord)
      {
    if($OpenningBalanceOneRecord['ChartOfAccountsId'] === $ChartOfAccountsId) 
    {  
        $dBalance = $OpenningBalanceOneRecord['Balance']; 
    }
      }
            ?>
            <table border="1" cellspacing="0" cellpadding="3" style="width:100%; text-align: center; padding-left: 1px;">
              <thead>
                <tr>
                 <th style="font-family:Tahoma, Arial; font-size:15px; padding-left:10px;" align="left" colspan="7">General CashBook - <?php echo $ChartOfAccountsTitle; ?></th>
    </tr>
                <tr>
                 <th style="font-family:Tahoma, Arial; font-size:14px; padding-left:10px;" align="left" colspan="7">Opening Balance <?php echo number_format($dBalance, 2); ?></th>
    </tr>
                <!-- <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">-->
                <tr>
                 <th style="border-bottom:1px solid; width:6%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Date</th>
                  <th style="border-bottom:1px solid; width:16%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Head of Account</th>
                 <th style="border-bottom:1px solid; width:35%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Description</th>
                 <th style="border-bottom:1px solid; width:5%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Ref No.</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Debit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Credit</th>
                 <th style="border-bottom:1px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; font-size:12px; text-align:center;">Balance</th>
                </tr>
              </thead>
              <tbody>
              <?php
        
        
    //echo '<pre>';
    //print_r($PurchaseDetail);
    
              foreach($SubCashBookReport as $SubCashBookReportRecord) {
             
              //if($SubCashBookReportRecord['CompanyName'] != '')
            //  {
            
              if($SubCashBookReportRecord['ChartOfAccountsId'] == $CashBookReportRecord['ChartOfAccountsId']) 
              {
                              
              $ChartOfAccountsId = $SubCashBookReportRecord['ChartOfAccountsId'];
              $GeneralJournalId = $SubCashBookReportRecord['GeneralJournalId'];
              $Reference = $SubCashBookReportRecord['ReferencePrefix'] . '' . $SubCashBookReportRecord['Reference'];
              $dTransactionDate = $SubCashBookReportRecord['TransactionDate'];
              $sTransactionDate = date("M d, Y", strtotime($dTransactionDate));
              $Detail = $SubCashBookReportRecord['Detail'];
              //$SalesInvoiceId = $SubCashBookReportRecord['Detail'];
        $SalesInvoiceId = $SubCashBookReportRecord['SalesInvoiceId'];
        $PurchaseId = $SubCashBookReportRecord['PurchaseId'];
              $dDebit = $SubCashBookReportRecord['Debit'];
              $dCredit = $SubCashBookReportRecord['Credit'];
              $CustomerName = $SubCashBookReportRecord['CustomerName'];
              $VendorName = $SubCashBookReportRecord['VendorName'];
              $AccountTitle = $SubCashBookReportRecord['AccountTitle'];
        //$InvoicePaidStatus = $SubCashBookReportRecord['InvoicePaidStatus'];
        $voucherType = $SubCashBookReportRecord['VoucherType'];
              $ReconciliationStatus  = $SubCashBookReportRecord['ReconciliationStatus'];
      
        // Show light blue colour if Reconciliation Statu is zero 
      //  $ReconciliationStatusColor = $ReconciliationStatus == 0 ? 'background-color:#eaf9ff;' : '';
       
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
              
              $dTotal_Debit += $dDebit;
              $dTotal_Credit += $dCredit;

              $sDebit = number_format($dDebit, 2);
              $sCredit = number_format($dCredit, 2);
              
              if ($dDebit == 0) $sDebit = '';
              if ($dCredit == 0) $sCredit = '';
        
        /*
              if($DebitIncrease == '1') $dClosingBalance = $dTotal_Debit - $dTotal_Credit;
              else $dClosingBalance = $dTotal_Credit - $dTotal_Debit;
        */
              ?>
              <tr style="font-size:12px;">
                <td style="text-align: left; padding-left:10px;"><?php echo $sTransactionDate; ?></td>
               <td style="text-align: left; padding-left:10px;">
                  <?php echo $SubCashBookReportRecord['CustomerName']; ?>
                  <?php echo $SubCashBookReportRecord['VendorName']; ?>
                  <?php echo $SubCashBookReportRecord['AccountTitle']; ?>    
                </td>
                <td style="text-align: left; padding-left:10px;">
                <?php
    
/*    if($PurchaseId != 0)
    {  
        $NewDetail = '<a href="#" onclick="window.open(\''.base_url().'Purchase/ViewPurchaseVoucher/'.$PurchaseId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">Purchase Id: '.$PurchaseId.'</a>'; 
    }
    else if($SalesInvoiceId != 0)
    {
        $NewDetail = '<a href="#" onclick="window.open(\''.base_url().'Invoice/ViewInvoiceVoucher/'.$SalesInvoiceId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">Invoice Id: '.$SalesInvoiceId.'</a>';
    }
    else
    {*/
        $NewDetail = $Detail;
//    }
    
    echo $NewDetail;
    
                ?></td> 
                <td style=" text-align:left;"><?php echo '<a href="javascript:void(0)" onclick="window.open(\''.base_url().'Generaljournal/ViewVoucher/'.$GeneralJournalId.'\',\'popUpWindow\',\'height=450,width=800,left=400,top=100,resizable=no,scrollbars=0,toolbar=no,menubar=no,location=no,directories=no, status=yes\');">'.$Reference.'</a>'; ?></td>
                <td style="text-align:right; padding-right:5px;"><?php echo $sDebit; ?></td>
                <td style="text-align:right; padding-right:5px;"><?php echo $sCredit; ?></td>
                <td style="text-align:right; padding-right:5px;"><?php echo number_format($dBalance,2); ?></td>                
              </tr>
              <?php
              $dGrandTotal_Debit += $dDebit;
              $dGrandTotal_Credit += $dCredit;
              $GrandBalance = $dGrandTotal_Debit - $dGrandTotal_Credit;
              } }
              ?>
              <tr style="font-size:12px;">
                <td colspan="3" style="font-weight:700; text-align:right;">Total:</td>
                <td style="font-weight:700; text-align:right; padding-right:5px;"><?php echo number_format($dTotal_Debit,2); ?></td>
                <td style="font-weight:700; text-align:right; padding-right:5px;"><?php echo number_format($dTotal_Credit,2); ?></td>
                <td style="font-weight:700; text-align:right; padding-right:5px;"><?php echo number_format($dBalance,2); ?></td>
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
              <!--  <tr style="font-size:13px;">
                <td colspan="4" style=" font-weight:700; text-align: right;">Grand Total:</td>
                <td style="font-weight: 700; text-align: center;"><?php // echo number_format($dGrandTotal_Debit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php // echo number_format($dGrandTotal_Credit,0); ?></td>
                <td style="font-weight: 700; text-align: center;"><?php // echo number_format($GrandBalance,0); ?></td>
              </tr>
              </tbody> -->
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
        <input type="hidden" name="CustomerId" id="CustomerId" value="<?php echo $this->input->get('CustomerId'); ?>">
        <input type="hidden" name="VendorId" id="VendorId" value="<?php echo $this->input->get('VendorId'); ?>">
        <input type="hidden" name="AccountId" id="AccountId" value="<?php echo $this->input->get('BAId'); ?>">
        <input type="hidden" name="CId" id="CId" value="<?php echo $this->input->get('CId'); ?>">
        <input type="hidden" name="CCId" id="CCId" value="<?php echo $this->input->get('CCId'); ?>">
        <input type="hidden" name="COAId" id="COAId" value="<?php echo $this->input->get('COAId'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="General CashBook Report from: <?php echo date('M d, Y', strtotime($this->input->get('StartDate')));?> To <?php echo date('M d, Y', strtotime($this->input->get('EndDate')));?> ">
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
      var CustomerId = $("#CustomerId").val();
      var VendorId = $("#VendorId").val();
      var AccountId = $("#AccountId").val();
      var CId = $("#CId").val();
      var CCId = $("#CCId").val();
      var COAId = $("#COAId").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendCashBookReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,StartDate:StartDate,EndDate:EndDate,CustomerId:CustomerId,VendorId:VendorId,AccountId:AccountId,CId:CId,CCId:CCId,COAId:COAId},
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