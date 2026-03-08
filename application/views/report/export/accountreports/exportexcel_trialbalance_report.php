<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename = Trial Balance Report.xls");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Trial Balance Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"> 
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>lib/css/font-awesome/font-awesome.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
      <div class="box box-info">
          
        <div class="col-md-12 col-xs-12">               
          <center>
            <div class="box-header">
	      <h2 style="color:black; font-family:Georgia; font-weight:600;" class="box-title">Sunny Paper Mills</h2>
              <h3 style="color:green;" class="box-title">Trial Balance Report</h3>
	      <hr style="color: #003eff; border-width: 1px; border-style: inset; display: block;">
	      <div style="padding-top:-0.1em; font-size:12px; font-weight:600; text-align:left;">Period of: <?php echo date('M d, Y', strtotime($this->input->get('StartDate'))).' To '. date('M d, Y', strtotime($this->input->get('EndDate'))); ?></div>
            </div>
          </center>
	    <div style="height:30px;"></div>
	    <table border="0" cellspacing="0" cellpadding="3" style="width:100%; text-align:center; padding-left: 1px;">
             <thead>
	      <tr>
               <th style="border-bottom:0px solid; width:10%; padding:15px; border-bottom:1px solid;"></th>
                <th style="border-bottom:0px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold;text-align:center; border-bottom:1px solid;">Debit</th>
                <th style="border-bottom:0px solid; width:10%; font-family:Tahoma, Arial; font-weight:bold; text-align:center; border-bottom:1px solid;">Credit</th>
               </tr>
	     </thead>
	    </table>
            <?php
            $CompanyName = '';
            $dTotal_Debit = 0;
            $dTotal_Credit = 0;
            $dGrandTotal_Debit = 0;
            $dGrandTotal_Credit = 0;
            $dDebit = 0; 
            $dCredit = 0;
            ?>
            <table border="0" cellspacing="0" cellpadding="5" style="width:100%; text-align: center; padding-left:1px;">
             <?php 	    
	     if(isset($COACategories)) {
             foreach($COACategories as $COACategoriesRecord) {
	     ?> 
	     <thead>
              <tr>
               <td style="font-family:Tahoma, Arial; font-size:18px; text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;" colspan="3"><?php echo $COACategoriesRecord['CategoryName']; //$ChartOfAccountsTitle; ?></td>
	      </tr>                
              </thead>
                <?php 	    
	        if(isset($GetAllControlCodes)) {
                 foreach($GetAllControlCodes as $GetAllControlCodesRecord) {
	         if($GetAllControlCodesRecord['ChartOfAccountsCategoryId'] == $COACategoriesRecord['ChartOfAccountsCategoryId'] ) {
	        ?>
	        <tr style="font-size:16px;">
                 <td style="font-family:Tahoma, Arial; height:5px; padding-left:20px; text-align:left; height:20px; padding-left:1  5px;" colspan="7"><?php echo $GetAllControlCodesRecord['ControlName']; ?></td>
	        </tr>
                <?php
		}
		if(isset($GetAllChartOfAccounts)) {
		foreach($GetAllChartOfAccounts as $GetAllChartOfAccountsRecord) {

		$ChartOfAccountsCategoryId = $GetAllChartOfAccountsRecord['ChartOfAccountsCategoryId'];
		$ChartOfAccountsControlId = $GetAllChartOfAccountsRecord['ChartOfAccountsControlId'];
		$ChartOfAccountsId = $GetAllChartOfAccountsRecord['ChartOfAccountsId'];
		$ChartOfAccountsTitle = $GetAllChartOfAccountsRecord['ChartOfAccountsTitle'];
		$ChartOfAccountsCode = $GetAllChartOfAccountsRecord['ChartOfAccountsCode'];
		$DebitIncrease = $GetAllChartOfAccountsRecord['DebitIncrease'];
	        $dDebit = $GetAllChartOfAccountsRecord['Debit'];
                $dCredit = $GetAllChartOfAccountsRecord['Credit'];

		if($ChartOfAccountsControlId == $GetAllControlCodesRecord['ChartOfAccountsControlId'] && $ChartOfAccountsCategoryId == $COACategoriesRecord['ChartOfAccountsCategoryId'])
		{
		
		$dTotal_Debit += $dDebit;
                $dTotal_Credit += $dCredit;    
		?>
		<tr style="font-size:12px;">
                <td style="width:10%; font-family:Tahoma, Arial; text-align:left;  height:25px; padding-left:25px;"><?php echo $ChartOfAccountsCode. ' - '.$ChartOfAccountsTitle; ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php echo number_format($dTotal_Debit,0); ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php echo number_format($dTotal_Credit,0); ?></td>
                </tr>
		<?php
		   }
		 $dGrandTotal_Debit += $dTotal_Debit;
		 $dGrandTotal_Credit += $dTotal_Credit;	      
		 $dTotal_Debit = 0;
		 $dTotal_Credit = 0;
		   }
		}
		} } } }  // Category code for loop ends ?> 
               <tr style="font-size:13px;">
                <td style=" font-weight:700; width:10%; text-align: right;"></td>
                <td style="font-weight: 700; width:10%; text-align: center; border-bottom:4px double; border-top:1px solid; "><?php echo number_format($dGrandTotal_Debit,0); ?></td>
                <td style="font-weight: 700; width:10%; text-align: center; border-bottom:4px double; border-top:1px solid; "><?php echo number_format($dGrandTotal_Credit,0); ?></td>
              </tr>
              </tbody>
              <tr>
                  <td colspan="3" style="height:50px;">&nbsp;</td>
               </tr>
	       
            </table>            
         </div>   
       </div>
    </div>
  </body>
</html>