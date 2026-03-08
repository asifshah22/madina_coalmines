<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Sales</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Sale Details</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
            <form role="form" id="SaleOrderForm" action='<?php echo base_url("Sales/SaveSale") ?>' method="post">
      
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Invoice #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;" id="SNo"><?= $Sales->SaleId; ?></span>
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Counter #:</strong><br>
          <?php 
          if($Sales->Counter == 1){
              echo "Counter One";
          } 
          if($Sales->Counter == 2){
            echo "Counter Two";
          } 
          if($Sales->Counter == 3){
            echo "Counter Three";
          } 
          ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Status #:</strong><br>
          <?= $Sales->SaleStatus; ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale:</strong><br>
        <?php 
          if($Sales->SaleType == "1"){ echo "On Cash"; }
          if($Sales->SaleType == "2"){ echo "On Credit"; }
          if($Sales->SaleType == "3"){ echo "Online"; }
        ?>
      </address>
    </div>

       <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer:</strong><br>
       <?php echo $Sales->CustomerName; ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Bank Account:</strong><br>
         <?php echo $Sales->AccountTitle . " - " . $Sales->AccountNumber;  ?>
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
    <strong>P.O. Date:</strong><br>
    <?php 
      // Assuming $Sales is your object and it has a PODate property
      echo !empty($Sales->PODate) ? date('d-m-Y', strtotime($Sales->PODate)) : 'N/A';
    ?>
  </address>
</div>

   

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Date:</strong><br>
        <?php echo date('M d, Y H:i:s',strtotime($Sales->SaleDate)); ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>P.O No:</strong><br>
        <?php echo $Sales->SaleNote; ?>
      </address>
    </div>
    
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vehicle Number:</strong><br>
        <?php echo $Sales->VehicleNo; ?>
      </address>
    </div>    
    
<div class="col-sm-3 invoice-col">
  <address>
    <strong style="color: #ff0000;">Scenario Type:</strong><br>
    <?php 
    // Create an array mapping codes to display names
    $scenarioTypes = [
        'SN001' => 'Goods at Standard Rate to Registered Buyers',
        'SN002' => 'Goods at Standard Rate to Unregistered Buyers',
        'SN005' => 'Reduced Rate Sale',
        'SN006' => 'Exempt Goods Sale',
        'SN007' => 'Zero Rated Sale',
        'SN008' => 'Sale of 3rd Schedule Goods',
        'SN016' => 'Processing / Conversion of Goods',
        'SN017' => 'Sale of Goods where FED is Charged in ST Mode',
        'SN020' => 'Electric Vehicle',
        'SN024' => 'Goods Sold that are Listed in SRO 297(1)/2023'
    ];
    
    // Display the corresponding name if code exists, otherwise show the raw value
    echo isset($scenarioTypes[$Sales->Scenario_Type]) ? 
         $scenarioTypes[$Sales->Scenario_Type] : 
         $Sales->Scenario_Type;
    ?>
  </address>
</div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Saleman:</strong><br>
        <?php echo $Sales->SalemanName; ?>
      </address>
    </div>


<div class="col-sm-12">
    <h4 style="color: #2e7d32; font-weight: 600; border-bottom: 2px solid #2e7d32; padding-bottom: 8px; margin-bottom: 20px;">
        FBR Information
    </h4>
</div>

<div class="col-sm-12" style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
    <div style="flex: 1; min-width: 220px;">
        <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Address:</label>
        <div style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #f8f9fa;">
            <?php echo $Sales->fbr_customer; ?>
        </div>
    </div>
    
    <div style="flex: 1; min-width: 220px;">
        <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">ST Registration No.:</label>
        <div style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #f8f9fa;">
            <?php echo $Sales->fbr_cnic; ?>
        </div>
    </div>
    
    <div style="flex: 1; min-width: 220px;">
        <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">Mobile:</label>
        <div style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #f8f9fa;">
            <?php echo $Sales->fbr_mobile; ?>
        </div>
    </div>
    
    <div style="flex: 1; min-width: 220px;">
        <label style="display: block; margin-bottom: 6px; font-weight: 600; color: #555;">NTN:</label>
        <div style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #f8f9fa;">
            <?php echo $Sales->fbr_ntn; ?>
        </div>
    </div>
</div>

    <div class="col-sm-6 invoice-col">
      <address>
        <div style="font-weight:600;" class="col-sm-8" id="AccountReceivable"></div>
      </address>
    </div>    
        </div>
      </div>
    <div class="row" style="display: block;" id="mainRow">
    <div class="col-md-12">
      <div class="box-body pad table-responsive">
          

