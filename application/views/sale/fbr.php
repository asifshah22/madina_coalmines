<html>
  <head>
  <script src="<?php echo base_url(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>

  </head>
</html>
  <!-- /.content-wrapper -->
<?php $this->load->view('includes/footer'); ?>

  <script>

 var settings = {
   url: "https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData",
   method: "POST",
   timeout: 0,
   headers: {
      "User-Agent": "Apidog/1.0.0 (https://apidog.com)",
      "Content-Type": "application/json",
      "Authorization": "Bearer 8fd23dc4-f093-3c4f-a0e1-17d3f75e9bfa"
   },
  data: JSON.stringify(<?php echo $jsonData ?>)
};

$.ajax(settings).done(function (response) {
   console.log("FBR API Response:", response);

   // ✅ Trigger backend API to update status
   $.ajax({
      url: "<?php echo base_url('Sales/update_fbr_status').'/'.$SaleId?>", // Your CodeIgniter controller method
      method: "POST",
      data: response,
      success: function (result) {
            window.location.href = "<?php echo base_url('Sales') ?>";
         console.log("Status updated in DB:", result);
      },
      error: function (xhr, status, error) {
         console.error("Failed to update status:", error);
      }
   });
});

 
</script>