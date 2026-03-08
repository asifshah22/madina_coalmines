  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">
    <?php
    $Controller = $this->uri->segment(1);
    $Function = $this->uri->segment(2);
    
    /*print_r($AdministrationRoles);
    die;*/
    ?>
      <ul class="sidebar-menu">
        <li class="header"><i class="fa fa-sitemap" aria-hidden="false"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MAIN NAVIGATION</li>
        <!-- Optionally, you can add icons to the links -->
        <li <?php echo ($Controller == "Dashboard")?"class ='active'":""?>><a href="<?php echo base_url(); ?>Dashboard/"><i class="fa fa-dashboard text-purple"></i><span>Dashboard</span></a></li>
        
      <?php if ($AdministrationRoles[0]['ViewRoles'] == 1 || $AdministrationRoles[1]['ViewRoles'] == 1 || $AdministrationRoles[2]['ViewRoles'] == 1 || $AdministrationRoles[3]['ViewRoles'] == 1 || $AdministrationRoles[4]['ViewRoles'] == 1 || $AdministrationRoles[5]['ViewRoles'] == 1 || $AdministrationRoles[6]['ViewRoles'] == 1 || $AdministrationRoles[7]['ViewRoles'] == 1 || $AdministrationRoles[8]['ViewRoles'] == 1 || $AdministrationRoles[9]['ViewRoles'] == 1) { ?>

        <li <?php if($Controller == "Category" || $Controller == "ProductGroup" || $Controller == "Brand" || $Controller == "Product" || $Controller == "Designation" || $Controller == "Employee" || $Controller == "Location" || $Controller == "Colour" || $Controller == "Reference" || $Controller == "StockTransfer") print 'class="active open"'; ?> >
          <a href="#">
            <i class="fa fa-gears text-red"></i>
            <span>Administration </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php if ($AdministrationRoles[0]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Category")?"class ='active'":""?>>
              <a href="<?php echo base_url(); ?>Category/">
                <i class="fa fa-cube" ></i><span>Categories</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[2]['ViewRoles']==1) { ?>
            <li <?php print $Active = $Controller == "ProductGroup" ? 'class="active"' : ""; ?> >
                <a href="<?php echo site_url(); ?>ProductGroup">
                  <i class="fa fa-cube"></i><span>UOM</span>
                </a>
                <b class="arrow"></b>
              </li>
            <?php } ?>

            <?php if ($AdministrationRoles[0]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Brand")?"class ='active'":""?>>
              <a href="<?php echo base_url(); ?>Brand/">
                <i class="fa fa-cube" ></i><span>Brands</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[1]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Product")?"class ='active'":""?>>
              <a href="<?php echo base_url(); ?>Product/">
                <i class="fa fa-medkit"></i><span>Products</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[0]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Designation")?"class ='active'":""?>>
              <a href="<?php echo base_url(); ?>Designation/">
                <i class="fa fa-cube" ></i><span>Designations</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[4]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Employee")?"class ='active'":""?>>
              <a href="<?php echo base_url('Employee/'); ?>">
                <i class="fa fa-user"></i><span>Employees</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[3]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Location")?"class ='active'":""?>>
              <a href="<?php echo base_url('Location/'); ?>">
                <i class="fa fa-building"></i><span>Locations</span></a></li>
            <?php } ?>

            <?php //if ($AdministrationRoles[5]['ViewRoles']==1) { ?>
            <!-- <li <?php //echo ($Controller == "Colour")?"class ='active'":""?>>
              <a href="<?php //echo base_url('Colour/'); ?>">
                <i class="fa fa-black-tie"></i><span>Colours</span></a></li> -->
            <?php //} ?>

            <?php if ($AdministrationRoles[5]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Reference")?"class ='active'":""?>>
              <a href="<?php echo base_url('Reference/'); ?>">
                <i class="fa fa-black-tie"></i><span>Transportation</span></a></li>
            <?php } ?>

            <?php if ($AdministrationRoles[5]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "StockTransfer")?"class ='active'":""?>>
              <a href="<?php echo base_url('StockTransfer/'); ?>">
                <i class="fa fa-black-tie"></i><span>Stock Transfer</span></a></li>
            <?php } ?>
            
            <?php if ($AdministrationRoles[5]['ViewRoles']==1) { ?>
            <li <?php echo ($Controller == "Area")?"class ='active'":""?>>
              <a href="<?php echo base_url('Area/'); ?>">
                <i class="fa fa-black-tie"></i><span>Customer Type</span></a></li>
            <?php } ?>

          </ul>
        </li>

        <?php if ($RegistrationRoles[0]['ViewRoles'] == 1 || $RegistrationRoles[1]['ViewRoles'] == 1 ) { ?>
        <li <?php if($Controller == "Registration" || $Controller == "ChartOfAccount" || $Controller == "ChartOfAccount" || $Controller == "GeneralJournal" || $Controller == "BankAccount" || $Controller == "OpeningStock") print 'class="active open"'; ?> >
          <a href="#"> 
            <i class="fa fa-briefcase text-yellow"></i> 
            <span>Registration</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php 
            if ($this->session->userdata('EmployeeType') == 1 || $RegistrationRoles[0]['ViewRoles'] == 1 ) 
            {
          ?>
            <li <?php if($Controller == "ChartOfAccount") print 'class="active"'; ?>>
              <a href="<?php echo base_url(); ?>ChartOfAccount/">
                <i class="fa fa-book"></i><span>Chart of Account</span></a></li>
          <?php } ?>

            <?php  if ($this->session->userdata('EmployeeType') == 1 || $RegistrationRoles[1]['ViewRoles'] == 1 ) {
            ?>
              <li <?php if($Controller == "GeneralJournal") print 'class="active"'; ?>>
                <a href="<?php echo site_url(); ?>GeneralJournal">
                  <i class="fa fa-book"></i><span>Vouchers</span></a></li>
          <?php } ?>

          <?php if ($this->session->userdata('EmployeeType') == 1 || $RegistrationRoles[1]['ViewRoles'] == 1 ) {
            ?>
              <li <?php if($Controller == "BankAccount") print 'class="active"'; ?>>
              <a href="<?php echo site_url(); ?>BankAccount">
                <i class="fa fa-book"></i><span>Bank Account</span></a></li>
          <?php } ?>

            <li <?php if($Controller == "OpeningStock") print 'class="active"'; ?>>
              <a href="<?php echo site_url(); ?>OpeningStock">
                <i class="fa fa-book"></i><span>Opening Stock</span></a></li>
            <?php } ?>
            
            <li <?php if($Controller == "InvoiceReceipt") print 'class="active"'; ?>>
              <a href="<?php echo base_url(); ?>InvoiceReceipt/">
                <i class="fa fa-book"></i><span>Invoice Receipt</span></a></li>
                 <li <?php if($Controller == "InvoiceReceipt") print 'class="active"'; ?>>
              <a href="<?php echo base_url(); ?>InvoiceReceipt/AddMultiInvoiceReceipt">
                <i class="fa fa-book"></i><span>Multi Invoice Receipt</span></a></li>
            </ul>
          </li>
      <?php } ?>

          <?php if ($SalesRoles[0]['ViewRoles'] == 1 || $SalesRoles[1]['ViewRoles'] == 1 || $SalesRoles[2]['ViewRoles'] == 1  ) { ?>
        <li class='treeview <?php echo ($Controller == "Sales" || $Controller  == "SalesReturn" || $Controller  == "Customer" || $Controller  == "Saleman") ? "active":""?> '>
          <a href="#">
            <i class="fa fa-shopping-cart text-green"></i>
            <span>Sale</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        <ul class="treeview-menu">
          <?php if ($this->session->userdata('EmployeeType')==1 || $SalesRoles[0]['ViewRoles']==1) { ?>
               <li <?php print $Active = $Controller == "Sales" ? 'class="active"' : ""; ?> >
                <a href="<?php echo site_url(); ?>Sales">
              <i class="fa fa-shopping-cart"></i><span>Invoices</span></a></li>
            <?php } ?>

        <?php if ($this->session->userdata('EmployeeType')==1 || $SalesRoles[1]['ViewRoles']==1) { ?>
              <li <?php print $Active = $Controller == "SalesReturn" ? 'class="active"' : ""; ?> >
                <a href="<?php echo site_url(); ?>SalesReturn">
              <i class="fa fa-edit"></i><span>Sales Return / Debit Notes</span></a></li>
            <?php } ?>

        <?php if ($this->session->userdata('EmployeeType')==1 || $SalesRoles[2]['ViewRoles']==1) { ?>   <li <?php print $Active = $Controller == "Customer" ? 'class="active"' : ""; ?> >
                <a href="<?php echo site_url(); ?>Customer">
              <i class="glyphicon glyphicon-user"></i><span>Customers</span></a></li>
            <?php } ?>

            <?php if ($this->session->userdata('EmployeeType')==1 || $SalesRoles[2]['ViewRoles']==1) { ?>   <li <?php print $Active = $Controller == "Saleman" ? 'class="active"' : ""; ?> >
                <a href="<?php echo site_url(); ?>Saleman">
              <i class="glyphicon glyphicon-user"></i><span>Salemans</span></a></li>
            <?php } ?>
            
        <?php if ($this->session->userdata('EmployeeType')==1 || $SalesRoles[2]['ViewRoles']==1) { ?>   <li <?php print $Active = $Controller == "Quotation" ? 'class="active"' : ""; ?> >
            <a href="<?php echo site_url(); ?>Quotation">
          <i class="glyphicon glyphicon-user"></i><span>Delivery Challan</span></a></li>
        <?php } ?>
	  </ul>
        </li>
        <?php } ?>

