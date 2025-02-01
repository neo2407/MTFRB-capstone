// Function to hide the modal if the window width is greater than or equal to 992px
function handleResize() {
    const navModal = document.getElementById('navModal');
    if (window.innerWidth >= 992 && navModal.classList.contains('show')) {
        const modalInstance = bootstrap.Modal.getInstance(navModal);
        modalInstance.hide();
    }
}
// Event listener for window resize
window.addEventListener('resize', handleResize);

// Initial check in case the window is already large when the page loads
handleResize();




// Validation to Application Form
function fileValidation(input) {
    var filePath = input.value;
    var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type');
        input.value = '';
        return false;
    } else {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var previewId = 'preview' + input.id.slice(-1);
                var previewContainer = document.getElementById(previewId);
                previewContainer.innerHTML = `
                    <div class="image-preview">
                        <img src="${e.target.result}" alt="Image Preview"/>
                        <button type="button" class="delete-button" onclick="deleteImage('${input.id}')">X</button>
                    </div>
                `;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
}

function deleteImage(inputId) {
    var inputElement = document.getElementById(inputId);
    var previewId = 'preview' + inputId.slice(-1);
    var previewContainer = document.getElementById(previewId);
    inputElement.value = '';
    previewContainer.innerHTML = '';
}

function validateForm() {
    var isValid = true;
    var inputs = document.querySelectorAll('#applicationForm input[type="text"], #applicationForm input[type="file"]');
    inputs.forEach(function (input) {
        if (input.type === "file" && input.files.length === 0) {
            isValid = false;
            input.classList.add('error');
        } else if (input.value.trim() === "") {
            isValid = false;
            input.classList.add('error');
        } else {
            input.classList.remove('error');
        }
    });

    var checkbox = document.getElementById('privacyActCheck');
    if (!checkbox.checked) {
        isValid = false;
        document.getElementById('formErrorMessage').style.display = 'block';
    } else {
        document.getElementById('formErrorMessage').style.display = 'none';
    }

    if (isValid) {
        document.getElementById('applicationForm').submit();
    } else {
        document.getElementById('formErrorMessage').style.display = 'block';
    }
}

