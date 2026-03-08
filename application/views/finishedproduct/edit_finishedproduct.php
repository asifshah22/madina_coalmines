<?php 
$this->load->view('includes/header');
$this->load->view('includes/sidebar');

$ProductQuality = '<select name="ProductQualityId[]" class="form-control select2" style="width:100%; text-align:left;" required="required">';
$ProductQuality .= '<option value="">Select Quality</option>';
foreach ($ProductQualities as $ProductQualitiesRecord) {
$ProductQuality .= '<option value='.$ProductQualitiesRecord['ProductQualityId'].'>'.$ProductQualitiesRecord['ProductQuality'].'</option>';
}
$ProductQuality .= '</select>';
?>
<script src="<?=site_url();?>lib/js/autocompletejs/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
   
    $('body').on("keyup",".txtMult input", multInputs);

    function multInputs() {

     var $Weight = 0;
     var WeightVal = 0;
     var TWeight = 0;
     
     $('tr.txtMult').each(function () {

      $Weight = $('.Weight', this).val();
      WeightVal = (isNaN(parseInt($Weight))) ? 0 : parseInt($Weight);
      TWeight += WeightVal;
     });
	
    $('#TotalWeight').text(TWeight);
    }
  });
 </script>


 <script type="text/javascript">
  $(function()
  {
       // remove row
       $(document).on('mouseover','span[id^=remove]',function(){
       $(this).css({"cursor":"pointer"}); 
       });
        
       $(document).on('click','span[id^=remove]',function(){
       removeId = $(this).attr('id');
       arr = removeId.split("_");
       
       // parent.fadeOut('slow', function() {$(this).remove();});
       // $(this).parent().parent().fadeOut('slow')
        $(this).parent().parent().remove()
       })
  });
 </script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-clipboard"></i>&nbsp;Finished Products</h1>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">Update Finished Products</h3>
            </div>
	    <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
	    
            <form role="form" id="FinishedProductsForm" action='<?php echo base_url("FinishedProducts/UpdateFinishedProduct") ?>' method="post">
	    
	    <div class="box-body">
	      <div class="row invoice-info">
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Production #:</strong><br>
		    <input class="form-control" name="ProductionNo" type="text" style="width:37%; height:29px;" value="<?php echo $FinishedProducts[0]['ProductionNo']; ?>" autocomplete="off">
		  </address>
		</div>
		<input type="hidden" name="FinishedProductId" value="<?php echo $FinishedProducts[0]['FinishedProductId']; ?>">
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Finished Date:</strong><br>
		    <input class="form-control" name="FinishedDate" id="datepicker" type="text" style="width:37%; height:29px;" value="<?php print date('M d, Y', strtotime($FinishedProducts[0]['FinishedDate'])); ?>" autocomplete="off">
		  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Product:</strong><br>
		    <select name="ProductId" class="form-control select2" style="width:37%; text-align:left;" required="required">
			<option value="">Select Product</option>
			<?php foreach ($Products as $ProductRecord) { ?>
			<option <?php if($FinishedProducts[0]['ProductId'] == $ProductRecord['ProductId']){ echo 'selected=selected';} else{ '' ; } ?> value="<?php echo $ProductRecord['ProductId']; ?>"><?php echo $ProductRecord['ProductName'];?></option>
			<?php } ?>
		      </select>
                  </address>
		</div>
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Mill Serial #:</strong><br>
		    <input class="form-control" name="MillSerialNo" type="text" style="width:37%; height:29px;" value="<?php echo $FinishedProducts[0]['MillSerialNo']; ?>" autocomplete="off">
		  </address>
		</div>
		
		<div class="col-sm-6 invoice-col">
		  <address>
		    <strong>Shift:</strong><br>
		    <input class="form-control" name="Shift" type="text" style="width:37%; height:29px;"autocomplete="off" value="<?php print $FinishedProducts[0]['Shift']; ?>">
		  </address>
		</div>
	      </div>
	    <?php
		$SNo=1;
		$TotalWeight = '';

	    ?>
            <div class="row">
		<div class="col-md-12">
		  <div class="box-body pad table-responsive">
		    <table class='table table-bordered text-center' id="Purchase_EntriesTable">
		     <tr style="background-color:#ECF9FF;">
		      <th style="padding:5px;">S.#</th>
		      <th style="padding:5px;">Product Quality</th>
		      <th style="padding:5px; text-align:center;">Reel Size</th>
		      <th style="padding:5px; text-align:center;">Quantity</th>
		      <th style="padding:5px; text-align:center;">Weight</th>
		      <th style='padding:5px; text-align:center;'><span class='fa fa-trash'></span></th>
		     </tr>
 			<?php
 			  $SNo = 1;
		      $TotalQuantities = 0;
		      foreach($FinishedProductsDetail as $Record) {
	     	?>
	    	    <tr class="txtMult">
		    <td style='padding:5px; width:2%;'><?php echo $SNo; ?></td>
		    <td style='padding:5px; width:8%;'>
		    <select name="ProductQualityId[]"  class="form-control" style="width:100%; text-align:left;" required="required">
		    <option selected="selected" value="">Select Quality</option>
		    <?php foreach ($ProductQualities as $ProductQualitiesRecord) { ?>
		    <option <?php if($ProductQualitiesRecord['ProductQualityId'] == $Record['ProductQualityId']){ echo 'selected=selected'; } ?> value="<?php echo $ProductQualitiesRecord['ProductQualityId']; ?>"><?php echo $ProductQualitiesRecord['ProductQuality'];?></option>
		    <?php } ?>
		    </select>
		    </td>
		    <td style='padding:5px; width:5%;'><input type="number" step="0.01" style="width:100%; text-align:right;" name="ReelSize[]" id="ReelSize_<?php echo $SNo; ?>" autocomplete='off' value="<?php echo $Record['ReelSize']; ?>"></td>
		    <td style='padding:5px; width:5%;'><input type='number' style='width:100%;text-align:right;' name='Quantity[]' class='Quantity' id='Quantity_<?php echo $SNo; ?>' autocomplete='off' value="<?php echo $Record['Quantity']; ?>"></td>
		    <td style='padding:5px; width:5%;'><input type='number' style='width:100%;text-align:right;' name='Weight[]' class='Weight' id='Weight_<?php echo $SNo; ?>' autocomplete='off' value="<?php echo $Record['Weight']; ?>"></td>
		    <td style="padding:5px; width:2%;">
		    <span style='color:red;' id='remove_".$SNo."' class='fa fa-times-circle'></span>
		    </td>
		    </tr>
		     <?php $SNo++;
 		     $TotalQuantities += $Record['Quantity'];
		     $TotalWeight += $Record['Weight'];
		     } ?>
		     </table>
		     <input type="hidden" name="counter" id="counter_" class="form-control" value="<?php echo $SNo; ?>">
		     <table class="table table-bordered text-center">
		     <tr>
		      <td colspan="6" style=" text-align:left;"><span style="cursor:pointer;" id="addRow" class="fa fa-plus">Add New Row</span></td>
		     </tr>
		     <tr>
			 <td colspan="4" style="width:19%; text-align:right; font-weight:600;">Total Weight</td>
		      <td style="width:4%;"><div id="TotalWeight" style='font-weight:600; color:#3333CC; text-align:right;'><?php echo $TotalWeight; ?></div></td>
		      <td style="width:1.5%;"></td>
		     </tr>
	
		    </table>
		  </div>
		</div>
	      </div>
	      <?php // } ?>	
	      <div class="box-body">
		<div class="row">
		  <!-- <div class="col-md-12">
		    <div class="form-group">
		      <label for="FinishedProductsNote" class="col-sm-2 control-label">FinishedProducts Note:</label>
		  		<div class="input-group">
		  		<textarea name="FinishedProductsNote" class="form-control" rows="2" cols="60"></textarea>
		      </div>
		    </div>
		  </div> -->
		  <div class="col-md-2">
		    <button type="submit" name="submitForm" value="AddRecord" class="btn btn-block btn-primary">Update Record</button>
		  </div>
		  <div class="col-md-2">
		    <a href="<?php echo base_url(); ?>FinishedProducts/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block bg-orange">Back to main</button></a>
		  </div>
		</div>
	      </div>
            </div>
            </form>
        </div>
      </div>
    </div> 
  </section>
  </div>
 <script>
 /*  $(function(){
      
     $("#FinishedProductsForm").on("submit",function(e){
	
      $("input[id^=hdnProductId]").each(function(){
       var arr = $(this).attr("id").split("_");
       var hdnProductId = $(this).val();
       if(hdnProductId == '' )
       {
	    e.preventDefault()
	    alert("Please ReEnter Product Name");
	    $("#ProductId_"+arr[1]).focus();
	    return false 
       }
      });
    })
  }) */
