

    // Bootstrap validation handling
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var form = document.getElementById('donorRegisterForm');
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }, false);
    })();

    // Phone number validation (10 digits)
    document.getElementById('phone').addEventListener('input', function () {
        var phone = this.value;
        var phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phone)) {
            this.setCustomValidity('Please enter a valid 10-digit phone number.');
        } else {
            this.setCustomValidity('');
        }
    });

    // Password validation (min 8 characters)
    document.getElementById('password').addEventListener('input', function () {
        var password = this.value;
        if (password.length < 8) {
            this.setCustomValidity('Password must be at least 8 characters long.');
        } else {
            this.setCustomValidity('');
        }
    });

 
    document.addEventListener('DOMContentLoaded', function () {
    const localLevelSelect = document.getElementById('locallevel');
    const latitudeInput = document.getElementById('latitudeInput');
    const longitudeInput = document.getElementById('longitudeInput');

    localLevelSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const latitude = selectedOption.getAttribute('data-lat');
        const longitude = selectedOption.getAttribute('data-lng');

        // Update hidden input fields
        latitudeInput.value = latitude;
        longitudeInput.value = longitude;

        console.log('Selected Local Level:', this.value); // Local level name
        console.log('Latitude:', latitude);
        console.log('Longitude:', longitude);
    });
});

// validation for Dob age
function calculateAge(dob) {
    const today = new Date();
    const birthDate = new Date(dob);
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDifference = today.getMonth() - birthDate.getMonth();
    
    // Adjust age if birthdate has not occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

// Example usage in form validation
document.getElementById('donorRegisterForm').addEventListener('submit', function (event) {
    const dob = document.getElementById('dob').value;
    const age = calculateAge(dob);

    if (age < 18 || age > 65) {
        alert('You must be between 18 and 65 years old to register as a donor.');
        event.preventDefault(); // Prevent form submission
    }
});

// Validation for Email
const emailInput = document.getElementById('email');
const email = emailInput.value;
const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
if (!emailRegex.test(email)) {
    event.preventDefault();
    event.stopPropagation();
    alert('Please enter a valid Gmail address.');
}


document.getElementById('donorRegisterForm').addEventListener('submit', function (event) {
    const personalDocuments = document.getElementById('personal_documents').files;
    const medicalDocuments = document.getElementById('medical_documents').files;

    if (personalDocuments.length === 0 || medicalDocuments.length === 0) {
        alert('You must upload both personal and medical documents.');
        event.preventDefault(); // Prevent form submission
    }

    // Check file types
    const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    for (let file of personalDocuments) {
        if (!validTypes.includes(file.type)) {
            alert('Personal documents must be PDF, JPG, or PNG.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    }
    for (let file of medicalDocuments) {
        if (!validTypes.includes(file.type)) {
            alert('Medical documents must be PDF, JPG, or PNG.');
            event.preventDefault(); // Prevent form submission
            return;
        }
    }
});
