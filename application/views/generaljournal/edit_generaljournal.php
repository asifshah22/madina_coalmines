<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

 <div class="content-wrapper">
    <section class="content-header">
      <h1><i class="fa fa-book"></i>&nbsp;General Journal</h1>
    </section>
          
    <?php $arrVoucherType = array("Cash Payment Voucher","Bank Payment Voucher","Cash Receipt Voucher","Bank Receipt Voucher","Journal Voucher"); ?> 
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Edit General Journal</h3>
            </div>
      
      <form role="form"  class="form-horizontal" method="post" id="GeneralJournalForm" action='<?php echo site_url("GeneralJournal/UpdateGeneralJournal")?>'>
      <div class="box-body">
       <div class="row invoice-info">
          
        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Voucher #:</strong><br>
      <?php echo $GetGeneralJournal['GeneralJournal']->Reference; ?>
          </address>
        </div>

        <div class="col-sm-4 invoice-col">
          <address>
      <?php $arrVoucherType = array("Cash Payment Voucher","Bank Payment Voucher","Cash Receipt Voucher","Bank Receipt Voucher","Journal Voucher"); ?>
      <strong>Voucher Type:</strong><br>
       <select class="form-control" name="VoucherType" id="voucherType" style="width:215px;" required="required">
       <option value="">-- Select voucher Type --</option>
       <?php for($i=0; $i<count($arrVoucherType); $i++) { ?>
       <option value="<?php echo ($i+1)?>"<?php if(($i+1) == $GetGeneralJournal['GeneralJournal']->VoucherType) echo "selected=selected"; ?>><?php echo $arrVoucherType[$i]?></option>
       <?php } ?>
       </select> 
          </address>
        </div>

        <div class="col-sm-4 invoice-col">
          <address>
            <strong>Transaction Date:</strong><br>
            <input class="form-control" name="TransactionDate" value="<?php echo date("m/d/Y", strtotime($GetGeneralJournal['GeneralJournal']->TransactionDate)); ?>" id="datepicker1" type="text" required placeholder="Enter Transaction Date" style="width:215px;" autocomplete="off">
          </address>
        </div>
        
        </div>
      </div>      
      <div class="row">
        <div class="col-md-12">   
          <div class="box-body pad table-responsive">
            <table id="GJ_EntriesTable" style="border: 1px solid;" class="table table-bordered text-center">
              <thead>
               <tr style="background-color:#ECF9FF;">
          <th>S#</th>
    <th>Chart Of Account</th>
    <th>Saleman</th>
    <th>Description</th>
    <th>Debit</th>
    <th>Credit</th>
    <th><span class="fa fa-trash"></span></th>
         </tr>
        </thead>
        <?php
              $TotlaDebit = 0;
              $TotalCredit = 0;
              $SNo = 1;
              for($i=0; $i<count($GetGeneralJournal['GeneralJournalEntries']); $i++)
              {
                $TotlaDebit  += $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'];
                $TotalCredit += $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'];
              ?> 
         <tr id="row_<?php echo $i; ?>">
          <td><?php echo $SNo; ?></td>
    <td><input style="width:100%; text-align:left;" type="text" id="chartOfAccount_<?php echo $i; ?>" value="<?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountCode'].'-'.$GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountTitle']; ?>" autocomplete="off"/><input type="hidden" id="hdnchartOfAccount_<?php echo $i; ?>" name="ChartOfAccount[]" value="<?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountId']; ?>"></td>
    <td>                            
    <input style="width:100%; text-align:left;" type="text" id="PayeeName_<?php echo $i; ?>" value="<?php foreach ($GetAllSaleman as $GetAllSalemans) { 
    if($GetGeneralJournal['GeneralJournalEntries'][$i]['SalemanId'] == $GetAllSalemans['SalemanId']) { echo $GetAllSalemans['SalemanName']; }} ?>"/>

    <input type="hidden" id="hdnPayeeName_<?php echo $i?>" name="PayeeName[]" value="<?php foreach ($GetAllSaleman as $GetAllSalemans) { 
    if($GetGeneralJournal['GeneralJournalEntries'][$i]['SalemanId'] == $GetAllSalemans['SalemanId']) { echo $GetAllSalemans['SalemanId']; }} 
     ?>"/>
    </td>
    
    <td><input style="width:100%; text-align:left;" type="text" id="Description_<?php echo $i; ?>" name="Description[]" value="<?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['Detail']?>" autocomplete="off"></td>
    <td><input style="width:100%; text-align:right;" type="text" id="Debit_<?php echo $i; ?>" name="Debit[]" value="<?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'] == '0.00' ? '' : $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit']; ?>" autocomplete="off"></td>
    <td><input style="width:100%; text-align:right;" type="text" id="Credit_<?php echo $i; ?>" name="Credit[]" value="<?php echo $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'] == '0.00' ? '' : $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit']; ?>" autocomplete="off"></td>
    <td><span style="color:red; cursor: pointer;" id="remove_<?php echo $i?>" class="fa fa-times-circle"></span></td>
         </tr>
              <?php $SNo++; } ?> 
            </table>
      </br>
      <table border="0" cellspacing="2" cellpadding="2" width="100%">
       <tbody>
        <tr>
         <td colspan="7">
       <input type="hidden" name="GeneralJournalId" value="<?php echo $GetGeneralJournal['GeneralJournal']->GeneralJournalId;?>">
       <input type="hidden" name="Counter" id="Counter" value="<?php echo $SNo; ?>">
         <span style="cursor:pointer; color:darkgreen; font-weight:600;" id="addRow" class="fa fa-plus"> Add Row</span></td>
        </tr>
        <tr>
         <td colspan="4" style="text-align:right; width:110px; font-weight:600;">Total Amount:</td>
         <td align="center"><div id="divTotal_Debit" style="height:22px; width:110px; border-bottom:1px solid #b9b9b9;font-weight:bold; width:40px;"><?php echo $TotlaDebit; ?></div></td>
         <td align="center"><div id="divTotal_Credit" style="height:22px; border-bottom:1px solid #b9b9b9; font-weight:bold; text-align:right; width:40px;"><?php echo $TotalCredit; ?></div></td>
        </tr>
           </tbody>
      </table>
          </div>
        </div>
      </div>

      <div class="box-body">
      <div class="row">
       <div class="col-md-12">
         <div class="form-group">
           <label for="VoucherNote" class="col-sm-2 control-label">Voucher Note:</label>
             <div class="input-group">
               <textarea name="VoucherNote" class="form-control" rows="2" cols="60"> <?php echo $GetGeneralJournal['GeneralJournal']->VoucherNote;?></textarea>
             </div>
         </div>
       </div>
       <div class="col-md-2">
  <button type="submit" name="submitForm" value="UpdateRecord" class="btn btn-block btn-primary">Update Record</button>
       </div>
       <div class="col-md-2">
         <a href="<?php echo base_url(); ?>GeneralJournal/"><button type="button" name="cancelForm" value="cancelSave" class="btn btn-block btn-primary">Cancel</button></a>
       </div>
      </div>
      <!-- /.row -->
      </div>   
      </form>
      </div>
    </div>
   </div>
   </section>
   </div> 
