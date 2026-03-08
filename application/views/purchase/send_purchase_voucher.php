<link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/pos.min.css">
    
<div class="col-md-12">
      <!-- form elements --> 
  <div class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title text-light-blue">Purchase Voucher</h3>
  </div>
      <div class="box-body">
       <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          <!-- Sales Order Block --> 
            <div class="col-sm-6 invoice-col">
              <address>
                    <strong>Purchase #:</strong><br>
        <span style="color:#3333CC; font-size:13px; font-weight:bold;"><?php echo $Purchase->PurchaseNo; ?></span>
                  </address>
                </div>
                
                <div class="col-sm-6 invoice-col">
                   <address>
                    <strong>Vendor Name:</strong><br>
                      <span style="color:#800000; font-size:13px; font-weight:bold;"><?php echo $Purchase->VendorName; ?></span>
                  </address> 
                </div>

    <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Frieght Inward Charges:</strong><br>
                    <?php echo $Purchase->FrieghtInwardCharges; ?>
                  </address>
                </div>
                
                <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Transportation #:</strong><br>
        <?php echo $Purchase->TransportBuiltyNo; ?>
                  </address>
                </div>

                <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Purchase Date:</strong><br>
                    <?php echo date('M d, Y', strtotime($Purchase->PurchaseDate)); ?>
                  </address>
                </div>
               <!-- End of Sales Order Block -->               
            </div>
                <!-- Sales Order Detail Block -->
                <div class="row invoice-info">
                    <div class="col-sm-12 invoice-col">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="box-body pad table-responsive">
                            <table class="table table-bordered text-center" id="delTable">
                            <tr style="background-color:#ECF9FF;">
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
                            <tr class="txtMult">                 
                              <td style="padding:5px;"><?php echo $SNo; ?></td>
                              <td style='padding:5px; width:20%; text-align:left;'><?php echo $Record["ProductName"];?></td>
            <!-- <td style='padding:5px; width:15%; text-align:left;'><?php // echo $Record["LocationName"];?></td> -->
            <td style='padding:5px; width:8%; text-align:right;'><?php echo number_format($Record["Weight"],0);?></td>
            <td style='padding:5px; width:8%; text-align:right;'><?php echo $Record["DeductionRawMaterial"];?></td>
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
                            <tr>
            <td colspan="2"></td>
                              <td style="font-weight:600; text-align:right;"><?php echo number_format($TotalWeight,0); ?></td>
            <td colspan="7" style="text-align:right; font-weight:600;">Total Amount:</td>           
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($TotalAmount,2); ?></td>
                            </tr>
          <tr>
                              <td colspan="10" style="text-align:right; font-weight:600;">Total GST Amount:</td>
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($GSTAmount,2); ?></td>
                            </tr>
          <tr>
                              <td colspan="10" style="text-align:right; font-weight:600;">Total FED Amount:</td>
                              <td style="font-weight:600; color:#3333CC; text-align:right;"><?php echo number_format($FEDAmount,2); ?></td>
                            </tr>
                           <tr>
                            <td colspan="10" style="text-align:right; font-weight:600; width:85%;">Net Amount:</td>
                            <td style="width:12%;"><div style='font-weight:600; color:#008000; text-align:right;'><?php echo number_format($TotalNetAmount,2); ?></div></td>                         
                           </tr>
                            
                            </table>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
         
        <div class="col-md-12">&nbsp;</div>
       </div>
       <!-- /.row -->
      </div>
   </section>
    <!-- /.content -->
  </div>