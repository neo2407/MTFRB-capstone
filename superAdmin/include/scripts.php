<!-- Pop up Message -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php 
if (isset($_SESSION['status']) && $_SESSION['status_code'] != '') { 
?>
    <script>
        Swal.fire({
            title: "<?php echo $_SESSION['status']; ?>",
            icon: "<?php echo $_SESSION['status_code']; ?>",
            button: "OK",
        });
    </script>   
<?php
    unset($_SESSION['status']);
}
?>
