<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

//      $("#show_report_criteria").load('PurchaseReports/PurchaseDetailReportCriteria');

     $.ajax({url:"<?=base_url(); ?>PurchaseReports/PurchaseDetailReportCriteria",
  beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
     }});


 $("#PurchaseDetail_Report").click(function(){ 
     $.ajax({url:"<?=base_url(); ?>PurchaseReports/PurchaseDetailReportCriteria",
  beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
     }});
  });


  $("#PurchaseReturnDetail_Report").click(function(){ 
     $.ajax({url:"<?=base_url(); ?>PurchaseReports/PurchaseReturnReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
     }});
  }); 

  $("#PurchaseInvoiceDetail_Report").click(function(){ 
     $.ajax({url:"<?=base_url(); ?>PurchaseReports/PurchaseInvoiceDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
     }});
  });


});
</script>
                
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Purchases Reports</h1>
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
 
                   <!-- <div class="form-group">
          	      <a id="Vendor_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Vendor Report
                     </a>
                    </div>
                    <div class="form-group">
                      <a id="PurchaseOrderDetail_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Purchase Order Vendor Wise Detail
                      </a>
                    </div>
		    <div class="form-group">
                      <a id="VendorLedger_Report" style="width:80%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Vendor Ledger
                      </a>
                    </div>
		   -->
		    <div class="form-group">
                      <a id="PurchaseDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket"><i class="fa fa-file-text-o"></i>
			General Purchase Detail</a>
                    </div>
		   <div class="form-group">
                      <a id="PurchaseReturnDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket"><i class="fa fa-file-text-o"></i>
                        Purchase Return Detail
                      </a>
                    </div>

       <div class="form-group">
                      <a id="PurchaseInvoiceDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket"><i class="fa fa-file-text-o"></i>
                        Purchase Invoice
                      </a>
                    </div>

<!-- 		    <div class="form-group">
                      <a id="ProductPurchaseSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket"><i class="fa fa-file-text-o"></i>
                        Product Purchase Summary
                      </a>
                    </div>
		   
		   <div class="form-group">
                      <a id="SupplierPurchaseDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Supplier Purchase Detail
                      </a>
                    </div>
		  
		    <div class="form-group">
                      <a id="SupplierPurchaseSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Supplier Purchase Summery
                      </a>
                    </div>
		    
        <div class="form-group">
                      <a id="PurchaseProductSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Purchase Summary Product Wise
                      </a>
                    </div>

        <div class="form-group">
                      <a id="FinishedProduct_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                        <i class="fa fa-file-text-o"></i>Finished Products
                      </a>
                    </div>
                   
      	 -->
                 </div>
               </div>
	         <div class="col-md-8">
                    <center>
                        <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="margin-right: 35%; display: none;" />
                    </center>
                <div id="show_report_criteria">
                 
                  
                </div>
            </div>
            <!-- /.col -->
          </div>    
        </div>
      <!-- /.box-body -->
      </div>
      <!-- /.box-info -->
       </div>
    </section>
    <!-- /.content -->    
    
  </div>
  <!-- /.content-wrapper -->
 <script>	 
      $(function(){

      $("body").on("click","#generate_SupplierPurchaseDetail_report",function(){

      var VendorId = $("#VendorId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>PurchaseReports/SupplierPurchaseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&VendorId="+VendorId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      
      $(function(){
      $("body").on("click","#generate_purchase_detail_report",function(){
        
        var VendorId = $('#VendorId').val();
        var ProductId = $('#ProductId').val();
        var LocationId = $('#LocationId').val();
        var PurchaseType = $('#PurchaseType').val();
        var ColourId = $('#ColourId').val();
        var CategoryId = $('#CategoryId').val();
        var ProductGroupId = $('#ProductGroupId').val();
        var BrandId = $('#BrandId').val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();

        window.open("<?php echo site_url(); ?>PurchaseReports/PurchaseReport?StartDate="+StartDate+"&EndDate="+EndDate+"&VendorId="+VendorId+"&ProductId="+ProductId+"&LocationId="+LocationId+"&PurchaseType="+PurchaseType+"&ColourId="+ColourId+"&CategoryId="+CategoryId+"&ProductGroupId="+ProductGroupId+"&BrandId="+BrandId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      


      $(function(){
      $("body").on("click","#generate_purchase_return_report",function(){

        var VendorId = $('#VendorId').val();
        var ProductId = $('#ProductId').val();
        var LocationId = $('#LocationId').val();
        var PurchaseType = $('#PurchaseType').val();
        var ColourId = $('#ColourId').val();
        var CategoryId = $('#CategoryId').val();
        var ProductGroupId = $('#ProductGroupId').val();
        var BrandId = $('#BrandId').val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();

        window.open("<?php echo site_url(); ?>PurchaseReports/PurchaseReturnReport?StartDate="+StartDate+"&EndDate="+EndDate+"&VendorId="+VendorId+"&ProductId="+ProductId+"&LocationId="+LocationId+"&PurchaseType="+PurchaseType+"&ColourId="+ColourId+"&CategoryId="+CategoryId+"&ProductGroupId="+ProductGroupId+"&BrandId="+BrandId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_ProductPurchaseSummary_report",function(){

      var ProductId = $("#ProductId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>PurchaseReports/ProductPurchaseSummaryReport?StartDate="+SDate+"&EndDate="+EDate+"&ProductId="+ProductId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_PurchaseProductSummary_report",function(){

      var VendorId = $("#VendorId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>PurchaseReports/ProductPurchaseSummarySupplierWise?StartDate="+SDate+"&EndDate="+EDate+"&VendorId="+VendorId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_FinishedProduct_report",function(){

      var ProductId = $("#ProductId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>PurchaseReports/FinishedProductReport?StartDate="+SDate+"&EndDate="+EDate+"&ProductId="+ProductId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

     $(function(){
      $("body").on("click","#generate_purchaseinvoice_report",function(){
      
      var PNo = $("#InvoiceNo").val();
  
      window.open("<?php echo site_url(); ?>PurchaseReports/PurchaseInvoiceReport?PNo="+PNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });

 </script>
 <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
    </div>
    <!-- Default to the left -->
  </footer>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>