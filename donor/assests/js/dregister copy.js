

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

// Validation for Date of Birth
const dobInput = document.getElementById('dob');
const dob = new Date(dobInput.value);
const age = new Date().getFullYear() - dob.getFullYear();
const minAge = 18;
const maxAge = 65;
if (age < minAge || age > maxAge) {
    event.preventDefault();
    event.stopPropagation();
    alert(`You must be between ${minAge} and ${maxAge} years old to register.`);
}

// Validation for Email
const emailInput = document.getElementById('email');
const email = emailInput.value;
const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
if (!emailRegex.test(email)) {
    event.preventDefault();
    event.stopPropagation();
    alert('Please enter a valid Gmail address.');
}


