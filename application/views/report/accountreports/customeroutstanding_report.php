<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->uri->segment(1); ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>

  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">

  <style>
    @media print {
      .no-print, .no-print * {
        display: none !important;
      }

      body {
        margin: 0;
        padding: 0;
      }

      .wrapper {
        width: 100%;
        padding: 10px;
      }

      .table {
        font-size: 12px;
        width: 100%;
        border-collapse: collapse;
      }
      
      .hidden-column,
      .hidden-column * {
        display: none !important;
      }
      
      .hidden-column + th,
      .hidden-column + td {
        border-left: 1px solid black !important;
      }
    }

    body {
      font-family: 'Calibri', sans-serif;
      font-size: 14px;
      background: #fff;
      margin: 0;
      padding: 0;
      color: black;
    }

    .wrapper {
      width: 100%;
      margin: 0 auto;
      padding: 10px;
    }

    h2, h3 {
      font-weight: bold;
      text-align: center;
      font-family: 'Calibri', sans-serif;
      color: black;
    }

    h2 {
      font-size: 24px;
      margin-top: 10px;
    }

    h3 {
      font-size: 20px;
      margin-bottom: 10px;
    }

    .table-container {
      width: 100%;
      overflow-x: auto;
    }

    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      table-layout: fixed;
    }

    .table th, .table td {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
      font-family: 'Calibri', sans-serif;
      font-size: 14px;
      color: black;
    }

    .table thead th {
      background: #205081;
      color: white;
      font-weight: bold;
    }

    .table th:nth-child(1), .table td:nth-child(1) { width: 5%; }
    .table th:nth-child(2), .table td:nth-child(2) { width: 25%; }
    .table th:nth-child(3), .table td:nth-child(3) { width: 10%; }
    .table th:nth-child(4), .table td:nth-child(4) { width: 15%; }
    .table th:nth-child(5), .table td:nth-child(5) { width: 10%; }
    .table th:nth-child(6), .table td:nth-child(6) { width: 10%; }
    .table th:nth-child(7), .table td:nth-child(7) { width: 10%; }
    .table th:nth-child(8), .table td:nth-child(8) { width: 10%; }
    .table th:nth-child(9), .table td:nth-child(9) { width: 10%; }

    .table tbody tr:nth-child(even) {
      background: #f2f2f2;
    }

    .table tbody tr:hover {
      background: #e6e6e6;
    }

    #SendMail, .dropdown {
      display: none !important;
    }
    
    .filter-buttons {
      text-align: center;
      margin: 15px 0;
    }
    .btn-filter {
      margin: 0 5px;
    }
    .text-danger { color: #d9534f; }
    .text-success { color: #5cb85c; }
    
    .hidden-column {
      display: none;
    }

    /* Added for sort button */
    .btn-warning.active {
      background-color: #f0ad4e;
      border-color: #eea236;
      color: white;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <div class="box box-info">
      <div class="col-md-12 col-xs-12">
        <div class="col-xs-2 col-sm-2">
          <img src="<?php echo base_url() ?>images/company-logo/<?php echo $GetSettingInformation[0]['CompanyLogo']; ?>" alt="" width="100" class="img-rectangular">
        </div>
        <div class="col-xs-8 col-sm-8">
          <h2><?php echo $GetSettingInformation[0]['CompanyName']; ?></h2>
        </div>
      </div>

      <br><br>
      <h3>Customer Outstanding Report</h3>
      
      <!-- FILTER BUTTONS -->
      <div class="filter-buttons no-print">
        <a href="?StartDate=<?= $this->input->get('StartDate') ?>&EndDate=<?= $this->input->get('EndDate') ?>&filter=positive" 
           class="btn btn-danger btn-filter">
           <i class="fa fa-filter"></i> +Due (Customers Owe Us)
        </a>
        <a href="?StartDate=<?= $this->input->get('StartDate') ?>&EndDate=<?= $this->input->get('EndDate') ?>&filter=negative" 
           class="btn btn-success btn-filter">
           <i class="fa fa-filter"></i> -Due (We Owe Customers)
        </a>
        <a href="?StartDate=<?= $this->input->get('StartDate') ?>&EndDate=<?= $this->input->get('EndDate') ?>" 
           class="btn btn-default btn-filter">
           <i class="fa fa-times"></i> Reset Filter
        </a>
        <!-- TOGGLE COLUMNS BUTTON -->
        <button id="toggleColumnsBtn" class="btn btn-primary btn-filter">
          <i class="fa fa-eye-slash"></i> Toggle Columns
        </button>
        <!-- NEW SORT BUTTON -->
        <button id="sortHighToLowBtn" class="btn btn-warning btn-filter">
          <i class="fa fa-sort-amount-desc"></i> Sort: High to Low
        </button>
      </div>

      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:center;">
        Period of <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' - '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?>
      </div>

      <span class="pull-right no-print" style="font-size:13px; font-family:Calibri; margin-top: -100px">
        <a href="#" style="color:black" onclick="window.print();">Print</a>
      </span>

      <hr style="border-width: 1px; border-color: black;">

    </div>

    <div class="table-container">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>S. #</th>
            <th>Customer Name</th>
            <th>Type</th>
            <th>Area</th>
            <th>Contact No</th>
            <th class="toggleable-column">Opening Balance</th>
            <th class="toggleable-column">Sales Amount</th>
            <th class="toggleable-column">Payment Received</th>
            <th>Due Amount</th>
          </tr>
        </thead>
        <tbody>
          <?php
          function getVendorTypeName($typeId) {
    $types = [
        0 => '---', // Fallback for no type
        1 => 'Sariya',
        2 => 'Cement', 
        3 => 'Travel Agency',
        4 => 'Paint' // Added to match your form
    ];

    // Handle NULL, empty, or non-numeric values
    if ($typeId === null || $typeId === '' || $typeId === 'Select Type') {
        return '---';
    }

    $typeId = (int)$typeId; // Force integer type
    return $types[$typeId] ?? '---'; // Return name or '---' if invalid
}

          $Amount = 0;
          $Sale = 0;
          $Receipt = 0;
          $DueAmount = 0;
          $SNo=1;
          $openingbalance=0;
          $totalsalesamount=0;
          $totalpayment=0;
          $dBalance = 0;
          $filter = $this->input->get('filter');
          
          if(isset($CustomerOutstandingReport)) {
            usort($CustomerOutstandingReport, function($a, $b) {
                return strcmp($a['ChartOfAccountTitle'], $b['ChartOfAccountTitle']);
            });

            $i = 0;
            foreach($CustomerOutstandingReport as $Record) {
                $Sale = $Record['Credit'];
                $Receipt = $Record['Debit'];

                $Amount = ($Receipt - $Sale);
                if($Amount == 0 || $Amount == '0.00') {  
                    continue; 
                }

                $ChartOfAccountId = $Record['ChartOfAccountId'];
                foreach($OpenningBalance as $Balance) {
                    if($Balance['ChartOfAccountId'] == $ChartOfAccountId) {  
                        $dBalance = $Balance['Balance']; 
                    }
                }
                
                $currentDue = $dBalance + $Amount;
                
                if ($filter === 'positive' && $currentDue <= 0) continue;
                if ($filter === 'negative' && $currentDue >= 0) continue;
          ?>
          <tr style="font-size:13px;">
              <td style="text-align:center;"><?php echo $SNo; ?></td>
              <td style="text-align:left;"><?php echo $Record['ChartOfAccountTitle']?></td>
              <td style="text-align:left;"><?php echo getVendorTypeName($Record['Type'] ?? null); ?></td>
              <td style="text-align:left;"><?php echo $Record['Address'] == "" ? '---' : $Record['Address']?></td>
              <td style="text-align:left;"><?php echo $Record['CellNo'] == "" ? '---' : $Record['CellNo']?></td>
              <td class="toggleable-column" style="text-align:center;"><?php echo $dBalance; ?></td>
              <td class="toggleable-column" style="text-align:right;"><?php echo number_format($Receipt,2); ?></td>
              <td class="toggleable-column" style="text-align:right;"><?php echo number_format($Sale,2); ?></td>
              <td style="text-align:right; <?= $currentDue > 0 ? 'class="text-danger"' : 'class="text-success"' ?>">
                  <?php echo number_format($currentDue,2); ?>
              </td>
          </tr>
          <?php
                $i++;
                $SNo++;

                $DueAmount += $currentDue;
                $openingbalance += $dBalance;
                $totalsalesamount += $Receipt;
                $totalpayment += $Sale;
                $dBalance = 0;
            }
          } ?>
          <tr style="font-size:13px;">
           <td style="font-weight:700; text-align:right;" colspan="5">&nbsp; Grand Total:</td>
            <td class="toggleable-column" style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($openingbalance,2); ?></td>
              <td class="toggleable-column" style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($totalsalesamount,2); ?></td>
                <td class="toggleable-column" style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($totalpayment,2); ?></td>
                  <td style="font-weight:700; text-align:right;">&nbsp;<?php echo number_format($DueAmount,2); ?></td>
          </tr> 
        </tbody>
      </table>
    </div>
  </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <!-- ... existing modal code ... -->
</div>

<script src="<?php echo base_url(); ?>plugins/select2/select2.min.js"></script>
<script src="<?php echo base_url(); ?>lib/js/freeze-table.js"></script>
<script>
$(document).ready(function() {
  $(".table-basic").freezeTable();
  $(".table-head-only").freezeTable({
    'freezeColumn': false,
  });

  $("#Show").click(function(){
    $("#OtherEmployee").toggle('2000');
  });
  
  // TOGGLE COLUMNS FUNCTIONALITY
  $("#toggleColumnsBtn").click(function() {
    $(".toggleable-column").toggleClass("hidden-column");
    $(this).find("i").toggleClass("fa-eye-slash fa-eye");
    adjustColumnWidths();
  });
  
  function adjustColumnWidths() {
    var hidden = $(".toggleable-column").hasClass("hidden-column");
    
    if (hidden) {
      $(".table th:nth-child(1), .table td:nth-child(1)").css("width", "5%");
      $(".table th:nth-child(2), .table td:nth-child(2)").css("width", "35%");
      $(".table th:nth-child(3), .table td:nth-child(3)").css("width", "10%");
      $(".table th:nth-child(4), .table td:nth-child(4)").css("width", "20%");
      $(".table th:nth-child(5), .table td:nth-child(5)").css("width", "15%");
      $(".table th:nth-child(9), .table td:nth-child(9)").css("width", "15%");
    } else {
      $(".table th:nth-child(1), .table td:nth-child(1)").css("width", "5%");
      $(".table th:nth-child(2), .table td:nth-child(2)").css("width", "25%");
      $(".table th:nth-child(3), .table td:nth-child(3)").css("width", "10%");
      $(".table th:nth-child(4), .table td:nth-child(4)").css("width", "15%");
      $(".table th:nth-child(5), .table td:nth-child(5)").css("width", "10%");
      $(".table th:nth-child(6), .table td:nth-child(6)").css("width", "10%");
      $(".table th:nth-child(7), .table td:nth-child(7)").css("width", "10%");
      $(".table th:nth-child(8), .table td:nth-child(8)").css("width", "10%");
      $(".table th:nth-child(9), .table td:nth-child(9)").css("width", "10%");
    }
  }

  // NEW SORTING FUNCTIONALITY
  $("#sortHighToLowBtn").click(function() {
    var $table = $('.table');
    var $rows = $table.find('tbody tr:not(:last)'); // Exclude grand total row
    
    $rows.sort(function(a, b) {
      var aAmount = parseFloat($(a).find('td:eq(8)').text().replace(/,/g, '')); // Changed from 7 to 8
      var bAmount = parseFloat($(b).find('td:eq(8)').text().replace(/,/g, '')); // Changed from 7 to 8
      return bAmount - aAmount; // Sort descending
    });
    
    // Re-insert sorted rows
    $rows.each(function(index) {
      $(this).find('td:first').text(index + 1); // Update serial number
      $table.find('tbody').prepend(this); // Add to top (for descending)
    });
    
    // Move grand total row back to bottom
    $table.find('tbody tr:last').appendTo($table.find('tbody'));
    
    // Toggle active state
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
      $(this).html('<i class="fa fa-sort-amount-desc"></i> Sorted: High to Low');
    } else {
      $(this).html('<i class="fa fa-sort-amount-desc"></i> Sort: High to Low');
      location.reload(); // Reset to original order
    }
  });
});

  $(function(){
    $("#Submit").on('click', function(){
      var EmployeeId = $("#EmployeeId").val();
      var OtherEmployee = $("#OtherEmployee").val();
      var Subject = $("#Subject").val();
      var Comments = $("#Comments").val();
      var Message = $("#Message").val();
      var AsOfDate = $("#AsOfDate").val();
      var CustomerId = $("#CustomerId").val();

      $.ajax({
        url: '<?php echo base_url(); ?>SendEmail/SendCustomerOutstandingReport',
        data: {EmployeeId:EmployeeId,OtherEmployee:OtherEmployee,Subject:Subject,Comments:Comments,Message:Message,AsOfDate:AsOfDate,CustomerId:CustomerId},
        type: 'post',
        dataType: 'html',

        beforeSend: function(){
        $("#loader").css('display', 'inline');
        },
      success:function(data){
        $("#loader").css('display', 'none');
        $('input').val('');
        $('textarea').val('');
        $("#msg").html(data)
        },
        error:function(){
        $("#msg").html('Email can not be sent');
        }
      })
    })
  })

  $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
  });
</script>
</body>
</html>