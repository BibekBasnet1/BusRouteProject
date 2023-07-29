<div class="sign-up-container">
    <form action="../controller/update_student_data.php" method="POST" class="form-form" id="update-form">
        <div class="title-signUP">
            <h2>Update</h2>
            <div class="image wrong-image" style="text-align: right;position: relative;top: 0;right:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                     style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);">
                    <path
                            d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z">
                    </path>
                    <path
                            d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z">
                    </path>
                </svg>
            </div>
        </div>
        <div id="result-message" style="text-align: center;color:green;"></div>
        <div class="form-content">
            <div class="content-1">
                <div class="name-input">
                    <input type="text" name="student_name" id="student_name" placeholder="Enter your name" required>
                </div>
                <div class="parent-input">
                    <input type="text" name="parents_name" id="parents_Name" placeholder="Parent Name" required>
                </div>
            </div>
            <div class="content-2">
                <div class="phone-input">
                    <input type="number" name="phone_no" id="phone_no" placeholder="Your phone no" required>
                </div>
                <div class="relationship-input">
                    <input type="text" id="relationship" name="relationship" placeholder="Your relationship">
                </div>
            </div>
            <div class="content-3">
                <div class="person_email">
                    <input type="email" id="student_email" name="email" placeholder="email">
                </div>
                <div class="roll-input">
                    <input type="text" name="roll_id" id="roll_id" placeholder="Your Roll no">
                </div>
            </div>
            <div class="content-4">
                <div class="location-student">
                    <input type="text" name="address" id="location" placeholder="Your Address" required>
                </div>
                <div class="parent-no">
                    <input type="number" name="parent_no" placeholder="Parent's Number" id="parent_no" required>
                </div>
            </div>
        </div>
        <div class="btn">
            <button type="submit" name="update-submit">Update</button>
        </div>
    </form>
</div>

<script>
    function handleFormSubmit(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        // Perform validation
        if (!validateForm()) {
            return;
        }

        // Get form data
        let formData = new FormData(document.getElementById('update-form'));

        // Send AJAX request
        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../controller/update_student_data.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update the result message on success
                    document.getElementById('result-message').textContent = xhr.responseText;
                } else {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            }
        };
        xhr.send(formData);
    }

    function validateForm() {
        let studentName = document.getElementById('student_name').value;
        let parentsName = document.getElementById('parents_Name').value;
        let phoneNo = document.getElementById('phone_no').value;
        let parentNo = document.getElementById('parent_no').value;

        // Perform validation to check if the fields have been left empty
        if (studentName.trim() === '') {
            displayErrorMessage('Please enter your name.');
            return false;
        }

        if (parentsName.trim() === '') {
            displayErrorMessage('Please enter parent\'s name.');
            return false;
        }

        if (phoneNo.trim() === '') {
            displayErrorMessage('Please enter your phone number.');
            return false;
        }

        if (parentNo.trim() === '') {
            displayErrorMessage('Please enter parent\'s phone number.');
            return false;
        }

        // Check if the studentName only contains letters and spaces
        if (!/^[a-zA-Z ]+$/.test(studentName.trim())) {
            displayErrorMessage('Invalid name. Please enter only letters.');
            return false;
        }

        // Check if the parentName only contains letters and spaces
        if (!/^[a-zA-Z ]+$/.test(parentsName.trim())) {
            displayErrorMessage('Invalid parent\'s name. Please enter only letters.');
            return false;
        }

        // Check if the phoneNo is a 10-digit number
        if (!/^\d{10}$/.test(phoneNo.trim())) {
            displayErrorMessage('Invalid phone number. Please enter a 10-digit number.');
            return false;
        }

        // Validation passed
        document.getElementById('result-message').textContent = ''; // Clear any previous error message
        return true;
    }

    function displayErrorMessage(message) {
        document.getElementById('result-message').textContent = message;
    }

    // Add event listener to the form submit button
    document.getElementById('update-form').addEventListener('submit', handleFormSubmit);



</script>
