<script src="assets/js/jquery-3.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/swal.js"></script>
<script src="assets/bootstrap-4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<script>
    $(document).ready(function() {
        $('.only-num').keypress(function(event) {
            if (event.keyCode == 46 || event.keyCode == 8) {

            } else {
                if (event.keyCode < 48 || event.keyCode > 57) {
                    event.preventDefault();
                }
            }
        });

        <?php if($smsg || $emsg || $imsg): ?>
        swal({
            text: "<?php if($smsg || $emsg  || $imsg){echo $smsg.$emsg.$imsg ;} ?>",
            icon: "<?php if($smsg){echo 'success';}elseif($emsg){echo 'error';} else{echo 'info'; } ?>",
            buttons: false,
            timer: 5000

        });
        <?php endif ?>
    });

</script>
