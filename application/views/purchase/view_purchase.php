<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>

<style>
  .purchase-view {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  .table-responsive {
    overflow-x: auto;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  .table th {
    background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
    padding: 12px 8px;
    font-weight: 600;
    border: 1px solid #dee2e6;
  }
  .table td {
    padding: 10px 8px;
    vertical-align: middle;
    border: 1px solid #dee2e6;
  }
  .total-row {
    background-color: #e9ecef;
    font-weight: bold;
  }
  .total-row td {
    border-top: 2px solid #dee2e6;
  }
  .box-info {
    border-top: 3px solid #17a2b8;
  }
  .text-light-blue {
    color: #17a2b8 !important;
  }
  .invoice-col {
    margin-bottom: 15px;
  }
  .final-value {
    font-weight: bold;
    background-color: #f8f9fa;
  }
  .view-data {
    padding: 8px;
    background-color: #f8f9fa;
    border-radius: 4px;
    margin-top: 5px;
    display: inline-block;
    min-width: 200px;
  }
</style>

  <div class="content-wrapper purchase-view">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-laptop"></i>&nbsp;Purchase</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">  
      <div class="box box-info">
        <div class="box-header with-border col-md-12">
          <h3 class="box-title text-light-blue">View Purchase</h3>
        </div>
        <div style="text-align:right;" class="box-header with-border col-md-12">
        </div>
          
      <div class="box-body">
        <div class="row invoice-info">
    
    <div class="col-sm-3 invoice-col" style="border:0px solid;">
      <address>
        <strong>Purchase #:</strong><br>
        <span class="view-data" style="color:#3333CC; font-size:13px; font-weight:bold;" id="PNo"><?php echo $Purchases->PurchaseNo; ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Status:</strong><br>
        <span class="view-data"><?php echo $Purchases->PurchaseStatus ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vendor:</strong><br>
        <span class="view-data"><?php echo $Purchases->VendorName ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Bank Account:</strong><br>
        <span class="view-data"><?php echo $Purchases->AccountTitle . " - " . $Purchases->AccountNumber;  ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Date:</strong><br>
        <span class="view-data"><?php echo date("M d, Y", strtotime($Purchases->PurchaseDate)); ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Type:</strong><br>
        <span class="view-data">
          <?php 
          if($Purchases->PurchaseType == 1){ 
            echo "On Cash"; 
          } else if($Purchases->PurchaseType == 2){ 
            echo "On Credit"; 
          } else if($Purchases->PurchaseType == 3){ 
            echo "Online"; 
          } else{ 
            echo 'No Type Selected';  
          } 
          ?>
        </span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Note:</strong><br>
        <span class="view-data"><?php echo $Purchases->PurchaseNote ? $Purchases->PurchaseNote : 'N/A'; ?></span>
      </address>
    </div>

        </div>
    </div>
    
    <!-- Purchase Detail Block -->
    <div class="row" style="display: block;" id="mainRow">
      <div class="col-md-12">
        <div class="box-body pad table-responsive">
          <table class='table table-bordered text-center' id="Purchase_EntriesTable">
            <thead>
              <tr style="background: linear-gradient(to bottom, #f8f9fa, #e9ecef);">
                <th style="width:2%;">S.#</th>
                <th style="width:10%;">ITEM</th>
                <th style="width:5%;">LOCATION</th>
                <th style="width:8%;">RATE</th>
                <th style="width:5%;">QTY</th>
                <th style="width:8%;">VALUE</th>
                <th style="width:8%;">GST RATE</th>
                <th style="width:8%;">GST AMOUNT</th>
                <th style="width:8%;">VALUE INCL ST</th>
                <th style="width:8%;">DISCOUNT</th>
                <th style="width:8%;">O.DISCOUNT</th>
                <th style="width:8%;">WH AMOUNT</th>
                <th style="width:10%;">FINAL VALUE</th>
                <th style="width:8%;">DESCRIPTION</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $SNo = 1; 
              $Quantity = 0;
              $Amount = 0;
              $GstAmount = 0;
              $ValueInclGst = 0;
              $Discount = 0;
              $ODiscount = 0;
              $HoldingAmount = 0;
              $NetAmount = 0;
              
              foreach($PurchaseDetail as $Record) {
              ?>
              <tr>                 
                <td><?php echo $SNo; ?></td>
                <td style='text-align:left;'><?php echo $Record["ProductName"];?></td>
                <td><?php echo ($Record["LocationName"]); ?></td>
                <td style='text-align:right;'><?php echo number_format($Record["Rate"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["Quantity"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["Amount"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["DiscountAmount"],2);?>%</td>
                <td style='text-align:right;'><?php echo number_format($Record["RegularDiscount"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["SaleDiscount"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["Discount"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["ODiscount"],2);?></td>
                <td style='text-align:right;'><?php echo number_format($Record["HoldingAmount"],2);?></td>
                <td style='text-align:right;' class="final-value"><?php echo number_format($Record["NetAmount"],2);?></td>
                <td style='text-align:left;'><?php echo $Record["Comments"];?></td>
              </tr>
              <?php
                $SNo++; 
                $Quantity += $Record['Quantity'];
                $Amount += $Record['Amount'];
                $GstAmount += $Record['RegularDiscount'];
                $ValueInclGst += $Record['SaleDiscount'];
                $Discount += $Record['Discount'];
                $ODiscount += $Record['ODiscount'];
                $HoldingAmount += $Record['HoldingAmount'];
                $NetAmount += $Record['NetAmount'];
              }
              ?>
              
              <!-- Totals Row -->
              <tr class="total-row">
                <td colspan="4" style="text-align: right; font-weight: bold;">TOTALS:</td>
                <td style='text-align:right;'><?php echo number_format($Quantity,2);?></td>
                <td style='text-align:right;'><?php echo number_format($Amount,2);?></td>
                <td>-</td>
                <td style='text-align:right;'><?php echo number_format($GstAmount,2);?></td>
                <td style='text-align:right;'><?php echo number_format($ValueInclGst,2);?></td>
                <td style='text-align:right;'><?php echo number_format($Discount,2);?></td>
                <td style='text-align:right;'><?php echo number_format($ODiscount,2);?></td>
                <td style='text-align:right;'><?php echo number_format($HoldingAmount,2);?></td>
                <td style='text-align:right;' class="final-value"><?php echo number_format($NetAmount,2);?></td>
                <td>-</td>
              </tr>
            </tbody>
          </table>

          <div style="height: 30px;"></div>
          
          <table class="table" border="0">
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

<div class="col-md-12">
  <div class="info-card" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; padding: 20px; margin: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
    <div class="row">
      <div class="col-sm-6">
        <div class="info-item" style="display: flex; align-items: center; margin-bottom: 15px;">
          <div style="background: #17a2b8; color: white; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
            <i class="fa fa-user"></i>
          </div>
          <div>
            <strong style="color: #495057; font-size: 14px;">ADDED BY</strong><br>
            <span style="color: #17a2b8; font-weight: 600; font-size: 16px;"><?php echo $this->session->userdata('EmployeeName'); ?></span>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="info-item" style="display: flex; align-items: center; margin-bottom: 15px;">

          </div>
          <div>

    </div>
  </div>
</div>
				 
<div class="box-footer" style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">
  <div class="col-md-12">
    <div class="row" style="display: flex; align-items: center;">
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Purchase/AddPurchase" class="btn btn-block" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 10px; font-weight: 600; transition: all 0.3s ease;">
          <i class="fa fa-plus-circle"></i>&nbsp; Add New
        </a>
      </div>   
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Purchase/" class="btn btn-block" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); color: white; border: none; border-radius: 6px; padding: 10px; font-weight: 600; transition: all 0.3s ease;">
          <i class="fa fa-home"></i>&nbsp; Back to Main
        </a>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Purchase/EditPurchase/<?php echo $Purchases->PurchaseId; ?>" class="btn btn-block" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 6px; padding: 10px; font-weight: 600; transition: all 0.3s ease;">
          <i class="fa fa-edit"></i>&nbsp; Edit
        </a>
      </div>
      <div class="col-md-6 text-right">

        </a>
        <a href="#" class="btn" id="generate_purchaseinvoice_report" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #212529; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600; transition: all 0.3s ease;">
          <i class="fa fa-print"></i>&nbsp; Print
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }
  .info-item:hover {
    transform: translateX(5px);
    transition: transform 0.3s ease;
  }
</style>
</section>
</div>
  
<?php $this->load->view("includes/footer"); ?>
<script>

     $(function(){
      $("body").on("click","#generate_purchaseinvoice_report",function(){
      
  var PNo = $("#PNo").text();

      window.open("<?php echo site_url(); ?>PurchaseReports/PurchaseInvoiceReport?PNo="+PNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>