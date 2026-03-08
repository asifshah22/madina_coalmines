<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Balance Sheet Report</title>
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
              <h2 style="color:green;" class="box-title">Balance Sheet Report</h2>
            </div>
          </center>
	    <?php
            $CompanyName = '';
	    
	    $dDebitIncome = 0; 
            $dCreditIncome = 0;
	    $dDebitExpenses = 0; 
            $dCreditExpenses = 0;
	    $dDebitEquities = 0; 
            $dCreditEquities = 0;
            
	    $dTotal_CreditIncome = 0;
	    $dTotal_DebitIncome = 0;
	    $dTotal_DebitLiabilities = 0;
	    $dTotal_CreditLiabilities = 0;
	    $dTotal_DebitEquities = 0;
	    $dTotal_CreditEquities = 0;
	    
	    $dGrandTotal_DebitIncome = 0;
            $dGrandTotal_CreditIncome = 0;
	    $dGrandTotal_DebitLiabilities = 0;
            $dGrandTotal_CreditLiabilities = 0;
	    $dGrandTotal_DebitEquities = 0;
            $dGrandTotal_CreditEquities = 0;	    

            ?>
	    
	    <table border="0" cellspacing="0" cellpadding="5" style="width:100%;">
	     <tr>
                <td style="height:55px; font-weight:600; font-size:20px; text-align:center;">Assets</td>
             </tr>
             </table>
	    
	    <!-- Following block of codes shows Total Assets  -->
            <table border="0" cellspacing="0" cellpadding="5" style="width:100%; text-align:center; padding-left:1px;">
             <?php 
	     if(isset($COACategories)) {
             foreach($COACategories as $COACategoriesRecord) {
	     if($COACategoriesRecord['CategoryName'] == 'Assets')
	     {
	     ?>
	     <thead>
              <tr>
               <td style="font-family:Tahoma, Arial; font-size:18px; text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;" colspan="3"><?php echo $COACategoriesRecord['CategoryName']; ?></td>
	      </tr>
              </thead>
                <?php 	    
	         if(isset($GetAllControlCodes)) {
                 foreach($GetAllControlCodes as $GetAllControlCodesRecord) {
	         if($GetAllControlCodesRecord['ChartOfAccountsCategoryId'] == $COACategoriesRecord['ChartOfAccountsCategoryId'] ) {
	        ?>
	        <tr style="font-size:15px;">
                 <td style="font-family:Tahoma, Arial; height:5px; padding-left:20px; text-align:left; height:20px; padding-left:15px;" colspan="7"><?php echo $GetAllControlCodesRecord['ControlName']; ?></td>
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
	        $dDebitIncome = $GetAllChartOfAccountsRecord['Debit'];
                $dCreditIncome = $GetAllChartOfAccountsRecord['Credit'];

		if($ChartOfAccountsControlId == $GetAllControlCodesRecord['ChartOfAccountsControlId'] && $ChartOfAccountsCategoryId == $COACategoriesRecord['ChartOfAccountsCategoryId'])
		{
		    $dTotal_DebitIncome += $dDebitIncome;
		    $dTotal_CreditIncome += $dCreditIncome; 
		?>
		<tr style="font-size:12px;">
                <td style="width:10%; font-family:Tahoma, Arial; text-align:left;  height:25px; padding-left:25px;"><?php echo $ChartOfAccountsCode.'-'.$ChartOfAccountsTitle; ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:right;"><?php echo number_format($dTotal_CreditIncome,0); ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php // echo number_format($dTotal_Debit,0); ?></td>
                </tr>
		<?php
		}
		 //$dGrandTotal_Debit += $dTotal_Debit;
		 $dGrandTotal_CreditIncome += $dTotal_CreditIncome;
		 $dTotal_CreditIncome = 0;
		   }
		}
	        } } } } }  // Category code for loop ends ?> 
               <tr style="font-size:13px; font-weight:700;">
                <td style="text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;">Total Assets</td>
                <td style="width:10%; text-align:right;"><span style="border-bottom:solid 1px; border-top:1px solid;"><?php echo number_format($dGrandTotal_CreditIncome,0); ?></span></td>
                <td style="width:10%;"><?php // echo number_format($dGrandTotal_Debit,0); ?></td>
               </tr>
               </tbody>
               <tr>
                  <td colspan="3" style="height:50px;">&nbsp;</td>
               </tr>
             </table>
	  	    
	     <table border="0" cellspacing="0" cellpadding="5" style="width:100%;">
	     <tr>
                <td style="height:25px; font-weight:600; font-size:20px; text-align:center;">Liabilities & Equities</td>
             </tr>
             </table>
	    
	    <!-- Following block of codes shows Total Liabilities  -->
	     <table border="0" cellspacing="0" cellpadding="5" style="width:100%; text-align: center; padding-left:1px;">
             <?php
	     if(isset($COACategories)) {
             foreach($COACategories as $COACategoriesRecord) {
	     if($COACategoriesRecord['CategoryName'] == 'Liabilities')
	     {
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
                 <td style="font-family:Tahoma, Arial; height:5px; padding-left:20px; text-align:left; height:20px; padding-left:15px;" colspan="7"><?php echo $GetAllControlCodesRecord['ControlName']; ?></td>
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
	        $dDebitLiabilities = $GetAllChartOfAccountsRecord['Debit'];
                $dCreditLiabilities = $GetAllChartOfAccountsRecord['Credit'];

		if($ChartOfAccountsControlId == $GetAllControlCodesRecord['ChartOfAccountsControlId'] && $ChartOfAccountsCategoryId == $COACategoriesRecord['ChartOfAccountsCategoryId'])
		{
		
		$dTotal_DebitLiabilities += $dDebitLiabilities;
                $dTotal_CreditLiabilities += $dCreditLiabilities;  
		?>
		<tr style="font-size:12px;">
                <td style="width:10%; font-family:Tahoma, Arial; text-align:left;  height:25px; padding-left:25px;"><?php echo $ChartOfAccountsCode. ' - '.$ChartOfAccountsTitle; ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:right;"><?php echo number_format($dTotal_CreditLiabilities,0); ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:center;"><?php //echo number_format($dTotal_Credit,0); ?></td>
                </tr>
		<?php
		 }
		 $dGrandTotal_DebitLiabilities += $dTotal_DebitLiabilities;
		 $dGrandTotal_CreditLiabilities += $dTotal_CreditLiabilities;	
		 
		 $dTotal_DebitLiabilities = 0;
		 $dTotal_CreditLiabilities = 0;
		   }
		}
		} } } } }
		?>
               <tr style="font-size:13px; font-weight:700;">
                <td style="text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;">Total Liabilities</td>
                <td style="width:5%; text-align:right;"><span style="border-bottom:solid 1px; border-top:1px solid;"><?php echo number_format($dGrandTotal_CreditLiabilities,0); ?></span></td>
                <td style="width:5%; text-align:right;"><?php // echo number_format($dGrandTotal_Credit,0); ?></td>
              </tr>
              </tbody>
             </table>
	    
	     <!-- Following block of codes shows Total Equities  -->
	     <table border="0" cellspacing="0" cellpadding="5" style="width:100%; text-align: center; padding-left:1px;">
             <?php
	     if(isset($COACategories)) {
             foreach($COACategories as $COACategoriesRecord) {
	     if($COACategoriesRecord['CategoryName'] == 'Equity/Capital')
	     {
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
                 <td style="font-family:Tahoma, Arial; height:5px; padding-left:20px; text-align:left; height:20px; padding-left:15px;" colspan="7"><?php echo $GetAllControlCodesRecord['ControlName']; ?></td>
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
	        $dDebitEquities = $GetAllChartOfAccountsRecord['Debit'];
                $dCreditEquities = $GetAllChartOfAccountsRecord['Credit'];

		if($ChartOfAccountsControlId == $GetAllControlCodesRecord['ChartOfAccountsControlId'] && $ChartOfAccountsCategoryId == $COACategoriesRecord['ChartOfAccountsCategoryId'])
		{
		    
		$dTotal_DebitEquities += $dDebitEquities;
                $dTotal_CreditEquities += $dCreditEquities;
		?>
		<tr style="font-size:12px;">
                <td style="width:10%; font-family:Tahoma, Arial; text-align:left;  height:25px; padding-left:25px;"><?php echo $ChartOfAccountsCode. ' - '.$ChartOfAccountsTitle; ?></td>
                <td style="width:10%; font-family:Tahoma, Arial; text-align:right;"><?php echo number_format($dTotal_CreditEquities,0); ?></td>
		<td style="width:10%; font-family:Tahoma, Arial; text-align:right;"><?php //echo number_format($dTotal_DebitEquities,0); ?></td>
                
		</tr>
		<?php
		 }
		 $dGrandTotal_DebitEquities += $dTotal_DebitEquities;
		 $dGrandTotal_CreditEquities += $dTotal_CreditEquities;
		 
		 $dTotal_DebitEquities = 0;
		 $dTotal_CreditEquities = 0;
		   }
		}
		} } } } }
		?>
               <tr style="font-size:13px; font-weight:700;">
                <td style="text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;">Total Equities</td>
                <td style="width:5%; text-align:right;"><span style="border-bottom:solid 1px; border-top:1px solid;"><?php echo number_format($dGrandTotal_CreditEquities,0); ?></span></td>
                <td style="width:5%; text-align:right;"><?php // echo number_format($dGrandTotal_Credit,0); ?></td>
              </tr>
              </tbody>
             </table>
	     
	     
	     <table border="0" cellspacing="0" cellpadding="5" style="width:100%;">
	      <tr style="font-size:13px; font-weight:700;">
	       <td style="width:5%; text-transform:uppercase; padding-left:10px; text-align:left; padding:10px;">Total Liabilities & Equities</td>
	       <td style="width:5%; text-align:right;"><span style="border-bottom:double 3px; border-top:1px solid;"><?php echo $Total = number_format($dGrandTotal_CreditLiabilities + $dGrandTotal_CreditEquities,0); //echo number_format($dTotal_Debit,0); ?></span></td>
	       <td style="width:5%;"></td>
	     </tr>
	     <tr>
                <td colspan="3" style="height:55px;">&nbsp;</td>
             </tr>
             </table>
         </div>   
       </div>
    </div>
  </body>
</html>