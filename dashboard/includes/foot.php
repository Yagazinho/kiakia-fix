</div>
</div>

<script src="../assets/js/jquery-3.js"></script>
<script src="../assets/js/popper.min.js"></script>
<script src="../assets/js/swal.js"></script>
<script src="../assets/bootstrap-4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/sl-1.5.0/datatables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.datatable').DataTable();

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
</body>

</html>
