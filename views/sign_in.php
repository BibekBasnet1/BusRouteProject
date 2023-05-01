<!--<div class="sign-up-container">-->
    <form action="../controller/signIn.inc.php" method="POST" class="form-form">
        <div class="title-signUP">
            <h2>Sign Up</h2>
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
            <button type="submit" name="submit">Sign Up</button>
        </div>
    </form>
<!--</div>-->