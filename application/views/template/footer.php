<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.1
    </div>
    <strong>Copyright &copy; 2019-2020 <a>Toko Anis.</a></strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="<?php echo base_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>bower_components/jquery-ui/jquery-ui.min.js"></script>

<!-- Ekstensi javascript ditaruh disini -->
<?php if(isset($js_file)) { ?>
<?php foreach ($js_file as $file):?>

        <script src="<?php echo $file;?>"></script>

<?php endforeach;?>
<?php } ?>
<!-- Batas letak Ekstensi javascript-->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap to -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<?php if( isset($data) ) { ?>
<script>
	var JUMLAHdata = $('section.content table').children('tbody').children().length;
	$('#ket-index-data strong')[0].innerHTML = JUMLAHdata;
</script>
<?php } ?>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
</body>
</html>