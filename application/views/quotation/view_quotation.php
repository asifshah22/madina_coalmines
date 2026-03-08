<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Delivery Challan</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Delivery Challan Details</h3>
               <strong><a class="btn btn-primary pull-right" id="invoiceBtn" href="<?php echo base_url("Sales/AddSaleQuatation/").$Sales->SaleId ?>">Add Invoice</a></strong>
        <strong><span id="orderBtn" style="display:none" class="btn btn-primary pull-right">Complete Order</span></strong>
        
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
            <form role="form" id="SaleOrderForm" action='<?php echo base_url("Quotation/SaveQuotation") ?>' method="post">
      
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Delivery Challan #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;" id="SNo"><?= $Sales->SaleId; ?></span>
      </address>
    </div>

       <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer / Business Name:</strong><br>
       <?php echo $Sales->CustomerName; ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
       <?php echo $Sales->FullName; ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O Number:</strong><br>
          <?php 
            echo $Sales->WalkinCustomer == "" ? '---' : $Sales->WalkinCustomer;
          ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O Date:</strong><br>
          <?php 
            echo $Sales->MobileNumber == "" ? '---' : $Sales->MobileNumber;
          ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>DC Date:</strong><br>
        <?php echo date('M d, Y H:i:s',strtotime($Sales->SaleDate)); ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle No:</strong><br>
        <?php echo $Sales->SaleNote; ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Address:</strong><br>
        <?php echo $Sales->Address; ?>
      </address>
    </div>
   
  </div>             
    <div style="overflow-x: auto; width: 100%;">
<table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>    
        <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
    <th style="width:2%;">S.#</th>
    <th style="padding:5px; width:10%; text-align: center;">P.O No#</th>
    <th style="padding:5px; width:10%; text-align: center;">P/Description</th>
    <th style="padding:5px; width:10%; text-align: center;">Location</th>
    <th style="padding:5px; width:10%; text-align: center;">Rate</th>
<th style="padding:5px; width:5%; text-align: center;">Rem:Qty</th>
    <th style="padding:5px; width:5%; text-align: center;">Qty</th>
    <th style="padding:5px; width:10%; text-align: center;">Amount</th>
    <th style="padding:5px; width:10%; text-align: center;">Dis: Amt</th>
    <th style="padding:5px; width:10%; text-align: center;">Dis %</th>
    <th style="padding:5px; width:10%; text-align: center;">Discount</th>
    <th style="padding:5px; width:10%; text-align: center;">Net Amount</th>
    </tr>
               </thead>
	       <?php 
	     //  echo '<pre>';
	     //  print_r($SalesDetail);
	       
	        $SNo = 1; 
	        $Quantity = 0;
          $Amount = 0;
          $DiscountAmount = 0;
          $TaxAmount = 0;
          $NetAmount = 0;
	        foreach($SalesDetail as $Record) {
	           // print_r($Record);
	       ?>
	       <tr>
		<td style="text-align:center;"><?php echo $SNo; ?></td>
		<td style="text-align:left;"><?php echo $Record['ProductBarCode'];?></td>
		<td style="text-align:left;"><?php echo $Record['ProductName'];?></td>
		<td style="text-align:left;"><?php echo $Record['LocationName'];?></td>
		<!--<td style="text-align:left;"><?php echo $Record['ColourName'];?></td>-->
		<td style="text-align:center;"><?php echo $Record['Rate'];?></td>
		
		<td style="text-align:center;"><?php echo $Record['Quantity']-$Record['SupplyDone'];?></td>
		<td style="text-align:center;"><?php echo $Record['Quantity'];?></td>
		<td style="text-align:center;"><?php echo $Record['Amount'];?></td>
		<td style="text-align:center;"><?php echo $Record['DiscountAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxPercentage'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['NetAmount'];?></td>
	       </tr>
	       <?php 
	       $SNo++; 
	        $Quantity += $Record['Quantity'];
          $Amount += $Record['Amount'];
          $DiscountAmount += $Record['DiscountAmount'];
          $TaxAmount += $Record['TaxAmount'];
	        $NetAmount += $Record['NetAmount'];
		} ?>
             </table>

             <div style="height: 50px;"></div>
	     <table class="table" border="0">
              <tbody>
                <tr>
                  <td colspan="13"></td>
                </tr>
        
	      <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Quantity,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Amount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount+$Record['TotalDiscount'],2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="NetAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format(($NetAmount - $Record['TotalDiscount']),2,'.',''); ?></div></td>
        </tr>



	      </tbody>
	     </table>

 <div class="col-md-12">&nbsp;
          <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Added By</strong><br>
        <?php echo $this->session->userdata('EmployeeName'); ?>
                  </address>
                  <address>
                    <strong>Added On</strong><br>
                    <?php echo date('M d, Y', strtotime($Sales->AddedOn)); ?>
                  </address>
                </div>
        </div>


           </div>				 
        </form>
             <div class="col-md-12">&nbsp;</div>
        
        <div class="box-footer">
              <div class="col-md-12">
    <a href="<?php echo base_url(); ?>Quotation/AddQuotation"><button type="button" class="btn btn-success pull-left" style="color:white; margin-right:5px;"> Add Record </button></a>
    <a href="<?php echo base_url(); ?>Quotation/"><button type="button" class="btn bg-primary pull-left" style="color:white; margin-right:5px;">Back to Main</button></a>
    <style>
#generate_quotation_report {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff5e62, #ff2d55);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 12px rgba(255, 45, 85, 0.3);
    transition: all 0.3s;
    cursor: pointer;
    border: none;
    z-index: 1000;
}

#generate_quotation_report:hover {
    transform: scale(1.1) translateY(-5px);
    background: linear-gradient(135deg, #ff2d55, #e61e4d);
    box-shadow: 0 8px 16px rgba(255, 45, 85, 0.4);
}

#generate_quotation_report i {
    font-size: 24px;
    transition: transform 0.2s;
}

#generate_quotation_report:hover i {
    transform: scale(1.1);
}

/* Optional: Add a pulse animation on hover */
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(255, 45, 85, 0.7); }
    70% { box-shadow: 0 0 0 12px rgba(255, 45, 85, 0); }
    100% { box-shadow: 0 0 0 0 rgba(255, 45, 85, 0); }
}

#generate_quotation_report:hover:after {
    content: '';
    position: absolute;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}
</style>

<a href="javascript:void(0)" id="generate_quotation_report" title="Print Report">
    <i class="fas fa-print"></i>
</a>
        </div>
              </div> 

<?php $this->load->view("includes/footer"); ?>
<script>

     $(function(){
      $("body").on("click","#generate_quotation_report",function(){
      
  var QuotationNo = $("#SNo").text();
  
      window.open("<?php echo site_url(); ?>SaleReports/ViewQuotationeReport?QuotationNo="+QuotationNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>