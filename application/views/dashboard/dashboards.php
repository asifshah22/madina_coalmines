<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>

  <?php 
  $StartDate = date('m/01/Y');
//  $CurrentDate = $SDate."/01";
  $EndDate = date('m/d/Y');
  ?>
<style>cu
a:hover{cus
  color: blue;
}supp
#CancelledPurchases thead, tbody { display: block; }

#CancelledPurchases tbody {
    width: 100%;
    height: 300px;       /* Just for the demo          */
    overflow-y: auto;    /* Trigger vertical scroll    */
    overflow-x: hidden;  /* Hide the horizontal scroll */
}

.progress-group{margin:5% 0;}

.material-switch > input[type="checkbox"] {
    display: none;   
}

.material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
}

.material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}
.material-switch > label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}
.material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
}
.material-switch > input[type="checkbox"]:checked + label::after {
    background: inherit;
    left: 20px;
}

#secret {
            display: none;
            margin-top: 10px;
        }
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
<h1>
<td style="width:50%; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700; color:#dd4b39; letter-spacing:1px;">
    <?php 
        $company = $this->db->get('pos_setting')->row()->CompanyName;
        echo $company; 
    ?> - 
    <span style="color:#003366; font-weight:800;">FBR</span> 
    <span style="color:darkgreen; font-weight:700;">INTEGRATED</span>
</td>




        <small></small>
      </h1>
      <ol class="breadcrumb" style="padding:9px 96px">

<i class="fa fa-clock-o"></i> <span id="currentDateTime" style="font-weight: ; font-size: 15px;"></span>

<!-- JavaScript to update current date and time every second -->
<script>
    function updateDateTime() {
        var now = new Date();
        var options = { day: 'numeric', month: 'long', year: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric' };
        var dateTimeString = now.toLocaleDateString('en-US', options);
        document.getElementById('currentDateTime').textContent = dateTimeString;
    }
    // Update current date and time initially
    updateDateTime();
    // Update current date and time every second
    setInterval(updateDateTime, 1000);
</script>
<!-- Calendar icon -->
<i class="fa fa-calendar" id="calendarIcon" style="cursor: pointer; color: #007bff;"></i>

<!-- Hidden calendar -->
<div id="calendarContainer" style="display: none; position: absolute; background-color: #f8f9fa; border: 1px solid #6c757d; padding: 1px; z-index: 9999;">
    <div id="calendar" style="color: #333;"></div>
</div>

<!-- JavaScript to handle calendar display -->
<script>
    // Function to show/hide the calendar
    function toggleCalendar() {
        var calendarContainer = document.getElementById('calendarContainer');
        if (calendarContainer.style.display === 'none') {
            calendarContainer.style.display = 'block';
        } else {
            calendarContainer.style.display = 'none';
        }
    }

    // Add click event listener to the calendar icon
    document.getElementById('calendarIcon').addEventListener('click', toggleCalendar);

    // Initialize a datepicker for the calendar
    $(function () {
        $("#calendar").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            showButtonPanel: true
        });
    });
</script>
        <li><a href="#"><i class=""></i> </a></li>
        <li class="active"></li>
      </ol>
      <div class="material-switch pull-right" style="margin-top:-18px">
          <b>PRIVACY&nbsp;&nbsp;</b> 
                            <input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox"/>
                            <label for="someSwitchOptionPrimary" class="label-primary"></label>
                        </div>
    </section>
<style>
  .info-box {
      border-radius: 10px; /* Smooth rounded corners */
      transition: all 0.3s ease-in-out;
      box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
      height: 110px; /* Keeping the larger box height */
      font-family: Calibri, sans-serif; /* Applying Calibri font */
  }

  .info-box:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
  }

  .info-box-icon {
      border-radius: 10px 0 0 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 50px !important; /* Slightly increased icon size */
      width: 90px;
      height: 110px;
  }

  .info-box-content {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding-left: 12px;
  }

  .info-box-text a {
      text-decoration: none;
      font-weight: bold;
      color: #222;
      font-size: 16px; /* Reduced font size */
  }

  .info-box-number {
      font-weight: bold;
      font-size: 18px; /* Slightly smaller than before */
      color: #333;
  }
