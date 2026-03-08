<?php
/*echo $now = time(); // or your date as well
$your_date = strtotime("2019-06-01");
$datediff = $now - $your_date;

echo "<br>";
echo round($datediff / (60 * 60 * 24));
die;*/
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Accounts Receivable Aging Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
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
          <center>
            <div class="box-header">
        <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills
<!--           <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a>
           &nbsp; &nbsp;
          <span class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></span></a>
        <ul class="dropdown-menu">
        <li><a href="#" id="pdf">PDF</a></li>
        <li><a href="<?php echo base_url() ?>Export/ExportExcelGenerateAccountReceivableAgingReport?ChartOfAccountsId=<?php // echo $this->input->get('ChartOfAccountsId') ?>&EndDate=<?php // echo $this->input->get('EndDate') ?>">Excel</a></li>
        <li><a href="<?php echo base_url()?>Export/ExportWordGenerateAccountReceivableAgingReport?ChartOfAccountsId=<?php // echo $this->input->get('ChartOfAccountsId') ?>&EndDate=<?php // echo $this->input->get('EndDate') ?>">Word</a></li></ul>
          </span> &nbsp; &nbsp;</span> -->
        </h2>
              <h3 style="color:green; margin-right: 1%;" class="box-title">Accounts Receivable Aging Report</h3>
        <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
        <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Upto: <?php echo date('M d, Y', strtotime($this->input->get('AsOfDate'))); ?></div>
            </div>
<!--           <a class="" href="<?php // echo base_url(); ?>AccountReports/ExportCustomerOutstanding"> Export to Excel </a> -->
      <div style="height:30px;"></div>
            <div class="table-head-only" style="overflow-x: scroll;">
                <table class="table table-bordered" style="width: 70%" id="table-basic">
              <thead>
                <tr style="background:#3c8dbc; font-size:14px; color:#FFFFFF;">
                 <th style="text-align:center; width:7%;">S. #</th>
                 <th style="text-align:center;">Customer Name</th>
                 <th style="text-align:center;">1 to 30 days</th>
                 <th style="text-align:center;">31 to 60 days</th>
                 <th style="text-align:center;">61 to 90 days</th>
                 <th style="text-align:center;">Over 90 days</th>

                 <th style="text-align:center;">Total</th>
                 
                </tr>
              </thead>
              <tbody>
              <?php     
              $Amount = 0;
              $TotalAmount = 0;
              $GrandTotalAmount = 0;
              $SNo=1;
              $a = 0;
              $FirstTotal = 0;
              $SecondTotal = 0;
              $ThirdTotal = 0;
              $FourthTotal = 0;

              if(isset($AccountReceivableDebitAging)) {
              
              $now = strtotime($this->input->get('AsOfDate'));
              foreach($AccountReceivableDebitAging as $Record) 
              {

//              foreach($AccountReceivableDebitAging as $Rec) 
              for ($i=0; $i < count($AccountReceivableCreditAging) ; $i++) { 
/*      
                echo $AccountReceivableCreditAging[$i]['Debit'];
                die;*/

              $Current = ($Record['Debit'] - $AccountReceivableCreditAging[$i]['Credit']);
              $TransactionDate = strtotime($Record['TransactionDate']);
              $datediff = $now - $TransactionDate;
              $days = round($datediff / (60 * 60 * 24));

//              if($days >= 1 && $days <= 30){
                if ($Record['ChartOfAccountsId'] == $AccountReceivableCreditAging[$i]['ChartOfAccountsId']) {
//                  $Amount = $Record['ChartOfAccountsId'].'=='. $AccountReceivableCreditAging[$i]['ChartOfAccountsId'];
//                  echo "<br>";
                $NetAmount = ($Record['Debit'] - $AccountReceivableCreditAging[$i]['Credit'] );
                }
//              }

              if ($NetAmount == 0) {
                continue;
              }

              if($days > 1 && $days <= 30){
                $FirstAmount = $NetAmount;
              }
              else{
                $FirstAmount = 0;
              }

              if($days > 30 && $days <= 60){
                $SecondAmount = $NetAmount;
              }
              else{
                $SecondAmount = '0';
              }

              if($days > 60 && $days <= 90){
//                $ThirdAmount = ($Record['Credit'] - $AccountReceivableCreditAging[$i]['Debit'] );
                $ThirdAmount = $NetAmount;
              }
              else{
                $ThirdAmount = '0';
              }

              if($days >= 91){
//                $FourthAmount = ($Record['Credit'] - $AccountReceivableCreditAging[$i]['Debit'] );
                $FourthAmount = $NetAmount;
              }
              else{
                $FourthAmount = '0';
              }

              //$TotalAmount = ($Record['Credit'] - $AccountReceivableCreditAging[$i]['Debit'] );
//             $TotalAmount = ($NetAmount - $SecondAmount - $ThirdAmount - $FourthAmount);
              }
//              echo "<br><br><br>";
//              echo $FirstAmount;
              ?>
              <tr style="font-size:13px;">
               <td style="text-align:center;"><?php echo $SNo; ?></td>
               <td style="text-align:left;"><?php echo $Record['ChartOfAccountsTitle'];?></td>
               <td style="text-align:right;"><?php echo number_format($FirstAmount,2); ?></td>
               <td style="text-align:right;"><?php echo number_format($SecondAmount,2); ?></td>
               <td style="text-align:right;"><?php echo number_format($ThirdAmount,2); ?></td>
               <td style="text-align:right;"><?php echo number_format($FourthAmount,2); ?></td>
               <td style="text-align:right;"><?php echo number_format(($FirstAmount+$SecondAmount+$ThirdAmount+$FourthAmount),2); ?></td>
              </tr>
              <?php $SNo++;
             // $GrandTotalAmount += $TotalAmount;
              $FirstTotal += $FirstAmount;
              $SecondTotal += $SecondAmount;
              $ThirdTotal += $ThirdAmount;
              $FourthTotal += $FourthAmount;
             $a++;
        } } // }
          //die; ?>
        <!-- <tr style="font-size:13px;">
         <td style="font-weight:700; text-align:right;" colspan="2">&nbsp; Total:</td>
            <td style="font-weight:700; text-align:right;">&nbsp;<?php // echo number_format($FirstTotal,2); ?></td>
            <td style="font-weight:700; text-align:right;">&nbsp;<?php // echo number_format($SecondTotal,2); ?></td>
            <td style="font-weight:700; text-align:right;">&nbsp;<?php // echo number_format($ThirdTotal,2); ?></td>
            <td style="font-weight:700; text-align:right;">&nbsp;<?php // echo number_format($FourthTotal,2); ?></td>
            <td style="font-weight:700; text-align:right;">&nbsp;Grand Total: &nbsp; &nbsp;<?php // echo number_format(($FirstTotal+$SecondTotal+$ThirdTotal+$FourthTotal),2); ?></td>
        </tr>  -->
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
        <input type="hidden" name="AsOfDate" id="AsOfDate" value="<?php echo $this->input->get('AsOfDate'); ?>">
        <input type="hidden" name="CustomerId" id="CustomerId" value="<?php echo $this->input->get('CustomerId'); ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Customer Outstanding Report upto: <?php echo date('M d, Y', strtotime($this->input->get('AsOfDate')));?> ">
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
      var AsOfDate = $("#AsOfDate").val();
      var CustomerId = $("#CustomerId").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendGenerateAccountReceivableAgingReport',
        data: {EmployeeId:EmployeeId,Subject:Subject,Comments:Comments,Message:Message,AsOfDate:AsOfDate,CustomerId:CustomerId},
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