<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

    $.ajax({url:"<?=base_url(); ?>StockReports/StockActivityReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});


  $("#StockActivity_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>StockReports/StockActivityReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#StockBalance_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>StockReports/StockBalanceReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#StockStatus_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>StockReports/StockStatusReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  }); 
  
  $("#StockTransfer_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>StockReports/StockTransferReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#Available_Product_Price_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>StockReports/AvailableProductPriceReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
 

  $("#Product_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>StockReports/ProductReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });  

  $("#Stock_Status_Detail").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>StockReports/StockStatusDetailCriteria",
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
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Stock Reports</h1>
    </section>
    
  <!-- Main content -->
    <section class="content">
     <!-- <div class="row">-->
       <div class="box box-info">
           
         <div class="box-body">
           <div class="row">
             <div class="col-md-12">
                
               <div class="col-md-4">	
                 <div class="box-header with-border">
                    
		    <div class="form-group">
                     <a id="StockActivity_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Stock Activity Report
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="StockBalance_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Stock Balance Report
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="StockStatus_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Stock Status Report
                     </a>
                    </div>

		    <div class="form-group">
                     <a id="StockTransfer_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Stock Transfer Report
                     </a>
                    </div>
		     
		    <div class="form-group">
                     <a id="Available_Product_Price_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Stock Detail With Price Report
                     </a>
                    </div>
        
		    <div class="form-group">
                     <a id="Product_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Product Report
                     </a>
                    </div>
        <div class="form-group">
          <a id="Stock_Status_Detail" style="width:100%;" class="btn btn-social btn-bitbucket">
          <i class="fa fa-file-text-o"></i>Stock Status Detail Report
          </a>
        </div>
		    <!--
		    <div class="form-group">
                     <a id="CustomerStockActivity_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="StockTransfer_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary Product Wise
                     </a>
                    </div>   -->

                 </div>
               </div>
      	
		<?php //echo form_open("SalesOrder/ShowReport"); ?> 
                <div style="border:0px solid;" class="col-md-8">
                    <center>
                       <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="margin-right:35%; display:none;" />
                    </center>
                   <div id="show_report_criteria">



                 </div>
                 <?php  // echo form_close(); ?> 
                <div id="dialog"></div>
              </div>
            <!-- /.col -->
          </div>    
        
        </div>
      <!-- /.box-body -->
      </div>
      <!-- /.box-info -->
      </div>
      <!-- /.box-info -->
    </section>
    <!-- /.content -->    
    
  </div>
  <!-- /.content-wrapper -->
	
<script>
    
    $(function(){
	$("body").on("click","#generate_stock_activity_report",function(){
        var CompanyId = $("#CompanyId").val();
        var ProductId = $("#ProductId").val();
        var BrandId = $("#BrandId").val();
        var ProductGroupId = $("#ProductGroupId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();

        window.open("<?php echo site_url(); ?>StockReports/StockQuantityReport?ProductId="+ProductId+"&CompanyId="+CompanyId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Balance Report");

        });
    });

  $(function(){
  $("body").on("click","#generate_stock_balance_report",function(){
 var CompanyId = $("#CompanyId").val();
        var ProductId = $("#ProductId").val();
        var BrandId = $("#BrandId").val();
        var ProductGroupId = $("#ProductGroupId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();

        window.open("<?php echo site_url(); ?>StockReports/StockBalanceReport?ProductId="+ProductId+"&CompanyId="+CompanyId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Balance Report");
        });
    });
   
  $(function(){
  $("body").on("click","#generate_available_product_price_report",function(){
	  
	  var SalePrice = 0;
	  var PurchasePrice = 0;
	  var FinalPrice = 0;
	  var Specifications = 0;
	  
		if($("#SalePrice").is(':checked')){	  SalePrice = 1;	}
		if($("#PurchasePrice").is(':checked')){	  PurchasePrice = 1;	}
		if($("#FinalPrice").is(':checked')){	  FinalPrice = 1;		}
		if($("#Specifications").is(':checked')){  Specifications = 1;	}
		
	  
 var CompanyId = $("#CompanyId").val();
        var ProductId = $("#ProductId").val();
        var BrandId = $("#BrandId").val();
        var ProductGroupId = $("#ProductGroupId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();

        window.open("<?php echo site_url(); ?>StockReports/StockDetailWithPriceReport?ProductId="+ProductId+"&CompanyId="+CompanyId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StartDate="+StartDate+"&EndDate="+EndDate+"&SalePrice="+SalePrice+"PurchasePrice="+PurchasePrice+"&FinalPrice="+FinalPrice+"&Specifications="+Specifications,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Balance Report");
        });
    });

  $(function(){
  $("body").on("click","#generate_stock_status_report",function(){
      var LocationId = $("#LocationId").val();
      var ProductId = $("#ProductId").val();
      var EndDate = $("#datepicker2").val();

     window.open("<?php echo site_url(); ?>StockReports/StockStatusReport?LocationId="+LocationId+"&ProductId="+ProductId+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });




    $(function(){
	$("body").on("click","#generate_stock_transfer_report",function(){
      var LocationId = $("#LocationId").val();
      var ProductId = $("#ProductId").val();
      var ColourId = $("#ColourId").val();
      var EmployeeId = $("#EmployeeId").val();
      var StartDate = $("#datepicker1").val();
      var EndDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>StockReports/StockTransferReport?LocationId="+LocationId+"&ProductId="+ProductId+"&ColourId="+ColourId+"&EmployeeId="+EmployeeId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
	$("body").on("click","#generate_customer_sale_detail_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>StockReports/CustomerStockActivityReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
	$("body").on("click","#generate_customer_sale_summary_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>StockReports/CustomerSaleSummaryReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });
    
    $(function(){
	$("body").on("click","#generate_product_sale_detail_report",function(){
        var ProductId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>StockReports/ProductStockActivityReport?ProductId="+ProductId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });
    
    $(function(){
	$("body").on("click","#generate_product_sale_summary_report",function(){
        var ProductId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>StockReports/StockTransferReport?ProductId="+ProductId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });   
    
    
    
    
    
      
      $(function(){
      $("body").on("click","#generate_SalesorderProductWiseDetail_report",function(){

      var InvoiceValue = $("#InvoiceValue").val();
      var CompanyId = $("#CompanyId").val();
      var ReferenceId = $("#ReferenceId").val();
      var CategoryId = $("#CategoryId").val();
      var ProductId = $("#ProductId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();
    
      window.open("<?php echo site_url(); ?>StockReports/GeneratSalesOrderProductWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&ReferenceId="+ReferenceId+"&CategoryId="+CategoryId+"&ProductId="+ProductId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
           
      $(function(){
      $("body").on("click","#generate_SalesOrderSummary_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>StockReports/GeneratSalesOrderSummaryReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

      $(function(){
      $("body").on("click","#generate_SalesOrderCustomerWiseDetail_report",function(){

      var CategoryId = $("#CategoryId").val();
      var ProductId = $("#ProductId").val();
      var InvoiceValue = $("#InvoiceValue").val();
      var CompanyId = $("#CompanyId").val();
      var ReferenceId = $("#ReferenceId").val();
      var CustomerId = $("#CustomerId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>StockReports/GeneratSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CategoryId="+CategoryId+"&ProductId="+ProductId+"&ReferenceId="+ReferenceId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_SalesOrderDetail_report",function(){

      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var ReferenceId = $("#ReferenceId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();


      window.open("<?php echo site_url(); ?>StockReports/GeneratSalesOrderDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&ReferenceId="+ReferenceId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
      
      $(function(){
      $("body").on("click","#generate_CancelSalesOrderCustomerWiseDetail_report",function(){

      var CompanyId = $("#CompanyId").val();
      var ReferenceId = $("#ReferenceId").val();
      var CustomerId = $("#CustomerId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>StockReports/GeneratCancelSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&ReferenceId="+ReferenceId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_CustomerWise_Invoice_report",function(){
	  
      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var InvoiceValue = $("#InvoiceValue").val();
      var StartDate = $("#datepicker1").val();
      var EndDate = $("#datepicker2").val();
      window.open("<?php echo site_url(); ?>StockReports/GeneratCustomerWiseInvoicelReport?CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
     
     
     $(function(){
      $("body").on("click","#generate_customer_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>StockReports/GeneratCustomerReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });

  $(function(){
  $("body").on("click","#generate_product_report",function(){
    var ProductId = $("#ProductId").val();
    var BrandId = $("#BrandId").val();
    var ProductGroupId = $("#ProductGroupId").val();

    window.open("<?php echo site_url(); ?>StockReports/ProductReport?ProductId="+ProductId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Balance Report");
        });
    });

    $(function(){
    $("body").on("click","#generate_stock_status_detail",function(){
        var CategoryId = $("#CategoryId").val();
        var BrandId = $("#BrandId").val();
        var ProductGroupId = $("#ProductGroupId").val();
        var StockValue = $("#StockValue").val();

        window.open("<?php echo site_url(); ?>StockReports/StockStatusDetailReport?CategoryId="+CategoryId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StockValue="+StockValue,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Status Detail Report");
        
    
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