<table class='table table-bordered' id="Sale_EntriesTable" style="width: 100%; border-collapse: separate; border-spacing: 0;">
    <thead>    
        <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
    <th style="width:2%;">S.#</th>
    <th style="padding:5px; width:10%; text-align: center;">P.O No#</th>
    <th style="padding:5px; width:10%; text-align: center;">Item</th>
    <th style="padding:5px; width:10%; text-align: center;">Location</th>
    
    <th style="padding:5px; width:10%; text-align: center;">QTY - TON</th>
    
    <th style="padding:5px; width:10%; text-align: center;">Rate - TON</th>
    <th style="padding:5px; width:5%; text-align: center;"></th>
    <th style="padding:5px; width:10%; text-align: center;">Rate</th>
    <th style="padding:5px; width:5%; text-align: center;">Qty</th>
    <th style="padding:5px; width:10%; text-align: center;">Amount</th>
    <th style="padding:5px; width:10%; text-align: center;">GST Rate %</th>
    <th style="padding:5px; width:10%; text-align: center;">GST Amount</th>
    
    <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Rate %</th>
    <th style="padding: 10px; width: 5%; border-top: 1px solid #dee2e6; border-bottom: 2px solid #dee2e6; font-weight: 600; color: #495057;">Further Tax Amt</th>
    <th style="padding:5px; width:10%; text-align: center;">Discount Total</th>
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
		$TaxPercentage=0;
		$FurtherTaxAmt=0;
	        foreach($SalesDetail as $Record) {
	       ?>
	       <tr>
		<td style="text-align:center;"><?php echo $SNo; ?></td>
		<td style="text-align:left;"><?php echo $Record['ProductBarCode'];?></td>
		<td style="text-align:left;"><?php echo $Record['ProductName'];?></td>
		<td style="text-align:left;"><?php echo $Record['LocationName'];?></td>
		<td style="text-align:left;"><?php echo $Record['EngineNo'];?></td>
		<td style="text-align:left;"><?php echo $Record['ChassisNo'];?></td>
		<td style="text-align:left;"><?php echo $Record['ColourName'];?></td>
		<td style="text-align:center;"><?php echo $Record['Rate'];?></td>
		<td style="text-align:center;"><?php echo $Record['Quantity'];?></td>
		<td style="text-align:center;"><?php echo $Record['Amount'];?></td>
		<td style="text-align:center;"><?php echo $Record['DiscountAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxPercentage'];?></td>
		
		<td style="text-align:center;"><?php echo $Record['FurtherTaxRate'];?></td>
		<td style="text-align:center;"><?php echo $Record['FurtherTaxAmt'];?></td>
		<td style="text-align:center;"><?php echo $Record['TaxAmount'];?></td>
		<td style="text-align:center;"><?php echo $Record['NetAmount'];?></td>
	       </tr>
	       <?php 
	       $SNo++; 
	        $Quantity += $Record['Quantity'];
          $Amount += $Record['Amount'];
          $TaxPercentage += $Record['TaxPercentage'];
          $TaxAmount += $Record['TaxAmount'];
	        $NetAmount += $Record['NetAmount'];
	        $FurtherTaxAmt += $Record['FurtherTaxAmt'];
		} ?>
             </table>

             <div style="height: 50px;"></div>
	     <table class="table" border="0">
              <tbody>
                <tr>
		    <td colspan="13">
		    </td>
                </tr>
                <tr id="wh-tax-row">
    <td colspan="10" style="width: 80%; text-align:right; font-weight:600; border:0px solid;">WH Tax %:</td>
    
          <td><div id="total_tax" style='font-weight:600; text-align:right; color:#008000;'><?php echo $Sales->wh_tax_percent; ?></div></td>
    <td style="text-align:right; font-weight:600; border:0px solid;">WH Tax Amount:</td>
    
    
          <td><div id="total_tax" style='font-weight:600; text-align:right; color:#008000;'><?php echo $Sales->wh_tax_amount; ?></div></td>
</tr>
		
	<tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Discount:</td>
          <td><div id="total_tax" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($TaxAmount); ?></div></td>
        </tr>
       <?php if($Sales->SaleType == "2"){ ?>
        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Cash Received:</td>
          <td><div id="cashreceived" style='font-weight:600; text-align:right; color:#008000;'><?php if(!empty($CashDetail)){ echo number_format($CashDetail[0]['Debit'],2,'.',''); } ?></div></td>
        </tr>
       <?php } ?>
	<tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Quantity:</td>
          <td><div id="Quantity" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Quantity,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Amount:</td>
          <td><div id="Amount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($Amount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total GST Amount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($TaxPercentage,2,'.',''); ?></div></td>
        </tr>

<tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Further Tax Amount:</td>
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($FurtherTaxAmt,2,'.',''); ?></div></td>
        </tr>

       

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="NetAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
        </tr>
  <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount+WH Tax Amount :</td>
          <td><div id="TotalAmountWHTax" style='font-weight:600; text-align:right; color:#008000;'><?php echo $NetAmount+$Sales->wh_tax_amount; ?></div></td>
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
    <a href="<?php echo base_url(); ?>Sales/AddSale"><button type="button" class="btn btn-success pull-left" style="color:white; margin-right:5px;"> Add Record </button></a>
    <a href="<?php echo base_url(); ?>Sales/"><button type="button" class="btn bg-primary pull-left" style="color:white; margin-right:5px;">Back to Main</button></a>
    <a href="javascript:void(0)" class="btn btn-danger pull-right" id="generate_saleinvoice_report"><i class="fa fa-print"></i>&nbsp;Print Invoice</a>
    <a href="javascript:void(0)" class="btn btn-warning pull-right" id="generate_gatepass_report"><i class="fa fa-print"></i>&nbsp;Delivery Challan</a>
        </div>
              </div> 

<?php $this->load->view("includes/footer"); ?>
<script>

     $(function(){
      $("body").on("click","#generate_saleinvoice_report",function(){
      
  var InvoiceNo = $("#SNo").text();
  
      window.open("<?php echo site_url(); ?>SaleReports/ViewSaleInvoiceReport?InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>
    
    <script>

     $(function(){
      $("body").on("click","#generate_saleinvoice_report2",function(){
      
  var InvoiceNo = $("#SNo").text();
  
      window.open("<?php echo site_url(); ?>SaleReports/ViewSaleInvoiceReport?print2=true&InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>
    
<script>

 $(function(){
  $("body").on("click","#generate_gatepass_report",function(){
  
var InvoiceNo = $("#SNo").text();

  window.open("<?php echo site_url(); ?>SaleReports/ViewGatePassReport?InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
    });
  });
</script>