</style>



    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
	    <div class="info-box">
            <span class="info-box-icon bg-purple"><i class="fa fa-shopping-cart"></i></span>
            <div class="info-box-content">
		<span class="info-box-text"><a href="<?= base_url(); ?>Sales/AddSale">Add Sale</a></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-cart-arrow-down"></i></span>

            <div class="info-box-content">
           
	      <span class="info-box-text"><a href="<?= base_url(); ?>Purchase/AddPurchase">Add Purchase</a></span>
              <!-- <span class="info-box-number"></span>-->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
	
	 <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cubes"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><a href="<?= base_url(); ?>Product/AddProduct">Add Product</a></span>
              <!-- <span class="info-box-number"></span>-->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-exchange"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><a href="<?= base_url(); ?>StockTransfer/AddStockTransfer">Stock Transfer</a></span>
              <!-- <span class="info-box-number"></span>-->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>  	

<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-tasks"></i></span>
            <div class="info-box-content">
              <span class="info-box-text"><a href="<?= base_url(); ?>StockReports">Stock Report</a></span>
              <!-- <span class="info-box-number"></span>-->
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>  

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <!-- Custom aqua color (#39cccc) with modern sales icon -->
    <span class="info-box-icon" style="background-color: #39cccc; color: white;">
      <i class="fa fa-bar-chart"></i>
    </span>
    
    <div class="info-box-content">
      <span class="info-box-text">
        <?php $today = date('Y-m-d'); ?>
        <a target="blank" title="View Detail" href="<?php echo base_url("SaleReports/SaleDetailReport?StartDate={$today}&EndDate={$today}&CustomerId=0&ReferenceId=0&ProductId=0&LocationId=0&SaleType=0&SaleMethod=0&ColourId=undefined&CategoryId=0&ProductGroupId=0&BrandId=0"); ?>">
          Today's Sale
        </a>
      </span>

      <span class="info-box-number">
        <?php 
        // Fetch today's total sale directly from database
        $today = date('Y-m-d');
        $this->db->select_sum('TotalAmount');
        $this->db->where('DATE(SaleDate)', $today);
        $query = $this->db->get('pos_sales'); // ✅ correct table name
        $result = $query->row();

        if (!empty($result) && $result->TotalAmount > 0) {
          echo number_format($result->TotalAmount, 2);
        } else {
          echo "0.00";
        }
        ?>
      </span>
    </div>
  </div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-purple"><i class="fa fa-signal"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">
        <a target="blank" title="View Detail" href="<?php echo base_url("SaleReports/SaleDetailReport?StartDate=".date('Y-m-01')."&EndDate=".date('Y-m-t')."&CustomerId=0&ReferenceId=0&ProductId=0&LocationId=0&SaleType=0&SaleMethod=0&ColourId=undefined&CategoryId=0&ProductGroupId=0&BrandId=0"); ?>">
          This Month Sales
        </a>
      </span>
      <span class="info-box-number">
        <?php 
        if (!empty($CurrentMonthSales) && isset($CurrentMonthSales[0]['NetAmount'])) {
          echo number_format($CurrentMonthSales[0]['NetAmount'], 2);
        } else {
          echo "No Sales Yet"; // Or "0.00" if you prefer
        }
        ?>
      </span>
    </div>
  </div>
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="fa fa-area-chart"></i></span>
    <div class="info-box-content">
      <span class="info-box-text">
        <a target="blank" title="View Detail" href="<?php echo base_url("PurchaseReports/PurchaseReport?StartDate=$StartDate&EndDate=$EndDate"); ?>">
          This Month Purchases
        </a>
      </span>
      <span class="info-box-number">
        <?php echo number_format($CurrentMonthPurchase[0]['NetAmount'],2); ?>

 
    </div>
  </div>
</div>


<!--</script>-->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <!-- /.col -->
      </div>
      <!-- /.row -->

    <!---------- row second starts --------->
       <div class="row">

      </div>
            <!-- /.info-box-content -->
         
<!--</div>
        </div>
      </div> -->
      <!---------------- /.row-2 ends ----------------->

      <div class="row">
        <div class="col-md-12">
          <div class="box">
	      <div class="box-header with-border col-md-8">
		  <h3 class="box-title"><strong>Statistics</strong></h3>
                <div class="box-tools pull-right"></div>
              </div>
	     
	      <div class="box-header with-border col-md-4">
		  <h3 class="box-title"><strong>Transactional Data</strong></h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
	      
            <!-- /.box-header -->
            
<!-- QuickBooks Style Invoice and Expenses Boxes -->
<style>
/* Added hover vibration effect for all boxes */
.vibrate-box {
    transition: transform 0.3s ease;
}
.vibrate-box:hover {
    transform: scale(1.02);
    animation: vibrate 0.5s ease-in-out;
}
@keyframes vibrate {
    0%, 100% { transform: scale(1.02) translateX(0); }
    25% { transform: scale(1.02) translateX(-2px); }
    75% { transform: scale(1.02) translateX(2px); }
}
</style>

<div class="row" style="margin-top: 20px;">
    <!-- Invoices Box -->
    <div class="col-md-4">
        <!-- Added vibrate-box class for hover effect -->
        <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0;">
                <h4 style="margin: 0; color: #000; font-weight: 600;">Invoices</h4>
            </div>
            <div class="box-body" style="padding: 20px;">
                <!-- Unpaid Section -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <!-- Removed dollar signs and changed color to black -->
                        <span style="color: #000; font-size: 13px;">DUE INVOICES - This Month</span>
                        <span style="color: #000; font-size: 13px;">DUE INVOICES - Overall</span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div>
                            <!-- Removed dollar sign and changed color to black -->
                            <div style="font-size: 24px; font-weight: 600; color: #000;">00.00</div>
                            <div style="color: #000; font-size: 12px;"></div>
                        </div>
                        <div style="text-align: right;">
                            <!-- Removed dollar sign and changed color to black -->
                            <div style="font-size: 24px; font-weight: 600; color: #000;">00.00</div>
                            <div style="color: #000; font-size: 12px;">As of Today</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <!-- Increased bar thickness from 8px to 12px -->
                    <div style="display: flex; height: 12px; border-radius: 6px; overflow: hidden; background-color: #f0f0f0;">
                        <div style="width: 29%; background-color: #ff8c00; height: 100%;"></div>
                        <div style="width: 71%; background-color: #d0d0d0; height: 100%;"></div>
                    </div>
                </div>
                
                <!-- Paid Section -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <!-- Removed dollar sign and changed color to black -->
                        <span style="color: #000; font-size: 13px;">INVOICE RECEIPTS - This Month</span>
                        <span style="color: #000; font-size: 13px;"></span>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <div>
                            <!-- Removed dollar sign and changed color to black -->
                            <div style="font-size: 24px; font-weight: 600; color: #000;">00.00</div>
                            <div style="color: #000; font-size: 12px;"></div>
                        </div>
                        <div style="text-align: right;">
                            <!-- Removed dollar sign and changed color to black -->
                            <div style="font-size: 24px; font-weight: 600; color: #000;">00.00</div>
                            <div style="color: #000; font-size: 12px;">Invoice Posted - This Month</div>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <!-- Increased bar thickness from 8px to 12px -->
                    <div style="display: flex; height: 12px; border-radius: 6px; overflow: hidden; background-color: #f0f0f0;">
                        <div style="width: 56%; background-color: #28a745; height: 100%;"></div>
                        <div style="width: 44%; background-color: #90c695; height: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- Expenses Box -->
<div class="col-md-4">
    <!-- Added vibrate-box class for hover effect -->
    <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <!-- Changed color to black -->
                <h4 style="margin: 0; color: #000; font-weight: 600;">Expenses</h4>
                <!-- Removed "This month ▼" text -->
            </div>
        </div>
        <div class="box-body" style="padding: 20px;">
            <!-- Main Amount Display -->
            <div style="margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                    <!-- Changed color to black -->
                    <span style="color: #000; font-size: 13px;">TOTAL EXPENSES</span>
                    <span style="color: #000; font-size: 13px;">THIS MONTH</span>
                </div>
                
                <?php 
                $totalExpensis = 0; 
                foreach($Expensis as $val) { 
                    $totalExpensis += $val['balance']->Debit - $val['balance']->Credit;
                }
                ?>
                <!-- Removed dollar sign and changed color to black -->
                <div style="font-size: 28px; font-weight: 600; color: #000; margin-bottom: 15px;"><?php echo number_format($totalExpensis, 2); ?></div>
            </div>
            
            <!-- Expense Categories with scroll feature -->
            <div>
                <!-- Changed color to black -->
                <div style="color: #000; font-size: 12px; margin-bottom: 10px;">ALL CATEGORIES</div>
                <div class="custom-scroll" style="max-height: 120px; overflow-y: auto; padding-right: 5px;">
                    <?php 
                    $colors = ['#17a2b8', '#28a745', '#ffc107', '#dc3545'];
                    $colorIndex = 0;
                    foreach($Expensis as $val) { 
                        $amount = $val['balance']->Debit - $val['balance']->Credit;
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 8px; height: 8px; background-color: <?php echo $colors[$colorIndex % 4]; ?>; margin-right: 8px; border-radius: 50%;"></div>
                            <!-- Increased font size from 10px to 14px and changed color to black -->
                            <span style="color: #000; font-size: 14px;"><?php echo $val['ControlName']; ?></span>
                        </div>
                        <!-- Increased font size from 10px to 14px, removed dollar sign, and changed color to black -->
                        <span style="color: #000; font-size: 14px; font-weight: 600;"><?php echo number_format($amount, 2); ?></span>
                    </div>
                    <?php 
                        $colorIndex++;
                    } 
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
    
    <!-- Cash Flow Box -->
    <div class="col-md-4">
        <!-- Added vibrate-box class for hover effect -->
        <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0;">
                <!-- Changed color to black -->
                <h4 style="margin: 0; color: #000; font-weight: 600;">Cash Flow</h4>
            </div>
            <!-- Reduced padding from 20px to 15px to match other boxes height -->
            <div class="box-body" style="padding: 15px;">
                <!-- Net Cash Flow Summary -->
                <!-- Reduced padding from 15px to 12px and margin-bottom from 20px to 15px -->
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 12px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #007bff;">
                    <?php $netCashFlow = $DashboardTotalDebitOrCredit['Debit'] - $DashboardTotalDebitOrCredit['Credit']; ?>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="color: #000; font-size: 12px; font-weight: 500; margin-bottom: 5px;">NET CASH FLOW</div>
                            <!-- Reduced font size from 24px to 22px -->
                            <div style="font-size: 22px; font-weight: 700; color: <?php echo $netCashFlow >= 0 ? '#28a745' : '#dc3545'; ?>;">
                                <?php echo number_format(abs($netCashFlow)); ?>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; color: white; background-color: <?php echo $netCashFlow >= 0 ? '#28a745' : '#dc3545'; ?>;">
                                <?php echo $netCashFlow >= 0 ? 'POSITIVE' : 'NEGATIVE'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cash Details Cards -->
                <div style="display: flex; gap: 10px;">
                    <!-- Cash Received Card -->
                    <!-- Reduced padding from 12px to 10px -->
                    <div style="flex: 1; border: 1px solid #e9ecef; border-radius: 6px; padding: 10px; background: #f8f9fa;">
                        <div style="color: #000; font-size: 11px; font-weight: 600; margin-bottom: 8px;">RECEIVED</div>
                        <!-- Reduced font size from 18px to 16px -->
                        <div style="font-size: 16px; font-weight: 700; color: #000; margin-bottom: 8px;">
                            <?php echo number_format($DashboardTotalDebitOrCredit['Debit']); ?>
                        </div>
                        <div style="height: 4px; background-color: #e9ecef; border-radius: 2px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background-color: #007bff;"></div>
                        </div>
                    </div>

                    <!-- Cash Payments Card -->
                    <!-- Reduced padding from 12px to 10px -->
                    <div style="flex: 1; border: 1px solid #e9ecef; border-radius: 6px; padding: 10px; background: #f8f9fa;">
                        <div style="color: #000; font-size: 11px; font-weight: 600; margin-bottom: 8px;">PAYMENTS</div>
                        <!-- Reduced font size from 18px to 16px -->
                        <div style="font-size: 16px; font-weight: 700; color: #000; margin-bottom: 8px;">
                            <?php echo number_format($DashboardTotalDebitOrCredit['Credit']); ?>
                        </div>
                        <div style="height: 4px; background-color: #e9ecef; border-radius: 2px; overflow: hidden;">
                            <div style="width: 100%; height: 100%; background-color: #6f42c1;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
                

		  
                <!-- /.col -->
            <!-- ./box-body -->

<style>
/* Added hover vibration effect for all boxes */
.vibrate-box {
    transition: transform 0.3s ease;
}
.vibrate-box:hover {
    transform: scale(1.02);
    animation: vibrate 0.5s ease-in-out;
}
@keyframes vibrate {
    0%, 100% { transform: scale(1.02) translateX(0); }
    25% { transform: scale(1.02) translateX(-2px); }
    75% { transform: scale(1.02) translateX(2px); }
}

/* Added custom scroll bar styling to make scroll bars always visible */
.custom-scroll {
    scrollbar-width: thin;
    scrollbar-color: #007bff #f1f1f1;
}

.custom-scroll::-webkit-scrollbar {
    width: 8px;
}

.custom-scroll::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.custom-scroll::-webkit-scrollbar-thumb {
    background: #007bff;
    border-radius: 4px;
}

.custom-scroll::-webkit-scrollbar-thumb:hover {
    background: #0056b3;
}

.custom-scroll-green {
    scrollbar-width: thin;
    scrollbar-color: #28a745 #f1f1f1;
}

.custom-scroll-green::-webkit-scrollbar {
    width: 8px;
}

.custom-scroll-green::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.custom-scroll-green::-webkit-scrollbar-thumb {
    background: #28a745;
    border-radius: 4px;
}

.custom-scroll-green::-webkit-scrollbar-thumb:hover {
    background: #1e7e34;
}
</style>

<!-- Balance Sheet Box -->
<div class="col-md-4">
    <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 320px;">
        <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0;">
            <h4 style="margin: 0; color: #000; font-weight: 600;">Balance Sheet</h4>
        </div>
        <div class="box-body" style="padding: 15px;">
            <?php
            // Calculate stock value (from your original code)
            $GrandAvgTotal = 0;
            if(isset($stockvalue['AllProducts'])) {
                foreach($stockvalue['AllProducts'] as $Category){
                    if(isset($Category['Products'])) {
                        foreach($Category['Products'] as $ProductRecord) { 
                            $PurchaseReturnQuantity = 0;
                            $SaleQuantity = 0;
                            
                            // Calculate purchase returns
                            if(isset($AllPurchaseReturnRecord)) {
                                foreach($AllPurchaseReturnRecord as $PurchaseReturnRecord) { 
                                    if($PurchaseReturnRecord['ProductId'] == $ProductRecord['ProductId']) { 
                                        $PurchaseReturnQuantity = $PurchaseReturnRecord['Quantity'];
                                    }
                                }
                            }

                            // Calculate sales
                            if(isset($stockvalue['AllSaleRecord'])) {
                                foreach($stockvalue['AllSaleRecord'] as $SaleRecord) { 
                                    if($SaleRecord['ProductId'] == $ProductRecord['ProductId']) {
                                        $SaleQuantity = $SaleRecord['Quantity']; 
                                    }
                                }
                            }

                            // Calculate average price - FIXED: Check if indexes exist
                            $avgPrice = 0;
                            foreach($stockvalue['ProductsPrice'] as $avg){
                                if($avg['ProductId'] == $ProductRecord['ProductId']){
                                    // Check if indexes exist before using them
                                    $amount = isset($avg['Amount']) ? $avg['Amount'] : 0;
                                    $holdingAmount = isset($avg['HoldingAmount']) ? $avg['HoldingAmount'] : 0;
                                    $importRelated = isset($avg['ImportRelated']) ? $avg['ImportRelated'] : 0;
                                    $quantity = isset($avg['Quantity']) ? $avg['Quantity'] : 1; // Avoid division by zero
                                    
                                    if ($quantity > 0) {
                                        $avgPrice = (($amount + $holdingAmount + $importRelated) / $quantity);
                                    } else {
                                        $avgPrice = 0;
                                    }
                                }
                            }
                            
                            // Add to total stock value
                            $GrandAvgTotal += $avgPrice * ($ProductRecord['Quantity'] - ($SaleQuantity + $PurchaseReturnQuantity));
                        }
                    }
                }
            }
            
            // Calculate total assets (from your original code)
            $totalassets = $GrandAvgTotal; 
            foreach($assets as $val) { 
                $totalassets += $val['balance']->Debit - $val['balance']->Credit;
            }
            
            // Calculate total liabilities (from your original code)
            $totalliabil = 0; 
            foreach($liabilities as $val) { 
                // Skip Inventory account in liabilities
                if($val['ControlName'] !== 'Inventory') {
                    $totalliabil += $val['balance']->Credit - $val['balance']->Debit;
                }
            }
            
            // Calculate total equity - FIXED: Using $Equity instead of $equities
            $totalequity = 0;
            if(isset($Equity)) {
                foreach($Equity as $val) { 
                    $totalequity += $val['balance']->Credit - $val['balance']->Debit;
                }
            }
            ?>
            
            <!-- Professional layout with proper sections and totals -->
            <div style="margin-bottom: 12px;">
                <div style="font-size: 20px; font-weight: 600; color: #000; margin-bottom: 8px;">Capital: <?php echo number_format($totalassets - $totalliabil - $totalequity); ?></div>
            </div>
            
            <!-- Scrollable content area with proper height -->
            <div class="custom-scroll" style="max-height: 200px; overflow-y: auto; padding-right: 5px;">
                <!-- Assets Section -->
                <div style="margin-bottom: 15px;">
                    <div style="color: #28a745; font-size: 14px; font-weight: 600; margin-bottom: 8px; padding: 6px 10px; background: #e8f5e8; border-radius: 4px;">
                        <i class="fas fa-arrow-up"></i> ASSETS
                    </div>
                    
                    <!-- Stock Value -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; padding: 6px 10px; background: #f8f9fa; border-radius: 4px;">
                        <span style="color: #000; font-size: 14px;">Stock Value</span>
                        <span style="color: #28a745; font-size: 14px; font-weight: 600;"><?php echo number_format($GrandAvgTotal, 2); ?></span>
                    </div>
                    
                    <?php foreach($assets as $val) { 
                        $amount = $val['balance']->Debit - $val['balance']->Credit;
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; padding: 6px 10px; background: #f8f9fa; border-radius: 4px;">
                        <span style="color: #000; font-size: 14px;"><?php echo $val['ControlName']; ?></span>
                        <span style="color: #28a745; font-size: 14px; font-weight: 600;"><?php echo number_format($amount, 2); ?></span>
                    </div>
                    <?php } ?>
                    
                    <!-- Assets Total -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 8px 10px; background: #28a745; color: white; border-radius: 4px; font-weight: 600;">
                        <span style="font-size: 14px;">TOTAL ASSETS</span>
                        <span style="font-size: 16px;"><?php echo number_format($totalassets, 2); ?></span>
                    </div>
                </div>
                
                <!-- Liabilities Section -->
                <div style="margin-bottom: 15px;">
                    <div style="color: #dc3545; font-size: 14px; font-weight: 600; margin-bottom: 8px; padding: 6px 10px; background: #fdeaea; border-radius: 4px;">
                        <i class="fas fa-arrow-down"></i> LIABILITIES
                    </div>
                    
                    <?php foreach($liabilities as $val) { 
                        // Skip Inventory account - FIXED: Properly filtering out Inventory
                        if($val['ControlName'] !== 'Inventory') {
                            $amount = $val['balance']->Credit - $val['balance']->Debit;
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; padding: 6px 10px; background: #f8f9fa; border-radius: 4px;">
                        <span style="color: #000; font-size: 14px;"><?php echo $val['ControlName']; ?></span>
                        <span style="color: #dc3545; font-size: 14px; font-weight: 600;"><?php echo number_format($amount, 2); ?></span>
                    </div>
                    <?php 
                        }
                    } 
                    ?>
                    
                    <!-- Liabilities Total -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 8px 10px; background: #dc3545; color: white; border-radius: 4px; font-weight: 600;">
                        <span style="font-size: 14px;">TOTAL LIABILITIES</span>
                        <span style="font-size: 16px;"><?php echo number_format($totalliabil, 2); ?></span>
                    </div>
                </div>
                
                <!-- Equity Section -->
                <div>
                    <div style="color: #6f42c1; font-size: 14px; font-weight: 600; margin-bottom: 8px; padding: 6px 10px; background: #f0e8ff; border-radius: 4px;">
                        <i class="fas fa-balance-scale"></i> EQUITY
                    </div>
                    
                    <?php 
                    // FIXED: Using $Equity instead of $equities
                    if(isset($Equity)) {
                        foreach($Equity as $val) { 
                            $amount = $val['balance']->Credit - $val['balance']->Debit;
                    ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; padding: 6px 10px; background: #f8f9fa; border-radius: 4px;">
                        <span style="color: #000; font-size: 14px;"><?php echo $val['ControlName']; ?></span>
                        <span style="color: #6f42c1; font-size: 14px; font-weight: 600;"><?php echo number_format($amount, 2); ?></span>
                    </div>
                    <?php 
                        }
                    } 
                    ?>
                    
                    <!-- Equity Total -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 10px; background: #6f42c1; color: white; border-radius: 4px; font-weight: 600;">
                        <span style="font-size: 14px;">TOTAL EQUITY</span>
                        <span style="font-size: 16px;"><?php echo number_format($totalequity, 2); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bank Balances Box -->
<div class="col-md-4">
    <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 320px;">
        <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0; background: linear-gradient(135deg, #007bff, #0056b3); color: white; border-radius: 8px 8px 0 0;">
            <h4 style="margin: 0; font-weight: 600; display: flex; align-items: center;">
                <i class="fa fa-university" style="margin-right: 8px;"></i>
                Up-to-Date Bank Balances
            </h4>
        </div>
        <div class="box-body" style="padding: 15px;">
            <?php 
            $totbank = 0; 
            foreach($DashboardSubLedgerReport as $val) { 
                $totbank += $val->Debit - $val->Credit;
            }
            ?>
            
            <div style="margin-bottom: 15px; text-align: center; padding: 12px; background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 6px;">
                <div style="font-size: 24px; font-weight: 700; color: #1565c0; margin-bottom: 4px;"><?php echo number_format($totbank); ?></div>
                <div style="color: #1976d2; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Bank Balance</div>
            </div>
            
            <!-- Applied same scroll styling as balance sheet with padding-right: 5px -->
            <div class="custom-scroll" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
                <?php foreach($DashboardSubLedgerReport as $val) { 
                    $amount = $val->Debit - $val->Credit;
                ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; padding: 10px 14px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 6px; border-left: 4px solid #007bff; transition: all 0.2s ease;">
                    <span style="color: #000; font-size: 13px; font-weight: 500;"><?php echo $val->ChartOfAccountTitle; ?></span>
                    <span style="color: #007bff; font-size: 14px; font-weight: 700;"><?php echo number_format($amount); ?></span>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Cash Balances Box -->
<div class="col-md-4">
    <div class="box vibrate-box" style="border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); height: 320px;">
        <div class="box-header" style="padding: 15px; border-bottom: 1px solid #f0f0f0; background: linear-gradient(135deg, #28a745, #1e7e34); color: white; border-radius: 8px 8px 0 0;">
            <h4 style="margin: 0; font-weight: 600; display: flex; align-items: center;">
                <i class="fa fa-money" style="margin-right: 8px;"></i>
                Up-to-Date Cash Balances
            </h4>
        </div>
        <div class="box-body" style="padding: 15px;">
            <?php 
            $totcash = 0; 
            if (!empty($DashboardSubLedgerReportCash)) {
                foreach($DashboardSubLedgerReportCash as $val) { 
                    $totcash += $val->Debit - $val->Credit;
                }
            }
            ?>
            
            <div style="margin-bottom: 15px; text-align: center; padding: 12px; background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 6px;">
                <div style="font-size: 24px; font-weight: 700; color: #2e7d32; margin-bottom: 4px;"><?php echo number_format($totcash); ?></div>
                <div style="color: #388e3c; font-size: 12px; font-weight: 600; text-transform: uppercase;">Total Cash Balance</div>
            </div>
            
            <!-- Applied same scroll styling as balance sheet with padding-right: 5px -->
            <div class="custom-scroll-green" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
                <?php 
                if (!empty($DashboardSubLedgerReportCash)) {
                    foreach($DashboardSubLedgerReportCash as $val) { 
                        $amount = $val->Debit - $val->Credit;
                ?>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; padding: 10px 14px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 6px; border-left: 4px solid #28a745; transition: all 0.2s ease;">
                    <span style="color: #000; font-size: 13px; font-weight: 500;"><?php echo $val->ChartOfAccountTitle; ?></span>
                    <span style="color: #28a745; font-size: 14px; font-weight: 700;"><?php echo number_format($amount); ?></span>
                </div>
                <?php 
                    } 
                } else {
                ?>
                <div style="color: #6c757d; font-size: 14px; text-align: center; padding: 20px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); border-radius: 6px;">
                    <i class="fa fa-info-circle" style="margin-right: 8px;"></i>
                    No cash accounts found
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>




                
              
</div>  


      <div class="row">
        <div class="col-md-12">
          <div class="box">
        <div class="box-header with-border col-md-12">
      <h3 class="box-title"><strong>Cancelled Sales</strong></h3>
                <div class="box-tools pull-right"></div>
              </div>
       
            <div class="box-body">
              <div class="row">                
    <div class="col-md-12">
                  <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Invoice. #</th>
                    <th>Sale Type</th>
                    <th>Sale Date</th>
                    <th>Customer</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($CancelledSales){
                      foreach ($CancelledSales as $Sales) {
                      $id = $Sales['SaleId'];
                      $SaleType = "";
                      if($Sales['SaleType'] == '1'){ $SaleType = "Cash"; }
                      if($Sales['SaleType'] == '2'){ $SaleType = "Credit"; }
                      if($Sales['SaleType'] == '3'){ $SaleType = "Online"; }
                    ?>
                  <tr>
                    <td><?php echo $Sales['SaleId']; ?></td>
                    <td><?php echo $SaleType; ?></td>
                    <td><?php echo date("M d, Y", strtotime($Sales['SaleDate'])); ?></td>
                    <td><?php echo $Sales['CustomerName']; ?></td>
                    <td><a href="<?php echo base_url() ?>Sales/EditSale/<?php echo $id ?>" title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a></td>
                  </tr>
                    <?php
                    } } 
                    ?>

                  </tbody>
                </table>
                </div>
      
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->




      <div class="row">
        <div class="col-md-12">
          <div class="box">
        <div class="box-header with-border col-md-12">
      <h3 class="box-title"><strong>Cancelled Purchases</strong></h3>
                <div class="box-tools pull-right"></div>
              </div>
       
            <div class="box-body">
              <div class="row">                
    <div class="col-md-12">
                  <table class="table no-margin" id="CancelledPurchases" style="">
                  <thead>
                  <tr>
                    <th style="width: 25%;">Purchase. #</th>
                    <th style="width: 25%;">Purchase Type</th>
                    <th style="width: 25%;">Purchase Date</th>
                    <th style="width: 25%;">Vendor</th>
                    <th style="width: 25%;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if($CancelledPurchases){
                      foreach ($CancelledPurchases as $Purchases) {
                      $id = $Purchases['PurchaseId'];
                      $PurchaseType = "";
                      if($Purchases['PurchaseType'] == '1'){ $PurchaseType = "Cash"; }
                      if($Purchases['PurchaseType'] == '2'){ $PurchaseType = "Credit"; }
                      if($Purchases['PurchaseType'] == '3'){ $PurchaseType = "Online"; }
                    ?>
                  <tr>
                    <td style="width: 25%;"><?php echo $Purchases['PurchaseId']; ?></td>
                    <td style="width: 25%;"><?php echo $PurchaseType; ?></td>
                    <td style="width: 25%;"><?php echo date("M d, Y", strtotime($Purchases['PurchaseDate'])); ?></td>
                    <td style="width: 25%;"><?php echo $Purchases['VendorName']; ?></td>
                    <td style="width: 25%;"><a href="<?php echo base_url() ?>Purchase/EditPurchase/<?php echo $id ?>" title="Update Record"><span style="color:#0c6aad;" class="fa fa-edit"></span></a></td>
                  </tr>
                    <?php
                    } } 
                    ?>

                  </tbody>
                </table>
                </div>
      
              </div>
              <!-- /.row -->
            </div>
            <!-- ./box-body -->
           
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
       
      

    <!-- /.content -->
    </section>

      </div>
  <!-- /.content-wrapper -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->



<?php $this->load->view('includes/footer'); ?>

