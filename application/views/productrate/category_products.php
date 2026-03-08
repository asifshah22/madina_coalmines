  <!-- jQuery 2.2.3 -->
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css">

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/select2/select2.min.css">
  <script src="<?php echo base_url(); ?>plugins/select2/select2.min.js" type="text/javascript" charset="utf-8" async defer></script>
  

<div class="form-group">
	<label for="inputProductId" class="col-sm-1 control-label">Product:</label>
	<div class="col-sm-4">
		<select name="ProductId" id="ProductId" class="form-control select2" required="required" style="width:100%">
			<option value="0"> Select Product</option>
			<?php foreach ($GetCategoryProducts as $CategoryProducts) {
			?>
			<option value="<?php echo $CategoryProducts['ProductId'] ?>"> <?php echo $CategoryProducts['ProductName']; ?></option>
			<?php
			} ?>
		</select>
	</div>
</div>