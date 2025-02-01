   let currentStep = 1;

function showStep(step) {
    document.querySelectorAll('.step-content').forEach((element, index) => {
        element.style.display = (index + 1 === step) ? 'block' : 'none';
    });
    updateButtons(step);
}

function nextStep() {
    if (validateStep(currentStep)) {
        if (currentStep < 2) {
            currentStep++;
            showStep(currentStep);
        }
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

function updateButtons(step) {
    const prevBtn = document.getElementById('step1BackBtn');
    const nextBtn = document.getElementById('step1NextBtn');

    if (!prevBtn || !nextBtn) {
        console.error('One of the buttons is not found in the DOM');
        return;
    }

    prevBtn.disabled = (step === 1);
    nextBtn.innerText = (step === 2) ? 'Submit' : 'Next';
}

function validateStep(step) {
    let isValid = true;
    let errorMessage = '';

    if (step === 1) {
        const requiredFields = ['last_name', 'first_name', 'm_name', 'age', 'contact_num', 'street', 'tricColor', 'd1_last_name', 'd1_first_name', 'd1_m_name', 'license_no'];
        let missingFields = false;

        requiredFields.forEach((name) => {
            const input = document.querySelector(`[name="${name}"]`);
            if (!input.value.trim()) {
                missingFields = true;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        const tricType = document.querySelector('[name="tricType"]');
        if (!tricType.value) {
            missingFields = true;
            tricType.classList.add('is-invalid');
        } else {
            tricType.classList.remove('is-invalid');
        }

        const toda = document.querySelector('[name="toda"]');
        if (!toda.value) {
            missingFields = true;
            toda.classList.add('is-invalid');
        } else {
            toda.classList.remove('is-invalid');
        }

        const brgy = document.querySelector('[name="brgy"]');
        if (!brgy.value) {
            missingFields = true;
            brgy.classList.add('is-invalid');
        } else {
            brgy.classList.remove('is-invalid');
        }

        const sexRadioButtons = document.querySelectorAll('[name="sex"]');
        const sexSelected = [...sexRadioButtons].some(radio => radio.checked);
        if (!sexSelected) {
            missingFields = true;
            sexRadioButtons.forEach(radio => radio.classList.add('is-invalid'));
        } else {
            sexRadioButtons.forEach(radio => radio.classList.remove('is-invalid'));
        }

        const licenseExp = document.querySelector('[name="license_exp"]');
        if (!licenseExp.value.trim()) {
            missingFields = true;
            licenseExp.classList.add('is-invalid');
        } else {
            licenseExp.classList.remove('is-invalid');
        }

        if (missingFields) {
            errorMessage += 'Please fill out all required fields in before clicking next';
            isValid = false;
        }
    } else if (step === 2) {
        const requiredFiles = ['or', 'cr', 'tricyclePics', 'operatorsPic', 'valid_id', 'driversPic1', 'license'];
        let missingFiles = false;

        requiredFiles.forEach((id) => {
            const fileInput = document.getElementById(id);
            if (fileInput.files.length === 0) {
                missingFiles = true;
                fileInput.classList.add('is-invalid');
            } else {
                fileInput.classList.remove('is-invalid');
            }
        });

        if (missingFiles) {
            errorMessage += 'Please upload all required files before submitting';
            isValid = false;
        }
    }

    if (!isValid) {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: errorMessage
        });
    }

    return isValid;
}

const previewMapping = {
    'or': 'preview1',
    'tricyclePics': 'preview2',
    'deedSale': 'preview2',
    'cr': 'preview3',
    'operatorsPic': 'preview4',
    'valid_id': 'preview5',
    'license': 'preview6',
    'driversPic1': 'preview7',
};

function fileValidation(input) {
    const allowedExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
    const maxSizeMB = 5; // Maximum file size in megabytes
    const file = input.files[0];

    if (file) {
        const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to megabytes
        if (fileSizeMB > maxSizeMB) {
            Swal.fire({
                icon: 'error',
                title: 'File Size Exceeded',
                text: `The file size exceeds the ${maxSizeMB}MB limit. Please choose a smaller file.` // Use maxSizeMB here
            });
            input.value = '';
            return false;
        }

        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Type',
                text: 'Only JPG, JPEG, PNG, and PDF files are allowed.'
            });
            input.value = '';
            return false;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const previewId = previewMapping[input.id];
            const previewContainer = document.getElementById(previewId);

            if (fileExtension === 'pdf') {
                previewContainer.innerHTML = `
                    <div class="pdf-preview">
                        <embed src="${e.target.result}" type="application/pdf" width="100%" height="200px" />
                        <button type="button" class="delete-button" onclick="deleteImage('${input.id}')">X</button>
                    </div>
                `;
            } else {
                previewContainer.innerHTML = `
                    <div class="image-preview">
                        <img src="${e.target.result}" alt="Image Preview" />
                        <button type="button" class="delete-button" onclick="deleteImage('${input.id}')">X</button>
                    </div>
                `;
            }
        };
        reader.readAsDataURL(file);
    }
}


function deleteImage(inputId) {
    var inputElement = document.getElementById(inputId);
    var previewId = previewMapping[inputId];
    var previewContainer = document.getElementById(previewId);

    if (inputElement) {
        inputElement.value = '';
    }

    if (previewContainer) {
        previewContainer.innerHTML = '';
    }
}

showStep(currentStep);