<?php $this->load->view('admin/includes/header'); ?>
<?php $this->load->view('admin/includes/sidebar'); ?>

      <!-- /.main-content starts -->
      <div class="main-content">
        <div class="main-content-inner">
          
                     <!-- /.breadcrumb starts -->
          <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo base_url(); ?>Dashboard">Home </a>
              </li>
              <li class=""><a href="#">Stock Activity Report</a></li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <!-- <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i> -->
                </span>
              </form>
            </div><!-- /.nav-search -->
          </div>
          <!-- /.breadcrumb ends -->
          <div class="page-content">
            <div class="page-header">
              <h1>Stock Activity Report Criteria</h1>
            </div><!-- /.page-header -->  
                    <!-- /.row  starts-->
                     <div class="box-body">
                      <div class="row">
                       
                        <div class="form-group">
                      <div class="col-xs-12 col-md-12">
                          <?php echo $this->session->flashdata('record_added'); ?>
                            </div>
                        </div>
            
            <table border="0" class="table table-responsive" style="width:80%;">
                <tr>
                  <td style="text-align:right; padding-top:22px;">
                  <label><b>Companies:</b></label>
                  </td>
                  <td style="width:150px; text-align:left;">
                  <select name="CompanyId" id="CompanyId" style="width: 190px; margin-top: 10px; margin-left: 20px;" class="col-md-12" required="required">
                    <option value="0">Select Company</option>
                    <?php foreach ($AllCompanies as $row) {
                    ?>  
                    <option value="<?php echo $row['CompanyId'] ?>"><?php echo $row['CompanyName']; ?></option>
                    <?php
                    } ?>
                  </select>
            </td>
            <td style="width:150px; text-align:right; padding-top:22px;">
              <label><b>Products:</b></label>
          </td>
          <td style="width:150px; text-align:left;">
	       <select name="ProductId" id="ProductId" style="width: 190px; margin-top: 10px; margin-left: 20px;" class="col-md-12" required="required">
                <option value="0">Select Product</option>
                <?php foreach ($AllProducts as $row) {
                ?>
                <option value="<?php echo $row['ProductId'] ?>"><?php echo $row['ProductName'] . " - " . $row['BrandName'] . " - " . $row['ProductGroupName']; ?></option>
                <?php
                } ?>
              </select>
          </td>

            <td style="width:150px; text-align:right; padding-top:22px;"">
              <label><b>Brands:</b></label>
          </td>
          <td style="width:150px; text-align:left;">
         <select name="ProductId" id="BrandId" style="width: 190px; margin-top: 10px;" class="col-md-12" required="required">
                <option value="0">Select Brand</option>
                <?php foreach ($GetAllBrands as $Brands) {
                ?>
                <option value="<?php echo $Brands['BrandId'] ?>"><?php echo $Brands['BrandName']; ?></option>
                <?php
                } ?>
              </select>
          </td>
            </tr>
        
          <tr>

            <td style="width:150px; text-align:right; padding-top:22px;"">
              <label><b>Product Groups:</b></label>
          </td>
          <td style="width:150px; text-align:left;">
         <select name="ProductId" id="ProductGroupId" style="width: 190px; margin-top: 10px;" class="col-md-12" required="required">
                <option value="0">Select ProductGroup</option>
                <?php foreach ($GetAllProductGroups as $ProductGroups) {
                ?>
                <option value="<?php echo $ProductGroups['ProductGroupId'] ?>"><?php echo $ProductGroups['ProductGroupName']; ?></option>
                <?php
                } ?>
              </select>
          </td>

            <td style="text-align:right; padding-top:22px;">
              <label><b>Start Date:</b></label>
            </td>
            <td>
	    <input type="date" style="width:190px; margin-top: 10px; margin-left: 20px;" name="StartDate" id="StartDate" data-date="01-02-2013" data-date-format="dd-mm-yyyy" value="<?php //echo date("d-m-Y"); ?>" class="span11" autocomplete="off">
            </td>

          <td style="width: 110px; text-align:right; padding-top:22px;">
              <label><b>End Date:</b></label>
          </td>
          <td style="padding-top:15px;">
	  <input type="date" style="width:190px; margin-top: 10px; margin-left: 20px;" name="EndDate" id="EndDate" data-date="01-02-2013" data-date-format="dd-mm-yyyy" value="<?php //echo date("d-m-Y"); ?>" class="span11" autocomplete="off">
          </td>
          
          <td style="width: 190px; text-align:left; padding-top:15px;">
              <button type='submit' id="submit" class='btn btn-primary bg-primary' name='ShowReport'>Show Report</button>
          </td>
          <td style="padding-top:15px;">
          </td>

          
        </tr>

       
</table>

          </div>
            <div class="span12" id="result" style="border:0px solid;">
              <!----- result to be displayed here -------->
            </div>

            </div>
          </div>  <!----- end of span tag ----->
          </div>  <!----- end of span tag ----->


        </div>

  <div class="pull-left" style="background-color: #FFFFFF;">
   <span class="span12">
   </span>
  </div>

<?php $this->load->view('admin/includes/footer'); ?>

<script>
  $(function() {
    
     $('body').on('click', '#submit', function(){
      var CompanyId = $("#CompanyId").val();
      var ProductId = $("#ProductId").val();
      var BrandId = $("#BrandId").val();
      var ProductGroupId = $("#ProductGroupId").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

     window.open("<?php echo site_url(); ?>StockReports/ViewStockQuantityReport?CompanyId="+CompanyId+"&ProductId="+ProductId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,");
     
    });
  })
</script>