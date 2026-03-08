  <div class="form-group">
                  <label for="BankId" class="col-sm-1 control-label"> Bank Name:</label>
                   <div class="col-sm-4">
                       <select class="form-control" name="BankId" id="BankId">
                          <option value="0">-- Select Bank --</option>
                            <?php
                           foreach($GetAllBanks as $row){
                               ?>
                           <option value="<?php echo $row['BankId'] ?>" <?php if(isset($GetAccount)){if($GetAccount->BankId == $row['BankId']) echo "selected=selected";}  ?>   ><?php echo $row['BankName'].'('.$row['BankAbbreviation'].')'?></option>
                           <?php
                           }
                           ?>
                       </select>
                   </div><spn style=" cursor: pointer; cursor: hand;" id ='addBank' class='fa  fa-plus' data-toggle="modal" data-target="#exampleModal" data-whatever=""></spn>
                </div>
      
