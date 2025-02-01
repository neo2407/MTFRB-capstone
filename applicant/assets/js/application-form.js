let currentStep = 1;


function showStep(step) {
    document.querySelectorAll('.step-content').forEach((element, index) => {
        element.style.display = (index + 1 === step) ? 'block' : 'none';
    });
    updateProgressBar(step);
    updateButtons(step);
    updateStepIndicator(step);
}

function nextStep() {
    if (validateStep(currentStep)) {
        if (currentStep < 3) {
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

function updateProgressBar(step) {
    const progressBar = document.getElementById('stepperProgressBar');
    progressBar.style.width = ((step - 1) * 50) + '%';
}

function updateButtons(step) {
    const prevBtn = document.getElementById('step1BackBtn');
    const nextBtn = document.getElementById('step1NextBtn');

    if (!prevBtn || !nextBtn) {
        console.error('One of the buttons is not found in the DOM');
        return;
    }

    prevBtn.disabled = (step === 1);
    nextBtn.innerText = (step === 3) ? 'Submit' : 'Next';
}


function updateStepIndicator(step) {
    document.querySelectorAll('.stepper .step').forEach((element, index) => {
        if (index + 1 === step) {
            element.classList.add('active');
        } else {
            element.classList.remove('active');
            if (index + 1 < step) {
                element.classList.add('completed');
            } else {
                element.classList.remove('completed');
            }
        }
    });
}

function validateStep(step) {
    let isValid = true;
    let errorMessage = '';

    if (step === 1) {
        const requiredFields = ['last_name', 'first_name', 'm_name', 'b_date', 'age', 'contact_num', 'address', 'driver1_name', 'driver2_name', 'tricColor'];
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

        // Handle the dropdown (select) validation
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

        // Handle radio buttons validation
        const sexRadioButtons = document.querySelectorAll('[name="sex"]');
        const sexSelected = [...sexRadioButtons].some(radio => radio.checked);
        if (!sexSelected) {
            missingFields = true;
            sexRadioButtons.forEach(radio => radio.classList.add('is-invalid'));
        } else {
            sexRadioButtons.forEach(radio => radio.classList.remove('is-invalid'));
        }

        // Handle the date input validation
        const bDate = document.querySelector('[name="b_date"]');
        if (!bDate.value.trim()) {
            missingFields = true;
            bDate.classList.add('is-invalid');
        } else {
            bDate.classList.remove('is-invalid');
        }

        if (missingFields) {
            errorMessage += 'Please fill out all required fields in Step 1.';
            isValid = false;
        }

    } else if (step === 2) {
        const requiredFiles = ['or', 'cr', 'tricyclePics', 'deedSale', 'operatorsPic', 'toda_cert', 'valid_id', 'sedula', 'driversPic1', 'driversPic2', 'license', 'med_res'];
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
            errorMessage += 'Please upload all required files in Step 2.';
            isValid = false;
        }

    } else if (step === 3) {
        const requiredFields = ['password', 'confirm_pass', 'email'];
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

        const privacyActCheck = document.getElementById('privacyActCheck');
        if (!privacyActCheck.checked) {
            errorMessage += 'Please agree to the Data Privacy Act before submitting.\n';
            isValid = false;
        }
    }

    if (!isValid) {
        Swal.fire({
            icon: 'error',
            title: 'Warning',
            text: errorMessage
        });
    }

    return isValid;
}

// Define previewMapping globally
const previewMapping = {
    'cr': 'preview1',
    'deedSale': 'preview2',
    'or': 'preview3',
    'tricyclePics': 'preview4',
    'operatorsPic': 'preview5',
    'sedula': 'preview6',
    'toda_cert': 'preview7',
    'valid_id': 'preview8',
    'driversPic1': 'preview9',
    'driversPic2': 'preview10',
    'license': 'preview11',
    'med_res': 'preview12'
};

function fileValidation(input) {
    const allowedExtensions = ['jpeg', 'jpg', 'png', 'pdf'];
    const maxSizeMB = 2; // Maximum file size in megabytes
    const file = input.files[0];

    if (file) {
        // Check file size
        const fileSizeMB = file.size / (1024 * 1024); // Convert bytes to megabytes
        if (fileSizeMB > maxSizeMB) {
            Swal.fire({
                icon: 'error',
                title: 'File Size Exceeded',
                text: `The file size exceeds the ${maxSizeMB}MB limit. Please choose a smaller file.`
            });
            input.value = ''; 
            return false;
        }

        // Check file extension
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

        var reader = new FileReader();
        reader.onload = function (e) {
            var previewId = previewMapping[input.id];
            var previewContainer = document.getElementById(previewId);

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

// function for strong password

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
