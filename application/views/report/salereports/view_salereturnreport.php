<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
        <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js">
    $(function(){
      $('#functionName').text( $('#functionName').text().replace(/([A-Z])/g, " ") );
    })
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
<style type="text/css">

@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <div class="box box-info">
        <div class="col-md-12 col-xs-12">
          <div class="col-xs-2 col-sm-2">
              <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-circle">
          </div>
          <div class="col-xs-8 col-sm-8">
            <h2 style="color:black; font-family:Calibri; font-weight:600;margin-left: 1%; margin-top: 30px;" class="box-title text-center"><?php echo $GetSettingInformation[0]['CompanyName']; // $this->session->userdata('CompanyName'); ?></h2>
          </div>
        </div>
    <br><br>
      <h3 style="color:green;text-align: center;" id="functionName">
        <?php $FunctionName = $this->uri->segment(2);
//          $FunctionName = 'CodexWorldWebsite';
          $WithSpace = preg_replace('/(?<!\ )[A-Z]/', ' $0', $FunctionName);
          echo $WithSpace;
          ?>
        </h3>
      
      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' &nbsp; - &nbsp;  '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>
        <span class="pull-right no-print" style="font-size:13px; font-family: Arial, Helvetica, sans-serif; margin-top: -100px"><a href="#" class="" id="SendMail" data-toggle="modal" data-target="#myModal" style="color:green">Email</a> &nbsp; &nbsp;<a href="#" style="color:green" onclick="window.print();">Print</a> &nbsp; &nbsp;
        <span class="dropdown pull-left">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color:green">Export<span class="caret"></a> &nbsp;
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url() ?>Export/ExportExcelSaleReturnDetailReport?StartDate=<?php echo $this->input->get('StartDate') ?>&EndDate=<?php echo $this->input->get('EndDate'); ?>&CustomerId=<?php echo $this->input->get('CustomerId'); ?>&ReferenceId=<?php echo $this->input->get('ReferenceId'); ?>&ProductId=<?php echo $this->input->get('ProductId'); ?>&LocationId=<?php echo $this->input->get('LocationId'); ?>&SaleType=<?php echo $this->input->get('SaleType'); ?>&SaleMethod=<?php echo $this->input->get('SaleMethod'); ?>&ColourId=<?php echo $this->input->get('ColourId'); ?>&CategoryId=<?php echo $this->input->get('CategoryId'); ?>&ProductGroupId=<?php echo $this->input->get('ProductGroupId'); ?>&BrandId=<?php echo $this->input->get('BrandId'); ?>">Excel</a></li>
<!--          <li><a href="<?php // echo base_url()?>Export/ExportWordSaleReturnDetailReport?StartDate=<?php // echo $this->input->get('StartDate') ?>&EndDate=<?php // echo $this->input->get('EndDate'); ?>&CustomerId=<?php // echo $this->input->get('CustomerId'); ?>&ReferenceId=<?php // echo $this->input->get('ReferenceId'); ?>&ProductId=<?php // echo $this->input->get('ProductId'); ?>&LocationId=<?php // echo $this->input->get('LocationId'); ?>&SaleType=<?php // echo $this->input->get('SaleType'); ?>&SaleMethod=<?php // echo $this->input->get('SaleMethod'); ?>&ColourId=<?php // echo $this->input->get('ColourId'); ?>&CategoryId=<?php // echo $this->input->get('CategoryId'); ?>&ProductGroupId=<?php // echo $this->input->get('ProductGroupId'); ?>&BrandId=<?php // echo $this->input->get('BrandId'); ?>">Word</a></li> -->
</ul>
          </span> &nbsp; </span>
      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
      <!--  <button class="pull-right" type="button" id="SendMail" data-toggle="modal" data-target="#myModal">Send as Email</button> -->
           </div>
       <div style="height:30px;"></div>
            <table class="table table-bordered" id="table">
              <thead>
                <?php
