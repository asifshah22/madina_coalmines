<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-file-o"></i>&nbsp;Log</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">           
          <div class="box box-info">
           <!-- <div class="box-header"></div> -->
            <!-- /.box-header -->
             <div class="box-body">
             <table id="log-grid" class="table table-striped" class="table table-bordered table-striped" cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
              <thead>
                <tr>
                  <th>S.#</th>
                  <th>File Name</th>
                  <th>Download</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $dir = getcwd()."/logs";
                    if(is_dir($dir)){
                        $dir_handle = opendir($dir);
                        $SNo = 1;
                        while(($file=readdir($dir_handle))!==false){
                        if($file=="." || $file==".."){
                          continue;
                        }
                        ?>
                        <tr>
                          <td><?php echo $SNo; ?></td>
                          <td><?php echo $file; ?></td>
                          <td><?php echo "<a href='../logs/".$file."' download> ".$file."</a><br />"; ?></td></tr>
                          <?php
                          }
                      }

                ?>
              </tbody>
            </table>
            <!-- /.box-body -->
          </div>
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
<?php $this->load->view('includes/footer'); ?>


