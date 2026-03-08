  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-file-text-o"></i>&nbsp;Stock Status <h1>
    </section> 
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
           
          <div class="box">
           <!-- /.box-header -->
            <div class="box-body no-padding">
              <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_added')."</font>"; ?>
              <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_delete')."</font>"; ?>
              <table  class="table table-striped" >
                <thead>
                  <tr>
                  <th>Product Group Name </th>
                  <th>Product Name</th>
                  <th>Product Quantity</th>
                  <th>Last Update Date</th>
                  
                </tr>
               </thead>
               <tbody>
                <?php
                if(isset($RemaingStock['record']))
                {
                
                foreach($RemaingStock['record'] as $row)
                {
                ?>
                   <tr>
                        <td><?php echo $row['ProductGroupName']; ?></td>
                        <td><?php echo $row['BrandName']; ?></td>
                        <td><?php echo $row['ProductQuantity']; ?></td>
                        <td><?php echo $row['LastUpdateDate'];  ?></td>
                       
                   <tr>
                <?php
                }
                }
                ?>       
               </tbody>
             </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->
<script>
$(function(){
    $("button[id^=CRN]").on("click",function(){
        alert($(this).attr('id'));
    });
})
</script>
  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2017 <a href="#">Company Name</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->