/**                  if (!$AllSalesReturn) {
                  echo "<p class = 'alert alert-info'> No record found </p>";
                }
                else{ **/
                 ?>
                  <tr style="background:#205081; font-size:0.75em; color:#FFFFFF;" class="">
                    <th style="">S.No</th>
                    <th style="text-align:center;">Date</th>
                    <th style="text-align:left;">Product Name</th>
                    <th style="text-align:left;">Colour</th>
                    <th style="text-align:left;">Location</th>
                    <th style="text-align:left;">Brand</th>
                    <th style="text-align:left;">Product Group</th>
                    <th style="text-align:left;">Category</th>
                    <th style="text-align:left;">Customer Name</th>
                    <th style="text-align:left;">Transportation</th>
                    <th style="text-align:center;">Sale Return Type</th>
                    <th style="text-align:center;">Rate</th>
                    <th style="text-align:center;">Quantity</th>
                    <th style="text-align:center;">Amount</th>
                    <th style="text-align:center;">Discount</th>
                    <th style="text-align:center;">Tax Amount</th>
                    <th style="text-align:center;">Net Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $SNo = 0;
                $Amount = 0;
                $NetQuantity = 0;
                $DiscountAmount = 0;
                $TaxAmount = 0;
                $NetAmount = 0;

                foreach ($AllSalesReturn as $AllSalesRecord) {
                $SNo++;

                $SaleReturnType = "";
                  if($AllSalesRecord['SaleReturnType'] == "1"){
                    $SaleReturnType = "On Cash";
                  }
                  if($AllSalesRecord['SaleReturnType'] == "2"){
                    $SaleReturnType = "On Credit";
                  }
                  if($AllSalesRecord['SaleReturnType'] == "3"){
                    $SaleReturnType = "Online";
                  }

                  ?>
                <tr class="gradeU" style="background-color: #fFffff;font-size:0.75em;">
                  <td style="text-align:center;"><?php echo $AllSalesRecord['SaleReturnId']; ?></td>
                  <td style="text-align:center;"><?php echo date('M d, Y', strtotime($AllSalesRecord['SaleReturnDate'])); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ProductName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ColourName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['LocationName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['BrandName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['ProductGroupName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['CategoryName']); ?></td>
                  <td style="text-align:left;"><?php echo ($AllSalesRecord['CustomerName']); ?></td>
                  <td style="text-align:left;"><?php echo $AllSalesRecord['FullName'] == "" ? '--' : $AllSalesRecord['FullName']; ?></td>
                  <td style="text-align:center;"><?php echo $SaleReturnType; ?></td>
                  <td style="text-align:center;"><?php echo ($AllSalesRecord['Rate']); ?></td>
                  <td style="text-align:right;"><?php echo ($AllSalesRecord['Quantity']); ?></td>
                  <td style="text-align:right;"><?php echo ($AllSalesRecord['Amount']); ?></td>
                  <td style="text-align:right;"><?php echo ($AllSalesRecord['DiscountAmount']); ?></td>
                  <td style="text-align:right;"><?php echo ($AllSalesRecord['TaxAmount']); ?></td>
                  <td style="text-align:right;"><?php echo ($AllSalesRecord['NetAmount']); ?></td>
                </tr>
                <?php
                  $NetQuantity += $AllSalesRecord['Quantity'];
                  $Amount += $AllSalesRecord['Amount'];
                  $DiscountAmount += $AllSalesRecord['DiscountAmount'];
                  $TaxAmount += $AllSalesRecord['TaxAmount'];
                  $NetAmount += $AllSalesRecord['NetAmount'];
              }
                ?>
                  <tr>             
                    <td colspan="12" style="text-align:right; font-weight: 600; font-size: 13px;">Total:</td>
                    <td style="text-align:right; font-weight:600; font-size: 13px;"><?php echo number_format($NetQuantity,2); ?></td>
                    <td style="text-align:right; font-weight:600; font-size: 13px;"><?php echo number_format($Amount,2); ?></td>
                    <td style="text-align:right; font-weight:600; font-size: 13px;"><?php echo number_format($DiscountAmount,2); ?></td>
                    <td style="text-align:right; font-weight:600; font-size: 13px;"><?php echo number_format($TaxAmount,2); ?></td>
                    <td style="text-align:right; font-weight:600; font-size: 13px;"><?php echo number_format($NetAmount,2); ?></td>
                  </tr>
              </tbody>
      </table>

          </div>
        </center>
        </div>
        <?php
//      }
      ?>
</body>
</html>