<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<script>
$(document).ready(function(){

  $("#SaleInvoice_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesInvoiceDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
  success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  }); 
  
  $("#SaleDetail_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SalesReports/SaleDetailReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerSaleDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CustomerSaleDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CustomerSaleSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  $("#ProductSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/ProductSaleSummaryReportCriteria",
        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  $("#SalesOrder_ProductWiseSummary_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesOrderProductWiseSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrder_ProductWiseDetail_Report").click(function(){
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesOrderProductWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesOrderSummaryReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesOrderCustomerWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#SalesOrderDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/SalesOrderDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CancelSalesOrderCustomerWiseDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CancelSalesOrderCustomerWiseDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#CustomerWise_Invoice_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CustomerWiseInvoiceReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });
  
  $("#customer_report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CustomerReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

  $("#ProductSaleDetail_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/ProductSaleDetailReportCriteria",
	beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
	success:function(result){
        $("#loader").css('display', 'none');
        $("#show_report_criteria").html(result);
    }});
  });

$("#CustomerProductSaleSummary_Report").click(function(){ 
    $.ajax({url:"<?=base_url(); ?>SalesReports/CustomerProductSaleSummaryReportCriteria",
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
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Sales Reports</h1>
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
                     <a id="SaleInvoice_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Sale Invoice Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="SaleDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>General Sale Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="ProductSaleDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Product Sale Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="ProductSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Product Sale Summary
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerSaleDetail_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Detail
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary
                     </a>
                    </div>
		    <div class="form-group">
                     <a id="CustomerProductSaleSummary_Report" style="width:100%;" class="btn btn-social btn-bitbucket">
                      <i class="fa fa-file-text-o"></i>Customer Sale Summary Product Wise
                     </a>
                    </div>  
                 </div>
               </div>
      	
		<?php //echo form_open("SalesOrder/ShowReport"); ?> 
                <div style="border:0px solid;" class="col-md-8">
                    <center>
                       <img id="loader" src="<?php echo base_url(); ?>lib/img/loader.gif" style="margin-right:35%; display:none;" />
                    </center>
                   <div id="show_report_criteria">
                    <div style="border:0px solid; width:40%; margin-left:190px;" class="box-header with-border">
                     <h3 class="box-title text-light-blue">Report Criteria</h3>
               	   </div> 
                   <div class="form-group">
                      <label style="width:24%;" for="StartDate" class="col-sm-1 control-label">Date From:</label>
		       <div class="input-group date">
			<div class="input-group-addon">
			  <i class="fa fa-calendar"></i>
			</div>               
			<input class="form-control" name="StartDate" id="datepicker1" type="text" placeholder="Enter Start Date" style="width:40%;" value="" autocomplete="off">
		       </div>                 
                   </div>
		   <div class="form-group">
                      <label style="width:24%;" for="EndDate" class="col-sm-1 control-label">Date To:</label>
		       <div class="input-group date">
			<div class="input-group-addon">
			  <i class="fa fa-calendar"></i>
			</div>
			<input class="form-control" name="EndDate" id="datepicker2" type="text" placeholder="Enter End Date" style="width:40%;" value="" autocomplete="off">
		       </div>                 
                   </div>
              	   <div class="form-group">
                     <label style="width:24%;" class="col-sm-2"></label>
                       <div class="input-group date">
                         <button type="button" id="generate_sale_detail_report" class="btn  btn-primary">Show Report</button>
                       </div>                  
                   </div>
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
      $("body").on("click","#generate_SalesInvoiceDetail_report",function(){
      var InvoiceNo = $("#InvoiceNo").val();
      
      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesInvoicelDetailReport?InvoiceNo="+InvoiceNo,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
    
    $(function(){
	$("body").on("click","#generate_customer_sale_detail_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/CustomerSaleDetailReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
  $("body").on("click","#generate_sale_detail_report",function(){
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/SaleDetailReport?StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
	$("body").on("click","#generate_customer_product_sale_summary_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/CustomerSaleSummaryProductWise?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
	$("body").on("click","#generate_customer_sale_detail_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SaleReports/CustomerSaleDetailReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });

    $(function(){
	$("body").on("click","#generate_customer_sale_summary_report",function(){
        var CustomerId = $("#CustomerId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/CustomerSaleSummaryReport?CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });
    
    $(function(){
	$("body").on("click","#generate_product_sale_detail_report",function(){
        var ProductId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/ProductSaleDetailReport?ProductId="+ProductId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });
    
    $(function(){
	$("body").on("click","#generate_product_sale_summary_report",function(){
        var ProductId = $("#ProductId").val();
        var StartDate = $("#datepicker1").val();
        var EndDate = $("#datepicker2").val();
        window.open("<?php echo site_url(); ?>SalesReports/ProductSaleSummaryReport?ProductId="+ProductId+"&StartDate="+StartDate+"&EndDate="+EndDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
    });   
    
    
    
    
    
    
    
      $(function(){
      $("body").on("click","#generate_SalesorderProductWiseSummary_report",function(){

      var InvoiceValue = $("#InvoiceValue").val();
      var CompanyId = $("#CompanyId").val();
      var ReferenceId = $("#ReferenceId").val();
      var CategoryId = $("#CategoryId").val();
      var ProductId = $("#ProductId").val();
      var DivisionId = $("#DivisionId").val();
      var DistrictId = $("#DistrictId").val();
      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();
      
      if($('#Division').is(":checked"))
      var Division = 'true'; else var Division = 'false';
  
      if($('#District').is(":checked"))
      var District = 'true'; else var District = 'false';
    
      if($('#Company').is(":checked"))
      var Company = 'true'; else var Company = 'false';
      
      if($('#Vendor').is(":checked"))
      var Vendor = 'true'; else var Vendor = 'false';
  
      if($('#SaleOrderQtyAmt').is(":checked"))
      var SaleOrderQtyAmt = 'true'; else var SaleOrderQtyAmt = 'false';
     
      if($('#SupplyQtyAmt').is(":checked"))
      var SupplyQtyAmt = 'true'; else var SupplyQtyAmt = 'false';

      if($('#BillQtyAmt').is(":checked"))
      var BillQtyAmt = 'true'; else var BillQtyAmt = 'false'; 
      
      if($('#POQtyAmt').is(":checked"))
      var POQtyAmt = 'true'; else var POQtyAmt = 'false';
  
      if($('#BalanceQtyAmt').is(":checked"))
      var BalanceQtyAmt = 'true'; else var BalanceQtyAmt = 'false';
    
      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesOrderProductWiseSummaryReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&ReferenceId="+ReferenceId+"&CategoryId="+CategoryId+"&ProductId="+ProductId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue+"&Division="+Division+"&District="+District+"&Company="+Company+"&Vendor="+Vendor+"&SaleOrderQtyAmt="+SaleOrderQtyAmt+"&SupplyQtyAmt="+SupplyQtyAmt+"&BillQtyAmt="+BillQtyAmt+"&POQtyAmt="+POQtyAmt+"&BalanceQtyAmt="+BalanceQtyAmt,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
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
    
      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesOrderProductWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&ReferenceId="+ReferenceId+"&CategoryId="+CategoryId+"&ProductId="+ProductId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
        });
      });
           
      $(function(){
      $("body").on("click","#generate_SalesOrderSummary_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesOrderSummaryReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
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

      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CategoryId="+CategoryId+"&ProductId="+ProductId+"&ReferenceId="+ReferenceId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
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


      window.open("<?php echo site_url(); ?>SalesReports/GeneratSalesOrderDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&ReferenceId="+ReferenceId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
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

      window.open("<?php echo site_url(); ?>SalesReports/GeneratCancelSalesOrderCustomerWiseDetailReport?StartDate="+SDate+"&EndDate="+EDate+"&CompanyId="+CompanyId+"&ReferenceId="+ReferenceId+"&CustomerId="+CustomerId+"&DivisionId="+DivisionId+"&DistrictId="+DistrictId,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
      
      $(function(){
      $("body").on("click","#generate_CustomerWise_Invoice_report",function(){
	  
      var CompanyId = $("#CompanyId").val();
      var CustomerId = $("#CustomerId").val();
      var InvoiceValue = $("#InvoiceValue").val();
      var StartDate = $("#datepicker1").val();
      var EndDate = $("#datepicker2").val();
      window.open("<?php echo site_url(); ?>SalesReports/GeneratCustomerWiseInvoicelReport?CompanyId="+CompanyId+"&CustomerId="+CustomerId+"&StartDate="+StartDate+"&EndDate="+EndDate+"&InvoiceValue="+InvoiceValue,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
         });
      });
     
     
     $(function(){
      $("body").on("click","#generate_customer_report",function(){

      var SDate = $("#datepicker1").val();
      var EDate = $("#datepicker2").val();

      window.open("<?php echo site_url(); ?>SalesReports/GeneratCustomerReport?StartDate="+SDate+"&EndDate="+EDate,"","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
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