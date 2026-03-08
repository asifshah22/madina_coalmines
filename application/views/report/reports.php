<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

  $("#product_report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/ProductReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
 
  $("#company_report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/CompanyReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
   $("#customer_report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/CustomerReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
   $("#salesorder_productwise_report").click(function(){
    $.ajax({url:"<?=base_url(); ?>Reports/SalesOrderProductwiseReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#SalesOrderSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/SalesOrderSummaryReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
   $("#PurchaseOrderDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/PurchaseOrderDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/SalesOrderCustomerWiseDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/SalesOrderDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#CancelSalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/CancelSalesOrderCustomerWiseDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#SalesInvoice_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/SalesInvoiceReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#SalesInvoiceDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/SalesInvoiceDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  $("#InventoryStock_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/InventoryStockReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  $("#StockReport_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/StockReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
   $("#ProductStockDetailReport_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/ProductStockDetailReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#LedgerReport_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>Reports/LedgerReportCriteria",
	  success:function(result){
      $("#show_report_criteria").html(result);
    }});
  });

});

</script>
                
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Inventory Reports</h1>
    </section>
    
  <!-- Main content -->
    <section class="content">
     <!-- <div class="row">-->
        
       <div class="box box-info">
         <div class="box-body">
           <div class="row">
             <div class="col-md-12">
               
               <div style="border:0px solid;" class="col-md-4">	
                 <div class="box-header with-border">
                    
                    <div class="form-group">
          		      <a id="product_report" style="width:80%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Products
                      </a>
                    </div>
                    
                     <div class="form-group">
          		     <a id="company_report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Company
                     </a>
                    </div>
                     
                     <div class="form-group">
          		     <a id="customer_report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Customer
                     </a>
                    </div>
                     
                     <div class="form-group">
          	       <a id="salesorder_productwise_report" style="width:80%;" class="btn btn-social btn-bitbucket">
                       <i class="fa fa-file-text-o"></i>Sales Order Product Wise
                       </a>
                     </div>
                     
                     <div class="form-group">
          	       <a id="SalesOrderSummary_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                       <i class="fa fa-file-text-o"></i>Sales Order Summary
                       </a>
                     </div>
                     
                    <div class="form-group">
                    <a id="PurchaseOrderDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Purchase Order Vendor Wise Detail
                     </a>
                    </div>
            
                    <div class="form-group">
                    <a id="SalesOrderCustomerWiseDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Sales Order Customer Wise Detail Two
                     </a>
                    </div>
                     
                    <div class="form-group">
                    <a id="SalesOrderDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Sales Order Customer Wise Detail
                     </a>
                    </div>
                    
                    <div class="form-group">
                    <a id="CancelSalesOrderCustomerWiseDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Cancel Sales Order Customer Wise Detail
                     </a>
                    </div>
                    
                    <div class="form-group">
                    <a id="SalesInvoice_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Sales Invoice
                     </a>
                    </div>
                     
                    <div class="form-group">
                    <a id="SalesInvoiceDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Sales Invoice Detail
                     </a>
                    </div>
                     
                    <div class="form-group">
                    <a id="InventoryStock_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Inventory Stock Report
                     </a>
                    </div>
                    
                    <div class="form-group">
                    <a id="StockReport_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Product Stock Status
                     </a>
                    </div>
                     
                    <div class="form-group">
                    <a id="ProductStockDetailReport_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Product Stock Detail
                     </a>
                    </div>                     
                     
                     <div class="form-group">
                    <a id="LedgerReport_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                     <i class="fa fa-file-text-o"></i>Ledger Report
                     </a>
                    </div> 
        
                    </div>
      		   </div>
      	
		<?php //echo form_open("SalesOrder/ShowReport"); ?> 
                <div style="border:0px solid;" class="col-md-8">
                 <div id="show_report_criteria">
                   
                   <div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
                   <h3 class="box-title text-light-blue">Products Reports</h3>
               	   </div>                    
                   
                   <div class="form-group">
                     <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">Start Range:</label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>                  
        		 <input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="">
                       </div>                  
                   </div>
              
                   <div class="form-group">
                     <label style="width:24%;" for="OrderDate" class="col-sm-1 control-label">End Range:</label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>     
                         <input class="form-control" name="OrderDate" id="datepicker2" type="text" placeholder="Enter Start Date" style="width:40%;" value="">
                	   </div>                  
              	   </div>
                     
               
              	   <div class="form-group">
                     <label style="width:24%;" class="col-sm-2"></label>
                       <div class="input-group date">
                         <button type="button" id="generate_product_report" class="btn  btn-primary">Show Report</button>
                       </div>                  
                   </div> 
                 
                 </div>
                 <?php  // echo form_close(); ?> 
                <div id="dialog"></div>
              </div>
            <!-- /.col -->
          </div>    
        <!-- /.row -->
        </div>
      <!-- /.box-body -->
      </div>
      <!-- /.box-info -->
    </section>
    <!-- /.content -->    
    
  </div>
  <!-- /.content-wrapper -->

	<script>

      $(function(){
      $("body").on("click","#generate_company_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratCompanyReport?StartDate="+SDate+"&EndDate="+EDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });


     $(function(){
      $("body").on("click","#generate_customer_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratCustomerReport?StartDate="+SDate+"&EndDate="+EDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_SalesorderProductWiseDetail_report",function(){

      var InvoiceValue = $("#InvoiceValue").val();
      var ProductId = $("#ProductId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratSalesOrderProductWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&ProductId="+ProductId+"&InvoiceValue="+InvoiceValue,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
     
      
      $(function(){
      $("body").on("click","#generate_SalesOrderSummary_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratSalesOrderSummaryReport?StartDate="+SDate+"&EndDate="+EDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_PurchaseOrderDetail_report",function(){

      var VendorId = $("#VendorId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratPurchaseOrderDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&VendorId="+VendorId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_SalesOrderCustomerWiseDetail_report",function(){

      var InvoiceValue = $("#InvoiceValue").val();
      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_SalesOrderDetail_report",function(){

      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratSalesOrderDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_CancelSalesOrderCustomerWiseDetail_report",function(){

      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>Reports/GeneratCancelSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_SalesInvoice_report",function(){
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();
      window.open("<?php echo site_url(); ?>Reports/GeneratSalesInvoicelReport?StartDate="+SDate+"&EndDate="+EDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_SalesInvoiceDetail_report",function(){
      var InvoiceNo = $("#InvoiceNo").val();
      
      if ($('#CompanyWarranty').is(":checked"))
      var CompanyWarranty = 'true'; else var CompanyWarranty = 'false';
  
      if ($('#InvoiceDate').is(":checked"))
      var InvoiceDate = 'true'; else var InvoiceDate = 'false';
  
      if ($('#ProductName').is(":checked"))
      var ProductName = 'true'; else var ProductName = 'false';
     
      if ($('#Batch').is(":checked"))
      var Batch = 'true'; else var Batch = 'false';

      if ($('#MfgDate').is(":checked"))
      var MfgDate = 'true'; else var MfgDate = 'false'; 
      
      if ($('#ExpiryDate').is(":checked"))
      var ExpiryDate = 'true'; else var ExpiryDate = 'false';
  
      if ($('#DCReport').is(":checked"))
      var DCReport = 'true'; else var DCReport = 'false';
  
      if ($('#MfgName').is(":checked"))
      var MfgName = 'true'; else var MfgName = 'false';
  
      window.open("<?php echo site_url(); ?>Reports/GeneratSalesInvoicelDetailReport?InvoiceNo="+InvoiceNo+"&CompanyWarranty="+CompanyWarranty+"&InvoiceDate="+InvoiceDate+"&ProductName="+ProductName+"&Batch="+Batch+"&MfgDate="+MfgDate+"&ExpiryDate="+ExpiryDate+"&DCReport="+DCReport+"&MfgName="+MfgName,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
    $(function(){
      $("body").on("click","#generate_StockReport_report",function(){
        var PId = $("#ProductId").val();
        
      window.open("<?php echo site_url(); ?>Reports/GeneratStockReport?ProductId="+PId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      
    // Inventory Stock Report    
    $(function(){
      $("body").on("click","#generate_InventoryStock_report",function(){
        var PId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        
      window.open("<?php echo site_url(); ?>Reports/GeneratInventoryStockReport?ProductId="+PId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });  

      
    // Product Stock Detail Report  
    $(function(){
      $("body").on("click","#generate_ProductStockDetailReport_report",function(){
        var PId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        
      window.open("<?php echo site_url(); ?>Reports/GeneratProductStockDetailReport?ProductId="+PId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });  
      
    // ledger report 
    $(function(){
      $("body").on("click","#generate_LedgerReport_report",function(){
        var CompanyId = $("#CompanyId").val();
        var CustomerId = $("#CustomerId").val();
        var BId = $("#BankId").val();
        var BAId = $("#AccountId").val();
        var CId = $("#CategoryId").val();
        var CCId = $("#ControlCodeId").val();
        var COAId = $("#ChartOfAccountId").val();
        var SDate = $("#datepicker1").val();
        var EDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>Reports/GeneratLedgerReport?CompanyId="+CompanyId+"&StartDate="+SDate+"&EndDate="+EDate+"&BId="+BId+"&BAId="+BAId+"&CId="+CId+"&CCId="+CCId+"&COAId="+COAId+"&CustomerId="+CustomerId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
  </script> 

  <script>
 // coder for ledger report criteria
 $(function(){
     //Load bank account
     $(document).on('change','#BankId',function(){
        var Bid = $('#BankId').val(); 
        $('#AccountDiv').load("<?php echo base_url('Accounts/GetAccountByBankId')?>",
        {bankId:Bid});
     });
     
    //load Control cod
      $(document).on('change','#CategoryId',function(){
        var CatId = $('#CategoryId').val();
        $('#ControlCodeId').load("<?php echo base_url('ChartOfAccounts/ControlCode/dropdown')?>",
       {id:CatId});
     });
     
     //load chart of account
      $(document).on('change','#ControlCodeId',function(){
        var CCId = $('#ControlCodeId').val();
        $('#ChartOfAccountId').load("<?php echo base_url('ChartOfAccounts/GetChartOfAccountList/dropdown')?>",
        {id:CCId});
     });
 });
 
 
 </script>
 
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
     
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2017 <a href="#">Company Name</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading"></h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>