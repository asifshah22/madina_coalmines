 <script src="<?php echo base_url(); ?>lib/js/jquery-3.2.1.min.js"> </script>
        <script>
            $(document).ready(function(){
              $('#datetimepicker2').datetimepicker({
              yearOffset:222,
              lang:'en',
              timepicker:true,
              format:'d/m/Y',
              formatDate:'Y/m/d',
              minDate:'-1970/01/02', // yesterday is minimum date
              maxDate:'+1970/01/02' // and tommorow is maximum date calendar
            });

            });
        </script>

	        <div style="border:0px solid;" class="col-md-8">
                 <div id="show_report_criteria">
                   
                   <div style="border:0px solid; width:60%; margin-left:190px;" class="box-header with-border">
                   <h3 class="box-title text-light-blue">Stock Activity Report Criteria</h3>
               	   </div><br>
                    <div class="form-group">
                     <label style="width:24%;" for="Employee" class="col-sm-3 control-label">Company:</label>
		                    <div class="input-group date" style="width: 76%">
                         <select class="select2 form-control" id="CompanyId" name="CompanyId">
                         <option value="0">Select Company</option>
                                <?php foreach ($AllCompanies as $Company) {
                                ?>
                                <option value="<?php echo $Company['CompanyId'] ?>"><?php echo $Company['CompanyName']; ?></option>
                                <?php
                                } ?>
                         </select>
	                      </div>
                    </div>

                    <div class="form-group">
                     <label style="width:24%;" for="Institute" class="col-sm-3 control-label">Product:</label>
                        <div class="input-group date" style="width: 76%">
                         <select class="select2 form-control" id="ProductId" name="ProductId">
                            <option value="0">Select Product</option>
                            <?php foreach ($AllProducts as $row) {
                            ?>
                            <option value="<?php echo $row['ProductId'] ?>"><?php echo $row['ProductName']; ?></option>
                            <?php
                            } ?>
                         </select>
                        </div>
                    </div>

                    <div class="form-group">
                     <label style="width:24%;" for="Institute" class="col-sm-3 control-label">Brand:</label>
                        <div class="input-group date" style="width: 76%">
                         <select class="select2 form-control" id="BrandId" name="BrandId">
                            <option value="0">Select Brand</option>
                            <?php foreach ($AllBrands as $Brand) {
                            ?>
                            <option value="<?php echo $Brand['BrandId'] ?>"><?php echo $Brand['BrandName']; ?></option>
                            <?php
                            } ?>
                         </select>
                        </div>
                    </div>

                    <div class="form-group">
                     <label style="width:24%;" for="Institute" class="col-sm-3 control-label">Product Group:</label>
                        <div class="input-group date" style="width: 76%">
                         <select class="select2 form-control" id="ProductGroupId" name="ProductGroupId">
                            <option value="0">Select Product Group</option>
                            <?php foreach ($AllProductGroups as $row) {
                            ?>
                            <option value="<?php echo $row['ProductGroupId'] ?>"><?php echo $row['ProductGroupName']; ?></option>
                            <?php
                            } ?>
                         </select>
                        </div>
                    </div>

                   <div class="form-group">
                     <label for="StartDate" class="col-sm-3 control-label">Start Range:</label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>                  
        		              <input class="form-control" name="StartDate" id="StartDate" type="date" placeholder="Enter Start Date" class="" autocomplete="off">
                       </div>                  
                   </div>

                   <div class="form-group">
                     <label for="EndDate" class="col-sm-3 control-label">End Range:</label>
                       <div class="input-group date">
                         <div class="input-group-addon">
                           <i class="fa fa-calendar"></i>
                         </div>     
                         <input class="form-control" name="EndDate" id="EndDate" type="date" placeholder="Enter Start Date" value="" autocomplete="off">
                       </div>                  
              	   </div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>                          
                   <div class="form-group">
                     <label style="width:24%;" class="col-sm-2"></label>
                       <div class="input-group date">
                         <button type="button" id="submit" class="btn  btn-primary">Show Report</button>
                       </div>                  
                   
                      </div> <!-- end of col-6-->
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>

                  </div><!-- end of col 4 --->
                                            <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>

                  </div>

<script>
  $(function() {
    $('body').on('click', '#submit', function(){
      var CompanyId = $("#CompanyId").val();
      var ProductId = $("#ProductId").val();
      var BrandId = $("#BrandId").val();
      var ProductGroupId = $("#ProductGroupId").val();
      var StartDate = $("#StartDate").val();
      var EndDate = $("#EndDate").val();

      window.open("<?php echo site_url(); ?>Stocks/ViewStockQuantityReport?ProductId="+ProductId+"&CompanyId="+CompanyId+"&BrandId="+BrandId+"&ProductGroupId="+ProductGroupId+"&StartDate="+StartDate+"&EndDate="+EndDate,"Ratting","width=1100,height=450,left=150,top=200,toolbar=0,status=0,Title=Stock Balance Report");

    });       /////// end of button click    //////

  })          //////// end of main jQuery function ////////
</script>