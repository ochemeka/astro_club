<footer style="background-color:#272e48; border-color:#272e48" class="main-footer">
<div align="center" style="color:#FFFFFF;">
    <strong>&copy; <?php echo date("Y"); ?> Lekki Astro Sports Club. All rights reserved.</strong>
</div>
</footer>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>

<?php
$flashData = null;
if (isset($_SESSION['flash'])) {
    $flashData = $_SESSION['flash'];
    unset($_SESSION['flash']);
}
?>
<?php if ($flashData): ?>
<script>
(function() {
  var flash = <?php echo json_encode($flashData); ?>;
  if (flash && flash.message) {
    var div = document.createElement('div');
    div.className = 'alert alert-' + (flash.type === 'error' ? 'danger' : flash.type) + ' alert-dismissible';
    div.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:300px;max-width:500px;box-shadow:0 4px 12px rgba(0,0,0,0.15);';
    div.innerHTML = flash.message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    document.body.appendChild(div);
    setTimeout(function(){ if(div.parentNode) div.parentNode.removeChild(div); }, 5000);
  }
})();
</script>
<?php endif; ?>
</body>
</html>
