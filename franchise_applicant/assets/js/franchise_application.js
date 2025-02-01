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
        const requiredFields = ['last_name', 'first_name', 'm_name', 'b_date', 'age', 'contact_num', 'email', 'street', 'tricColor', 'd1_last_name', 'd1_first_name', 'd1_m_name', 'd2_last_name', 'd2_first_name', 'd2_m_name', 'license_no', 'license_class'];
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
        const toda = document.querySelector('[name="toda"]');
        const brgy = document.querySelector('[name="sex"]');
        const sex = document.querySelector('[name="brgy"]');
        //const bDate = document.querySelector('[name="b_date"]');
        const licenseExp = document.querySelector('[name="license_exp"]');
       // const sexRadioButtons = document.querySelectorAll('[name="sex"]');

        // Validate dropdowns and other fields
        [tricType, toda, brgy, sex, licenseExp].forEach(input => {
            if (!input.value.trim()) {
                missingFields = true;
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
        });

        //const sexSelected = [...sexRadioButtons].some(radio => radio.checked);
        /**if (!sexSelected) {
            missingFields = true;
            sexRadioButtons.forEach(radio => radio.classList.add('is-invalid'));
        } else {
            sexRadioButtons.forEach(radio => radio.classList.remove('is-invalid'));
        }**/

        if (missingFields) {
            errorMessage += 'Please fill out all required fields before proceeding to the next step.';
            isValid = false;
        }

    } else if (step === 2) {
        const requiredFiles = ['or', 'cr', 'tricyclePics', 'operatorsPic', 'valid_id', 'sedula'];
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

showStep(currentStep);
