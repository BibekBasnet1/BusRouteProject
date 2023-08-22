<!--<div class="sign-up-container">-->
    <form action="../controller/signIn.inc.php" method="POST" class="form-form" id="sign-in-form">
        <div class="title-signUP">
            <h2>Sign Up</h2>
            <div class="image wrong-image-sign-up"style="text-align: right;position: relative;top: 0;right:0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: rotate(180deg);msFilter:progid:DXImageTransform.Microsoft.BasicImage(rotation=2);"><path d="M9.172 16.242 12 13.414l2.828 2.828 1.414-1.414L13.414 12l2.828-2.828-1.414-1.414L12 10.586 9.172 7.758 7.758 9.172 10.586 12l-2.828 2.828z"></path><path d="M12 22c5.514 0 10-4.486 10-10S17.514 2 12 2 2 6.486 2 12s4.486 10 10 10zm0-18c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8z"></path></svg>
            </div>
        </div>
        <div class="form-content">
            <div class="content-1">

                <!-- this is for the name input -->
                <div class="name-input">
                    <input type="text" name="person_name" id="student_name" placeholder="Enter your name"  required>
                </div>
                <!-- this is for the parents name input -->
                <div class="parent-input">
<!--                     <label for="Parents_Name">Parents Name</label>-->
                    <input type="text" name="parents_name" id="parents_Name" placeholder="Parent Name" required>
                </div>

            </div>
            <div class="content-2">

                <!-- this is for the phone no input -->
                <div class="phone-input">
                    <!-- <label for="phone_no">Phone No</label> -->
                    <input type="number" name="phone_no" id="phone_no" placeholder="Your phone no" required>
                </div>
                <!-- this is for the relationship input -->
                <div class="relationship-input">
                    <!-- <label for="relationship">Relationship</label> -->
                    <input type="text" id="relationship" name="relationship" placeholder="Your relationship">
                </div>
            </div>

            <div class="content-3">

                <!-- this is for the parents_no input -->
                <div class="person_email">
                    <!-- <label for="parents_phone_no" >Parents No</label> -->
                    <input type="email" id="student_email" name="student_email" placeholder="email">
                </div>
                <!-- this is for the roll id input -->
                <div class="roll-input">
                    <!-- <label for="roll_no">Roll No</label> -->
                    <input type="text" name="roll_no" id="" placeholder="Your Roll no">
                </div>
            </div>
            <div class="content-4">
                <!-- this is for the location of the student  -->
                <div class="location-student">
                    <input type="text" name="location" id="location" placeholder="Your Address" required>
                </div>
                <!--  this is for the parents no -->
                <div class="parent-no">
                    <input type="number" name="parent_no" placeholder="Parent's Number" id="parent_no"required>
                </div>
            </div>

        </div>
        <div class="btn">
            <button type="submit" name="submit">Register</button>
        </div>
    </form>
<!--</div>-->
<script>
    let wrong = document.querySelector(".wrong-image-sign-up");
    let form = document.querySelector(".form-form");


    wrong.addEventListener("click", function() {
        form.style.display = "none";
        // console.log("clicked");
    });
    // Function to validate the form
    function validateForm(event) {
        // Get form data
        let studentName = document.getElementById('student_name').value;
        let parentsName = document.getElementById('parents_Name').value;
        let phoneNo = document.getElementById('phone_no').value;
        let relationShip = document.getElementById('relationship').value;
        let location = document.getElementById('location').value;
        let parentNo = document.getElementById('parent_no').value;

        // Perform validation to check if the field has been left empty
        if (studentName.trim() === '') {
            alert('Please enter your name.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        // check if the studentName only contains the string
        if (!/^[a-zA-Z ]+$/.test(studentName.trim())) {
            alert('Student name should only contain letters.');
            event.preventDefault(); // Prevent form submission
            return;
        }


        if (parentsName.trim() === '') {
            alert('Please enter parent name.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        // check if the parentName only contains the string
        if(!/^[a-zA-Z ]+$/.test(parentsName.trim())){
            alert("Parent Name should only contain strings!");
            return;
        }

        if (phoneNo.trim() === '') {
            alert('Please enter your phone number.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if(phoneNo.trim() === ''){
            alert("Please enter phone No");
            event.preventDefault();
            return;
        }

        // check if the phone_no is of 10 digits
        if (!/^\d{10}$/.test(phoneNo.trim()) && !/^\d{10}$/.test(parentNo.trim())) {
            alert('Phone number should be 10 digits.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (location.trim() === '') {
            alert('Please enter your address.');
            event.preventDefault(); // Prevent form submission
            return;
        }

        if (parentNo.trim() === '') {
            alert("Please enter parent's phone number.");
            event.preventDefault(); // Prevent form submission
            return;
        }
    }

    // Attach form submit event listener
    document.querySelector('.form-form').addEventListener('submit', validateForm);

</script>