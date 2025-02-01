
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm-password');

        function checkPasswordMatch() {
            if (passwordInput.value === confirmPasswordInput.value && passwordInput.value !== '' && confirmPasswordInput.value !== '') {
                passwordInput.style.backgroundColor = '#d4edda';  // Light green background
                confirmPasswordInput.style.backgroundColor = '#d4edda';  // Light green background
                confirmPasswordInput.placeholder = 'Passwords match';  // Show message inside field
                confirmPasswordInput.style.color = 'green';  // Change text color to green
            } else {
                passwordInput.style.backgroundColor = '';  // Reset background
                confirmPasswordInput.style.backgroundColor = '';  // Reset background
                confirmPasswordInput.placeholder = 'Passwords must match';  // Show error message inside field
                confirmPasswordInput.style.color = 'red';  // Change text color to red
            }
        }

        passwordInput.addEventListener('input', checkPasswordMatch);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    });
