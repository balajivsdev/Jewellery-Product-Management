<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>
<script src="<?=base_url('assets/js/jquery.toast.js')?>"></script>

<?php 
$session = \Config\Services::session();
?>

<script>
<?php if ($session->getFlashdata('message')): ?>
    $.toast({
        heading: 'Success',
        text: '<?= esc($session->getFlashdata('message')) ?>',
        position: 'top-right',
        loaderBg: '#0c4170',
        icon: 'success',
        hideAfter: 5000,
        stack: 6
    });
<?php endif; ?>

<?php if ($session->getFlashdata('error')): ?>
    $.toast({
        heading: 'Error',
        text: '<?= esc($session->getFlashdata('error')) ?>',
        position: 'top-right',
        loaderBg: '#ff6849',
        icon: 'error',
        hideAfter: 5000,
        stack: 6
    });
<?php endif; ?>

<?php if ($session->getFlashdata('errors')): 
    $errors = $session->getFlashdata('errors');
    foreach ($errors as $error): ?>
        $.toast({
            heading: 'Validation Error',
            text: '<?= esc($error) ?>',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 5000,
            stack: 6
        });
<?php endforeach; endif; ?>
</script>

<script>
$(document).ready(function() {
    $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('product/fetchProducts') ?>",
            type: 'POST'
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'description' },
            { data: 'price' },
            { data: 'category_name' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            'colvis'
        ]
    });
});
</script>




</body>
</html>
