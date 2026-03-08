
<script src="<?php echo base_url(); ?>lib/js/app.min.js"></script>
<!-- bootstrap datepicker -->
<script src="<?php  echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- Select2 -->
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
 <script type="text/javascript" language="javascript">

$(function () {
//Initialize Select2 Elements
$(".select2").select2();
 });
//Date picker
    $('input[id^=datepicker]').datepicker({
      autoclose: true
    });

</script>




<!-- Optionally, you can add Slposcroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slposcroll is required when using the
     fixed layout. -->
</body>
</html>