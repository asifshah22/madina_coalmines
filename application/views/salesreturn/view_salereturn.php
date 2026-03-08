<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

      <!-- /.main-content starts -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Sales Return</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Sales Return Details</h3>
            </div>
      <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
      
            <form role="form" id="SaleOrderForm" action='<?php echo base_url("SalesReturn/SaveSale") ?>' method="post">
      
      <div class="box-body">
        <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Return #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;" id="SNo"><?= $SalesReturn->SaleReturnId; ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Return Type:</strong><br>
        <?php 
          if($SalesReturn->SaleReturnType == "1"){ echo "On Cash"; }
          if($SalesReturn->SaleReturnType == "2"){ echo "On Credit"; }
          if($SalesReturn->SaleReturnType == "3"){ echo "Online"; }
        ?>
      </address>
    </div>

       <div class="col-sm-3 invoice-col">
      <address>
        <strong>Customer:</strong><br>
       <?php echo $SalesReturn->CustomerName; ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Bank Account:</strong><br>
         <?php echo $SalesReturn->AccountTitle . " - " . $SalesReturn->AccountNumber;  ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Transportation:</strong><br>
       <?php echo $SalesReturn->FullName; ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Return Date:</strong><br>
        <?php echo date('M d, Y',strtotime($SalesReturn->SaleReturnDate)); ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Sale Return Note:</strong><br>
        <?php echo $SalesReturn->SaleReturnNote; ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Saleman:</strong><br>
        <?php echo $SalesReturn->SalemanName; ?>
      </address>
    </div>

    <div class="col-sm-6 invoice-col">
      <address>
        <div style="font-weight:600;" class="col-sm-8" id="AccountReceivable"></div>
      </address>
    </div>    
        </div>             

    <table class='table table-bordered text-center' id="SaleReturn_EntriesTable">
    <thead>
    <tr style="background-color:#ECF9FF;">
    <th style="width:2%;">S.#</th>
    <th style="padding:5px; width:10%; text-align: left;">Item</th>
    <th style="padding:5px; width:10%; text-align: left;">Location</th>
    <!-- <th style="padding:5px; width:10%; text-align: left;">Color</th> -->
    <th style="padding:5px; width:10%;">Rate</th>
    <th style="padding:5px; width:5%;">Qty</th>
    <th style="padding:5px; width:10%;">Amount</th>
    <th style="padding:5px; width:10%;">Dis: Amt</th>
    <th style="padding:5px; width:10%;">Tax Percentage</th>
    <th style="padding:5px; width:10%;">Tax Amount</th>
    <th style="padding:5px; width:10%;">Net Amount</th>
         </tr>
               </thead>
         <?php 
          $SNo = 1; 
          $Quantity = 0;
          $Amount = 0;
          $DiscountAmount = 0;
          $TaxAmount = 0;
          $NetAmount = 0;
          foreach($SalesReturnDetail as $Record) {
         ?>
         <tr>
            <td style="text-align:center;"><?php echo $SNo; ?></td>
            <td style="text-align:left;"><?php echo $Record['ProductName'];?></td>
            <td style="text-align:left;"><?php echo $Record['LocationName'];?></td>
            <!-- <td style="text-align:left;"><?php //echo $Record['ColourName'];?></td> -->
            <td style="text-align:center;"><?php echo $Record['Rate'];?></td>
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
          <td><div id="DiscountAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($DiscountAmount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Tax Amount:</td>
          <td><div id="TaxAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($TaxAmount,2,'.',''); ?></div></td>
        </tr>

        <tr>
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="NetAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
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
                    <?php echo date('M d, Y', strtotime($SalesReturn->AddedOn)); ?>
                  </address>
                </div>
        </div>

           </div>        
        </form>
		
		             <div class="col-md-12">&nbsp;</div>
        
        <div class="box-footer">
	  <div class="col-md-12">
	<a href="<?php echo base_url(); ?>SalesReturn/AddSalesReturn"><button type="button" name="cancelForm" class="btn btn-block btn-primary" style="color:white; margin-right:5px;">Add Record</button></a>
	<a href="<?php echo base_url(); ?>SalesReturn/"><button type="button" name="cancelForm" class="btn btn-block btn-primary" style="color:white; margin-right:5px;">Back to Main</button></a>
    <a href="javascript:void(0)" class="btn btn-danger pull-right" id="generate_saleinvoice_report"><i class="fa fa-print"></i>&nbsp;POS Print</a>
    
      </div>
    </div>
        </div>
            </div>
        </div>
  </section>
      </div>
   

<?php $this->load->view('includes/footer'); ?>
<script>

     $(function(){
      $("body").on("click","#generate_saleinvoice_report",function(){
      
  var InvoiceNo = $("#SNo").text();
  
      window.open("<?php echo site_url(); ?>SaleReports/ViewSaleReturnInvoiceReport?InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>
    
<script>

//      $(function(){
//       $("body").on("click","#generate_salereturn_report",function(){
      
//   var InvoiceNo = $("#SNo").text();
  
//      window.open("<?php echo site_url(); ?>SaleReports/ViewSaleInvoiceReport?InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");

// 	$(".content-wrapper").print();

//         });
//       });
    </script>