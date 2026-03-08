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
              <h3 class="box-title text-light-blue">View General Journal</h3>
            </div>
      
	<input type="hidden" name="GeneralJournalId" id="GeneralJournalId" value="<?php echo $GetGeneralJournal['GeneralJournal']->GeneralJournalId; ?>" />
	  
      <div class="box-body">
       <div class="row invoice-info">
          
        <div class="col-sm-3 invoice-col">
          <address>
            <strong>Voucher #:</strong><br>
       <?php echo $GetGeneralJournal['GeneralJournal']->Reference; ?>
          </address>
        </div>

  <div class="col-sm-3 invoice-col">
          <address>
      <strong>Voucher Type:</strong><br>
       <?php
    for($i=0; $i<count($arrVoucherType); $i++) 
    {
        if(($i+1) == $GetGeneralJournal['GeneralJournal']->VoucherType)
        { echo $arrVoucherType[$i]; }
    }
             ?>
          </address>
        </div>
  <div class="col-sm-3 invoice-col">
          <address>
            <strong>Transaction Date:</strong><br>
            <?php echo date('M d, Y', strtotime($GetGeneralJournal['GeneralJournal']->TransactionDate)); ?>
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
              <th style="padding:3px; width:3%;">S.#</th>
              <th style="padding:3px; text-align:center; width:27%;">Chart Of Account</th>
              <th style="padding:3px; text-align:center; width:20%;">Saleman</th>
              <th style="padding:3px; text-align:center; width:20%;">Description</th>
              <th style="padding:3px; text-align:center; width:15%;">Debit</th>
              <th style="padding:3px; text-align:center; width:15%;">Credit</th>
         </tr>
        </thead>
         <?php  
     $SNo = 1;
     for($i=0; $i<count($GetGeneralJournal['GeneralJournalEntries']); $i++) { 
         ?>
         <tr>
    <td style="padding:3px; width:2%; text-align:center;"><?php echo $SNo; ?></td>
    <td style="padding:3px; text-align:left;"><?php print $GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountCode'].'-'.$GetGeneralJournal['GeneralJournalEntries'][$i]['ChartOfAccountTitle'] ;?></td>
    <td style="padding:3px; text-align:left;">
                <?php  print $GetGeneralJournal['GeneralJournalEntries'][$i]['SalemanName']; ?>
                <?php // print $GetGeneralJournal['GeneralJournalEntries'][$i]['VendorName']; ?>
                <?php // print $GetGeneralJournal['GeneralJournalEntries'][$i]['AccountTitle']; ?>    
                </td>
    <td style="padding:3px; text-align:left;">
                <?php print $GetGeneralJournal['GeneralJournalEntries'][$i]['Detail']?>
                </td>
                <td style="padding:3px; text-align:right;">
                <?php print $GetGeneralJournal['GeneralJournalEntries'][$i]['Debit'];?>
                </td>
                <td style="padding:3px; text-align:right;">
                <?php print $GetGeneralJournal['GeneralJournalEntries'][$i]['Credit'];?>
                </td>
         </tr>
               <?php $SNo++; } ?>
         <tr>                
                <td colspan="4" style="text-align:right; font-weight:600;">Total Amount:</td>
                <td style="font-weight:600; text-align:right; color:#3333CC;"><?php print $GetGeneralJournal['GeneralJournal']->TotalDebit;?></td>
                <td style="font-weight:600; text-align:right; color:#3333CC;"><?php print $GetGeneralJournal['GeneralJournal']->TotalCredit;?></td>
               </tr>
            </table>
    </div>
        </div>
      </div>
      <div class="box-body">
      <div class="row">
       <div class="col-md-12">
         <div class="form-group">
       <label for="VoucherNote" class="col-sm-2 control-label"><strong>Voucher Note:</strong></label>
             <div class="input-group">
               <?php echo $GetGeneralJournal['GeneralJournal']->VoucherNote;?> 
             </div>
         </div>
       </div>

 <div class="col-md-12">&nbsp;
          <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Added By</strong><br>
        <?php echo $this->session->userdata('EmployeeName'); ?>
                  </address>

                  <address>
                    <strong>Added On:</strong><br>
                    <?php echo date('M d, Y', strtotime($GetGeneralJournal['GeneralJournal']->AddedOn)); ?>
                  </address>
                </div>
        </div>

    <div class="col-md-2">
    <a href="<?php echo base_url(); ?>GeneralJournal/AddGeneralJournal" class="btn btn-block btn-primary">Add New Record</a>    
    </div>
    <div class="col-md-2">
   <a href="<?php echo base_url(); ?>GeneralJournal/"><button type="button" name="BackToMain" value="BackToMain" class="btn btn-block btn-primary">Back to Main</button></a>  
       </div>
<div class="col-md-8">
   <!-- <a href="#" class="btn btn-default pull-right" id="generate_voucher_report"><i class="fa fa-print"></i>&nbsp;Print</a>-->
       </div>
    
      </div>
      <!-- /.row -->
      </div>
      </div>
    </div>
   </div>
   </section>
   </div>
<?php  $this->load->view("includes/footer"); ?> 

<script>
     $(function(){
      $("body").on("click","#generate_voucher_report",function(){
      
  var GeneralJournalId = $("#GeneralJournalId").val();
  
      window.open("<?php echo site_url(); ?>GeneralJournal/ViewVoucher/"+GeneralJournalId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>