<!-- ./wrapper -->
<?php  $this->load->view("includes/footer"); ?> 
<script src="<?php echo site_url();?>/lib/js/autocompletejs/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo site_url();?>/lib/css/autocompletecss/jquery-ui.css" />
<script>
    $(function(){
        // auto complete chartOfAccount
        $(document).on('keyup','input[id^=chartOfAccount]',function(){
            var  txtid      = ($(this).attr('id'));
            var  txtvalue   = $(this).val();
            //alert(txtid);
            $(this).autocomplete({
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('GeneralJournal/AutoCompleteSearch_COA')?>",
                        data: { term:txtvalue},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+txtid).val(ui.item.id); // save selected id to hidden input
                },
                minLength: 2
            });
        });
        
        
        // Script for Payees
    $(document).on('keyup','input[id^=PayeeName]',function(){
            var  payeeid    = ($(this).attr('id'));
            var  payeevalue = $(this).val();
      
      // Assign blank value to payee id if payee value is null
      if(payeevalue === '')
      {
    $("#hdn"+payeeid).val('');
      }
         
            $(this).autocomplete({
                source: function(request, response)   {
                    $.ajax({
                        url: "<?php echo site_url('GeneralJournal/GetAllPayee')?>",
                        data: { payee:payeevalue},
                        dataType: "json",
                        type: "POST",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function (event,ui) {
                    $(this).val(ui.item.value); // display the selected text
                    $("#hdn"+payeeid).val(ui.item.id); // save selected id to hidden input
                },
                minLength: 2
            });
        });
        
        // add row
        $("#addRow").on("click",function(){
  // Start Add new row script
  var counter = $("#Counter").val();
  
            var txtId = $("input[id^=chartOfAccount]:last").attr("id");
            var arr = txtId.split("_");
            var nextTxtId = (parseInt(arr[1]) +1);
      $("#GJ_EntriesTable").append('<tr><td>'+nextTxtId+'</td><td><input type="text" style="width:100%; text-align:left;" id="chartOfAccount_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnchartOfAccount_'+nextTxtId+'" name="ChartOfAccount[]"></td><td><input type="text"  style="width:100%; text-align:left;" id="PayeeName_'+nextTxtId+'" autocomplete="off"/><input type="hidden" id="hdnPayeeName_'+nextTxtId+'" name="PayeeName[]" value=""/></td><td><input style="width:100%; text-align:left;" type="text" name="Description[]" autocomplete="off"/></td><td><input style="width:100%; text-align:right;" type="text" id="Debit_'+nextTxtId+'" name="Debit[]" autocomplete="off"/></td><td><input style="width:100%; text-align:right;" type="text" id="Credit_'+nextTxtId+'" name="Credit[]" autocomplete="off"/></td><td><span style="color:red; cursor: pointer; padding-top:8px;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span></td><tr>');
            //$("#GJ_EntriesTable").append('<tr><td>'+nextTxtId+'</td><td><input type="text" id ="chartOfAccount_'+nextTxtId+'" name="chartOfAccount[]" /><input type="hidden" id="hdnchartOfAccount_'+nextTxtId+'" name="hdnchartOfAccount[]" type="text"></td><td><input type = "text" name="Description[]" /></td><td><input type = "text" id="Debit_'+nextTxtId+'" name="Debit[]"/></td><td><input type = "text" id="Credit_'+nextTxtId+'" name="Credit[]"/></td><td><span id="remove_'+nextTxtId+'" class="fa fa-trash"></span></td><tr>');
        })
        // remove row
        $(document).on('mouseover','span[id^=remove]',function(){
            $(this).css({"cursor":"pointer"});
        });
        $(document).on('click','span[id^=remove]',function(){
            removeId = $(this).attr('id');
            arr = removeId.split("_");
            $(this).parent().parent().remove()
        })
    // credit value get debit value on blur cridet
    $(document).on("blur","input[id^=Debit]",function(){
        var debit = $(this).attr('id');
        var DebitValue = $(this).val();
        var arr =  debit.split("_");
        var inputCounter = parseInt(arr[1]);
        var nextCridet = inputCounter +1;
        if(inputCounter % 2 == 0 &&  inputCounter > 1)
        {
          var PerviouDebitValue =  $("#Credit_"+(inputCounter - 1)).val();
          //console.log(PerviouDebitValue);
          if(PerviouDebitValue == '')
               $("#Credit_"+nextCridet).val(DebitValue);
        }
        else
            $("#Credit_"+nextCridet).val(DebitValue);
        if(DebitValue != '')
        $("#Credit_"+arr[1]).val('');
        // show total debit
        var  TotalDebit = 0;
        $("input[id^=Debit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalDebit += parseInt(value);
           $("#divTotal_Debit").text(TotalDebit);
        });
        //show total cridet
        var  TotalCredit = 0;
        $("input[id^=Credit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalCredit += parseInt(value);
           $("#divTotal_Credit").text(TotalCredit);
        });
    });
    
        // debit value get credit value on blur credit
   $(document).on("blur","input[id^=Credit]",function(){
        var cridet = $(this).attr('id');
        var CridetValue = $(this).val();
        var arr =  cridet.split("_");
        var inputCounter = parseInt(arr[1]);
        var nextDebit = inputCounter +1;
        
        if(inputCounter % 2 == 0 && inputCounter > 1 )
        {
            var PerviouDebitValue =  $("#Debit_"+(inputCounter - 1)).val();
            if(PerviouDebitValue == '')
               $("#Debit_"+nextDebit).val(CridetValue);
        }
        else
             $("#Debit_"+nextDebit).val(CridetValue);
        
        if(CridetValue != '' )
        $("#Debit_"+arr[1]).val('');
        //show total cridet
        var  TotalCredit = 0;
        $("input[id^=Credit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalCredit += parseInt(value);
           $("#divTotal_Credit").text(TotalCredit);
        });
        // show total debit
        var  TotalDebit = 0;
        $("input[id^=Debit]").each(function(){
            var value = $(this).val();
            if(value != '')
            TotalDebit += parseInt(value);
           $("#divTotal_Debit").text(TotalDebit);
        });
    });
    
     // Get Debit Description value into credit side
    $(document).on("blur","input[id^=Description]",function(){
      var Description = $(this).attr('id');
      var DescriptionValue = $(this).val();
      var arr =  Description.split("_");
      var inputCounter = parseInt(arr[1]);
      var nextDebit = inputCounter +1;
      $("#Description_"+nextDebit).val(DescriptionValue);
        
       if(nextDebit % 2 === 0)
      {
          //var PerviouDebitValue =  $("#Description_"+(inputCounter - 1)).val();
         // if(PerviouDebitValue == '')
             $("#Description_"+nextDebit).val(DescriptionValue);
       }
        else
        {
           $("#Description_"+nextDebit).val('');
        }
    });
 

