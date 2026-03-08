   <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/pos.min.css">
    
    <div class="col-md-12">
      <!-- form elements --> 
      <div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title text-light-blue">Purchase Voucher</h3>
        <span class="pull-right" style="font-size:13px; font-family: Arial, Helvetica, sans-serif;"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;</span>
  </div>
      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
              <address style="font-size:13px;">
                    <strong>Purchase #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Purchase->PurchaseNo; ?></span>
                  </address>
                </div>
                
              <div class="col-sm-6 invoice-col">
                   <address style="font-size:13px;">
                    <strong>Vendor Name:</strong><br>
                      <span style="color:#800000; font-size:13px; font-weight:bold;"><?php echo $Purchase->VendorName; ?></span>
                  </address> 
                </div>

              <div class="col-sm-6 invoice-col">
                  <address style="font-size:13px;">
                    <strong>Frieght Inward Charges:</strong><br>
                    <?php echo $Purchase->FrieghtInwardCharges; ?>
                  </address>
                </div>
                
                <div class="col-sm-6 invoice-col">
                  <address style="font-size:13px;">
                    <strong>Transportation #:</strong><br>
        <?php echo $Purchase->TransportBuiltyNo; ?>
                  </address>
                </div>

                <div class="col-sm-6 invoice-col">
                  <address style="font-size:13px;">
                    <strong>Purchase Date:</strong><br>
                    <?php echo date('M d, Y', strtotime($Purchase->PurchaseDate)); ?>
                  </address>
                </div>            
            </div>
          </div>
              <input type="hidden" name="PurchaseId" id="PurchaseId" value="<?php echo $Purchase->PurchaseId; ?>">
                <!-- Sales Order Detail Block -->
                <div class="row">
        <div class="col-md-12">   
          <div class="box-body  table-responsive">
            <table id="GJ_EntriesTable" style="border:0px solid;" class="table table-bordered text-center">
                            <tr style="background-color:#ECF9FF; font-size:13px;">
                             <th style="padding:5px; text-align:center;">S.#</th>
                             <th style="padding:5px; text-align:center;">Product Name</th>
           <th style="padding:5px; text-align:center;">Weight (KG)</th>
                 <th style="padding:5px; text-align:center;">Raw Material Deduction</th>
                             <th style="padding:5px; text-align:center;">Rate</th>
                             <th style="padding:5px; text-align:center;">Amount</th>
           <th style="padding:5px; text-align:center;">GST %</th>
                             <th style="padding:5px; text-align:center;">GST Amount</th>
                             <th style="padding:5px; text-align:center;">FED %</th>
                             <th style="padding:5px; text-align:center;">FED Amount</th>
           <th style="padding:5px; text-align:center;">Net Amount</th>
                            </tr>
                            <?php
          $SNo = 1;
          $TotalWeight = 0;
          $TotalAmount = 0;
          $TotalNetAmount = 0;
                            $GSTAmount = 0;
                            $FEDAmount = 0;

                            foreach($PurchaseDetail as $Record) { 
                            ?>
                            <tr class="txtMult" style="font-size:13px;">
                              <td style="padding:5px;"><?php echo $SNo; ?></td>
                              <td style='padding:5px; width:15%; text-align:left;'><?php echo $Record["ProductName"];?></td>
			      <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Weight"],2); ?></td>
			      <td style='padding:5px; width:12%; text-align:right;'><?php echo $Record["DeductionRawMaterial"];?></td>
			      <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Rate"],2);?></td>
                              <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Amount"],2);?></td>
                              <td style='padding:5px; width:7%; text-align:right;'><?php echo $Record["GST"];?></td>
                              <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["GSTAmount"],2);?></td>
                              <td style='padding:5px; text-align:right;'><?php echo $Record["FED"];?></td>
                              <td style='padding:5px; text-align:right;'><?php echo number_format($Record["FEDAmount"],2);?></td>
			     <td style='padding:5px; text-align:right;'><?php echo number_format($Record["NetAmount"],2);?></td>
                            </tr>
                            <?php $SNo++;
			    $TotalWeight += $Record["Weight"];
			    $TotalAmount += $Record["Amount"];
                            $GSTAmount += $Record["GSTAmount"];
                            $FEDAmount += $Record["FEDAmount"];
			    $TotalNetAmount += $Record["NetAmount"];
                            } ?>
                            <tr style="font-weight:600; font-size:13px;">
            <td colspan="2"></td>
                              <td style="font-weight:600; text-align:right;"><?php echo number_format($TotalWeight,2); ?></td>
            <td colspan="7" style="text-align:right; font-weight:600;">Total Amount:</td>           
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($TotalAmount,2); ?></td>
                            </tr>
          <tr style="font-weight:600; font-size:13px;">
                              <td colspan="10" style="text-align:right; font-weight:600;">Total GST Amount:</td>
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($GSTAmount,2); ?></td>
                            </tr>
          <tr style="font-weight:600; font-size:13px;">
                              <td colspan="10" style="text-align:right; font-weight:600;">Total FED Amount:</td>
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($FEDAmount,2); ?></td>
                            </tr>
         <tr style="font-weight:600; font-size:13px;">
                            <td colspan="10" style="text-align:right; font-weight:600; width:85%;">Net Amount:</td>
                            <td style="width:12%;"><div style='font-weight:600; color:#008000; text-align:right;'><?php echo number_format($TotalNetAmount,2); ?></div></td>                         
                           </tr>                            
                            </table>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
    

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
          <input type="hidden" name="PurchaseId" id="PurchaseId" value="<?php echo $Purchase->PurchaseId; ?>">
<div class="form-group">
          <label for="Subject" class="col-sm-3 control-label"><b>Subject:</b></label>
          <div class="col-sm-8">
                <input type="text" name="Subject" id="Subject" class="form-control" required="required" value="Purchase Voucher ">
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
      var PurchaseId = $("#PurchaseId").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendPurchaseVoucher',
        data: {EmployeeId:EmployeeId,Subject:Subject,Comments:Comments,Message:Message,PurchaseId:PurchaseId},
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