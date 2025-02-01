<script type="text/javascript">
    function confirmDelete(encodedId) {
        Swal.fire({
            title: 'Are you sure you want to delete this data?',
            text: "You won't be able to undo this action!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete_account.php?id=" + encodeURIComponent(encodedId);
            }
        });
    }
</script>
