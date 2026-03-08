<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-laptop"></i>&nbsp;Purchase Return</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">  
      <div class="box box-info">
        <div class="box-header with-border col-md-12">
          <h3 class="box-title text-light-blue">View Purchase Return</h3>
        </div>
        <div style="text-align:right;" class="box-header with-border col-md-12">
        </div>
          
      <div class="box-body">
        <div class="row invoice-info">
    
    <div class="col-sm-3 invoice-col" style="border:0px solid;">
      <address>
        <strong>Purchase Return #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;" id="PNo"><?php echo $Purchases->PurchaseReturnId; ?></span>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Vendor:</strong><br>
          <?php echo $Purchases->VendorName ?>
          </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Bank Account:</strong><br>
           <?php echo $Purchases->AccountTitle . " - " . $Purchases->AccountNumber;  ?>
      </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Date:</strong><br>
        <?php echo date("M d,Y", strtotime($Purchases->PurchaseReturnDate)); ?>
                  </address>
    </div>

    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Type:</strong><br>
          <?php if($Purchases->PurchaseReturnType == 1){ echo "On Cash" ; }
          else if($Purchases->PurchaseReturnType == 2){ echo "On Credit" ; }
          else if($Purchases->PurchaseReturnType == 3){ echo "Online" ; }
          else{ echo 'No Type Selected';  } ?>
        </select>
      </address>
    </div>


    <div class="col-sm-3 invoice-col">
      <address>
        <strong>Purchase Note:</strong><br>
        <?php echo $Purchases->PurchaseReturnNote; ?>
      </address>
    </div>


        </div>
    </div>
                <!-- Sales Order Detail Block -->
                <div class="row invoice-info">
                    <div class="col-sm-12 invoice-col">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="box-body pad table-responsive">
                            <table class="table table-bordered text-center" id="delTable">
                            <tr style="background-color:#ECF9FF;">
                             <th style="width:2%;">S.#</th>
                              <th style="padding:5px; width:10%; text-align: left;">Item</th>
                              <th style="padding:5px; width:10%; text-align: left;">Location</th>
                              <th style="padding:5px; width:10%; text-align: left;">Color</th>
                              <th style="padding:5px; width:10%;">Rate</th>
                              <th style="padding:5px; width:5%;">Qty</th>
                              <th style="padding:5px; width:10%;">Amount</th>
                              <th style="padding:5px; width:10%;">Dis: Amt</th>
                              <th style="padding:5px; width:10%;">Net Amount</th>
                              <th style="padding:5px; width:20%; text-align: left;">Comments</th>
                            </tr>
                          <?php
                            $SNo = 1; 
                            $Quantity = 0;
                            $Amount = 0;
                            $DiscountAmount = 0;
                            $NetAmount = 0;
                              foreach($PurchaseDetail as $Record) {
                            ?>
                            <tr class="txtMult">                 
                              <td style="padding:5px;"><?php echo $SNo; ?></td>
                              <td style='padding:5px; width:15%; text-align:left;'><?php echo $Record["ProductName"];?></td>
                  			      <td style='padding:5px; width:8%; text-align:right;'><?php echo ($Record["LocationName"]); ?></td>
                  			      <td style='padding:5px; width:12%; text-align:right;'><?php echo $Record["ColourName"];?></td>
                  			      <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Rate"],2);?></td>
                              <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Quantity"],2);?></td>
                              <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Amount"],2);?></td>
                              <td style='padding:5px; width:7%; text-align:right;'><?php echo number_format($Record["DiscountAmount"],2);?></td>
                              <td style='padding:5px; text-align:right;'><?php echo number_format($Record["NetAmount"],2);?></td>
			                        <td style='padding:5px; text-align:right;'><?php echo $Record["Comments"];?></td>
                            </tr>
                              <?php
                                  $SNo++; 
                                  $Quantity += $Record['Quantity'];
                                  $Amount += $Record['Amount'];
                                  $DiscountAmount += $Record['DiscountAmount'];
                                  $NetAmount += $Record['NetAmount'];
                              }
                              ?>

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
          <td colspan="12" style="width: 90%; text-align:right; font-weight:600; border: 0px solid;">Total Net Amount:</td>
          <td><div id="NetAmount" style='font-weight:600; text-align:right; color:#008000;'><?php echo number_format($NetAmount,2,'.',''); ?></div></td>
        </tr>



        </tbody>
       </table>

                          </div>
                        </div>
                      </div>
                  </div>
                </div>
				 
	      <div class="box-footer">
              <div class="col-md-12">
               <div class="row">
		<div class="col-md-2">
		   <a href="<?php echo base_url(); ?>PurchaseReturn/AddPurchaseReturn" class="btn btn-block btn-primary">Add Record</a>
                </div>   
                <div class="col-md-2">
                  <a href="<?php echo base_url(); ?>PurchaseReturn/"><button type="button" namue="BackToMain" value="BackToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
				<div class="col-md-8">
                  <a href="javascript:void(0)" class="btn btn-default pull-right" id="generate_purchasereturn_report" onclick=PrintElem()><i class="fa fa-print"></i>&nbsp;Print</a>
                </div>
               </div>
              </div>
              </div>
	    </div>
    </section>
  </div>
  
<?php $this->load->view("includes/footer"); ?>
<script>

     $(function(){
      $("body").on("click","#generate_purchasereturn_report___",function(){
      
  var PNo = $("#PNo").text();
  
      window.open("<?php echo site_url(); ?>PurchaseReports/PurchaseInvoiceReport?PNo="+PNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    </script>

<script>	
	function PrintElem()
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title> Print </title>');
    mywindow.document.write('</head><body >');
//    mywindow.document.write('<h1> PRINT </h1>');
    mywindow.document.write(document.getElementByClass('content-wrapper').innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>