<?php /*
if ($PurchasesRoles[0]['ViewRoles'] == 1 || $PurchasesRoles[1]['ViewRoles'] == 1 ) { ?>
    <li class='treeview <?php echo $Controller  == "Purchase" || $Controller == "PurchaseReturn" || $Controller  == "Vendor"  ? "active":""?>'>
      <a href="#">
        <i class="fa fa-laptop text-aqua"></i>
        <span>Purchase</span>
         <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
         </span>
      </a>
    <ul class="treeview-menu">
      <?php if ($this->session->userdata('EmployeeType')==1 || $PurchasesRoles[0]['ViewRoles']==1) { ?>
          <li <?php if($Controller == "Purchase") print 'class="active"'; ?> >
            <a href="<?php echo site_url(); ?>Purchase">
          <i class="fa fa-laptop"></i><span>Purchases</span></a></li>
        <?php } ?>

        <?php if ($this->session->userdata('EmployeeType')==1 || $PurchasesRoles[0]['ViewRoles']==1) { ?>
          <li <?php if($Controller == "PurchaseReturn") print 'class="active"'; ?> >
            <a href="<?php echo site_url(); ?>PurchaseReturn">
            <i class="fa fa-laptop"></i><span>Purchase Return</span></a></li>
        <?php } ?>

      <?php if ($this->session->userdata('EmployeeType')==1 || $PurchasesRoles[1]['ViewRoles']==1) { ?>
          <li <?php echo ($Controller == "Vendor")?"class ='active'":""?>>
            <a href="<?php echo base_url(); ?>Vendor/">
            <i class="fa fa-male"></i><span>Vendor</span></a></li>
        <?php } ?>
    
      </ul>
    </li>
<?php  } ?>
*/ ?>

        <?php // if ($this->session->userdata('EmployeeType')==1 || $ReportsRoles[0]['ViewRoles']==1 || $ReportsRoles[1]['ViewRoles']==1 || $ReportsRoles[2]['ViewRoles']==1 || $ReportsRoles[3]['ViewRoles']==1 ) { ?>

        <!-- Reports Section -->
        <li class='treeview <?php echo $Controller  == "SaleReports" || $Controller == "PurchaseReports" || $Controller  == "StockReports" || $Controller == "AccountReports"  ? "active":""?>'>
          <a href="#">
            <i class="fa fa-file-text-o text-teal"></i>
            <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <?php // if ($this->session->userdata('EmployeeType')==1 || $ReportsRoles[0]['ViewRoles']==1){ ?>
                <li <?php if($Controller == "SaleReports") print 'class="active"'; ?> >    
                <a href="<?php echo site_url(); ?>SaleReports">
                <i class="fa fa-shopping-cart"></i><span>Sales Reports</span></a></li>
            <?php // } ?>

            <?php // if ($this->session->userdata('EmployeeType')==1 || $ReportsRoles[1]['ViewRoles']==1){ ?>
<?php /*
<li <?php if($Controller == "PurchaseReports") print 'class="active"'; ?> >
    <a href="<?php echo site_url(); ?>PurchaseReports">
    <i class="fa fa-laptop"></i><span>Purchases Reports</span></a>
</li>

<li <?php if($Controller == "StockReports") print 'class="active"'; ?> >    
    <a href="<?php echo site_url(); ?>StockReports">
    <i class="fa fa-gear"></i><span>Stock Reports</span></a>
</li>
*/ ?>

            
          <?php // if ($this->session->userdata('EmployeeType')==1 || $ReportsRoles[3]['ViewRoles']==1){ ?>
               <li <?php if($Controller == "AccountReports") print 'class="active"'; ?> >    
                <a href="<?php echo site_url(); ?>AccountReports">
                <i class="fa fa-briefcase"></i><span>Accounts Reports</span></a></li>
            <?php // } ?>
         </ul>
        </li>
      </ul>
      <?php // } ?>
    </section>
    <!-- /.sidebar -->
  </aside>