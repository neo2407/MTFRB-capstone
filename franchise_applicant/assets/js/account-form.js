function handleResize() {
    const navModal = document.getElementById('navModal');
    if (window.innerWidth >= 992 && navModal.classList.contains('show')) {
        const modalInstance = bootstrap.Modal.getInstance(navModal);
        modalInstance.hide();
    }
}

window.addEventListener('resize', handleResize);
handleResize();





var contactNum = document.getElementById('contactNum');
contactNum.addEventListener('contactNum', function () {
    this.value = this.value.replace(/[^\d]/g, '');
    if (!/^\d+$/.test(this.value)) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});


function fileValidation() {
    var fileInput = document.getElementById('file');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.png|\.jpg|\.jpeg)$/i;
    var fileSize = fileInput.files[0].size / 1024 / 1024; // Size in MB

    if (!allowedExtensions.exec(filePath)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid file type',
            text: 'Please upload an image file (png, jpg, jpeg).',
        });
        fileInput.value = '';
        return false;
    } else if (fileSize > 2) {
        Swal.fire({
            icon: 'error',
            title: 'File too large',
            text: 'The file size exceeds the 2MB limit.',
        });
        fileInput.value = '';
        return false;
    } else {
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = 
                    '<div style="position: relative; display: inline-block;">' +
                    '<img src="' + e.target.result + '" style="max-width: 150px; max-height: 150px;" />' +
                    '<button onclick="deleteImage(\'file\')" style="position: absolute; top: 0; right: 0; background: red; color: white; border: none; border-radius: 50%;">X</button>' +
                    '</div>';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
}


function deleteImage(inputId) {
    var inputElement = document.getElementById(inputId);
    var previewContainer = document.getElementById('imagePreview');
    
    if (inputElement) {
        inputElement.value = '';
    }
    
    if (previewContainer) {
        previewContainer.innerHTML = '';
    }
}
