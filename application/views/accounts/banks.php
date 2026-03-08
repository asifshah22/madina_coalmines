          <?php $i=0;  foreach($GetAllBanks as $row){?>
            <div class="row">
            <div class="box-body">
                <div class="col-xs-1">  
                    <?php echo ++$i;?>
                </div>
                <div class="col-xs-4">
                    <input type="text" id="BankName_<?php echo $row['BankId']?>" class="form-control" value="<?php echo $row['BankName']?>" >
                </div>
                <div class="col-xs-2">
                  <input type="text" id="BankAbb_<?php echo $row['BankId']?>" class="form-control" value="<?php echo $row['BankAbbreviation']?>" >
                </div>
                <div class="col-xs-2">
                    <span id="BankEdit_<?php echo $row['BankId']?>" style=" cursor: pointer; cursor: hand;" class="fa fa-edit">update</span>
                </div>
                <div class="col-xs-2">
                 <?php if($row['Status'] == 1){?>
                    <span id="BankStatus_<?php echo $row['BankId']?>" style=" cursor: pointer; cursor: hand;" class="">active</span>
                 <?php }else{ ?>
                        <span id="BankStatus_<?php echo $row['BankId']?>" style=" cursor: pointer; cursor: hand;" class="">deactive</span>
                 <?php } ?>
                </div>
            </div>
          </div>
           <?php }?>
             <div class="row">
            <div class="box-body">
                <div class="col-xs-1">  
                </div>
                <div class="col-xs-4">
                    <input type="text" id="NewBankName" class="form-control"  >
                </div>
                <div class="col-xs-2">
                  <input type="text" id="NewBankAbb" class="form-control"  >
                </div>
                <div class="col-xs-2">
                    <span class=""></span>
                </div>
                <div class="col-xs-2">
                 <span class="fa fa-edit"></span>
                </div>
            </div>
          </div>