</script>
 <script>
 $(function(){
 
      // Add New Row class="txtMult"
    $("#addRow").on("click",function(){
    var txtId = $("input[id^=Quantity_]:last").attr("id");
    var arr = txtId.split("_");
    var nextTxtId = (parseInt(arr[1]) +1);
     
    $("#Purchase_EntriesTable").append('<tr class="txtMult"><td style="padding:5px; width:2%;">'+nextTxtId+'</td><td style="padding:5px; width:10%;"><?php echo $ProductQuality; ?></td><td style="padding:5px; width:5%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="ReelSize[]" id="ReelSize_'+nextTxtId+'" autocomplete="off"></td><td style="padding:5px; width:5%;"><input type="number" style="width:100%;text-align:right;" name="Quantity[]" class="Quantity" id="Quantity_'+nextTxtId+'"  autocomplete="off"></td><td style="padding:5px; width:10%; text-align:left;"><input type="text" class="Weight" name="Weight[]" id="Weight_'+nextTxtId+'" autocomplete="off" style="width:100%;text-align:right;"></td><td style="padding:5px; width:2%;"><span style="color:red;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span></td></tr>');
	
      })	
  });
 </script>
 <script>
 /* $(function(){
 
    $("#addRow").on("click",function(){
    var txtId = $("input[id^=ReelSize]:last").attr("id");
    var arr = txtId.split("_");
    nextTxtId = (parseInt(txtId) +1);

     
    $("#Purchase_EntriesTable").append('<tr class="txtMult"><td style="padding:5px; width:2%;">'+nextTxtId+'</td><td style="padding:5px; width:10%; text-align:left;"><input type="text" class="form-control" name="ProductId[]" id="ProductId'+nextTxtId+'" autocomplete="off"><input type="hidden" id="hdnProductId'+nextTxtId+'" name="hdnProductId[]"></td><td style="padding:5px; width:5%;"><?php echo $ProductQuality; ?></td><td style="padding:5px; width:5%;"><input type="number" step="0.01" style="width:100%; text-align:right;" name="ReelSize[]" id="ReelSize_'+nextTxtId+'" autocomplete="off"></td><td style="padding:5px; width:5%;"><input type="number" style="width:100%;text-align:right;" name="Quantity[]" class="Quantity" id="Quantity_'+nextTxtId+'"  autocomplete="off"></td><td style="padding:5px; width:2%;"><span style="color:red;" id="remove_'+nextTxtId+'" class="fa fa-times-circle"></span></td></tr>');
	
      })	
  });
  */
 </script>
 <script>
 $(function(){
     
  // Autocomplete Search Product Name
  $(document).on('keyup','input[id^=ProductId]',function(){
    
    var ProductId = ($(this).attr('id'));
    var  ProductName= $(this).val();
    
    $(this).autocomplete({
    
    source: function(request, response) {
    $.ajax({
        url: "<?php echo site_url('FinishedProducts/AutoCompleteSearch_ProductName')?>",
        data: { ProductName:ProductName},
        dataType: "json",
        type: "POST",
        success: function(data) {
        //console.log(data);
        response(data);
        }
     });
    },
     select: function (event, ui) {
     $(this).val(ui.item.value); // display the selected text
     $("#hdn"+ProductId).val(ui.item.id); // save selected id to hidden input
    },
    minLength: 2
     });    
    });
  });
 </script>
<?php $this->load->view('includes/footer'); ?>