//Debit entry must be number
    $("input[id^=Debit]").on("keyup",function(){
        var format =  $(this).val();
        if(isNaN(format))
        {
            alert("Please Enter Number only...!");
            $(this).focus();
            $(this).val('');
        }
    });
    //Credit entry must be number
    $("input[id^=Credit]").on("keyup",function(){
        var format =  $(this).val();
        if(isNaN(format))
        {
            alert("Please Enter Number only...!");
            $(this).focus();
            $(this).val('');
        }
    });
    // form validation
    $("#GeneralJournalForm").on("submit",function(e){
        counter = 0;
        DebitTotal = 0;
        CreditTotal = 0;
  
        $("input[id^=Credit]").each(function(){
             var arr    = $(this).attr("id").split("_");
             var cridet = $(this).val();
             var debit  = $("#Debit_"+arr[1]).val();
             var COA = $("#chartOfAccount_"+arr[1]).val();
             if(!isNaN(parseInt(debit)))  
                DebitTotal += debit;
             if(!isNaN(parseInt(cridet)))  
                CreditTotal += cridet;
            //console.log(debit +''+cridet+''+COA )
             if((debit != '' || cridet != '') && COA == '' )
             {
                e.preventDefault()
                alert("Please Select Chart Of Account...!");
                $("#chartOfAccount_"+arr[1]).focus();
                return false 
             }
             if(COA != '')
                 counter++;
        });
        if(counter == 0)
        {
            e.preventDefault()
            alert("Please add atlease one entry..!")
            return false
        }
        if(DebitTotal != CreditTotal)
        {
            e.preventDefault()    
            alert("Total Debit must equal to Total Credit");
            return false
        }
    });
});
</script>