<script>
    document.getElementById('edit-icon').addEventListener('click', function() {
        let fields = document.querySelectorAll('.editable-fields input:not(.readonly-field)');
        fields.forEach(field => {
            if (field.hasAttribute('readonly')) {
                field.removeAttribute('readonly');
                field.style.backgroundColor = "#fff"; // Optional: change background color to indicate edit mode
            } else {
                field.setAttribute('readonly', 'readonly');
                field.style.backgroundColor = ""; // Reset background color
            }
        });
    });
 </script>

