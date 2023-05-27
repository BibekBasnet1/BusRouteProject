<?php
require_once "../models/Database_Connection.php";
require_once "../views/update_form.php";
$db_connection = new \models\Database_Connection();

if(isset($_POST['search'])){
    $search = $_POST['search'];
    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT WHERE name LIKE :search OR email LIKE :search OR address LIKE :search OR latitude LIKE :search OR longitude LIKE :search OR phone_no LIKE :search OR bus LIKE :search");
    $stmt->bindValue(':search', '%'.$search.'%');
} else {
    $stmt = $db_connection->db_connection()->prepare("SELECT * FROM STUDENT");
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Student Details</h3>
            <i class="bx bx-search"></i>
            <i class='bx bx-filter' ></i>
        </div>
        <table>
            <thead>
            <tr>
                <th>Name</th>
<!--                <th>Email</th>-->
                <th>Address</th>
                <th>Lat</th>
                <th>Long</th>
                <th>Phone no</th>
                <th>Bus No</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach($results as $result){ ?>
                <tr>
                    <td>
                        <img src="img/people.png">
                        <p><?php echo $result['name']; ?></p>
                    </td>
<!--                    <td>-->
<!--                        --><?php //echo $result['email']; ?>
<!--                    </td>-->
                    <td>
                        <?php echo $result["address"]; ?>
                    </td>
                    <td>
                        <?php echo $result["latitude"]; ?>
                    </td>
                    <td>
                        <?php echo $result["longitude"]; ?>
                    </td>
                    <td>
                        <?php echo $result["phone_no"]; ?>
                    </td>
                    <td>
                        <?php
                        echo $result["bus"];
                        ?>
                    </td>
                    <td>
                        <?php
                        $rollId = $result['roll_id'];
                        ?>

                        <button type="button" class="edit-btn" data-rollid="<?php echo $rollId; ?>" data-usertype="<?php echo $result['user_type']; ?>">Update</button>

                    </td>

                    <td>
                            <button type="submit" class="delete-btn" name="delete_id" data-rollid="<?php echo $result['roll_id']; ?>" data-usertype="<?php echo $result['user_type']; ?>">Delete</button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>

    // to prefill the form based on the update button clicked and send the request to the server
    let formElement = document.querySelector(".sign-up-container");
    let updateBtns = document.querySelectorAll(".edit-btn");
    let tableData = document.querySelector(".table-data");
    let formInputs = formElement.querySelectorAll("input");

    updateBtns.forEach(function(updateBtn) {
        updateBtn.addEventListener("click", function() {

            // Get the user type from the data attribute
            let userType = updateBtn.getAttribute("data-usertype");

            // Check if the user type is "admin" and disable the update functionality
            if (userType === "admin") {
                console.log("Update functionality disabled for admin");
                return;
            }

            formElement.style.display = "flex";
            tableData.style.filter = "blur(5px)";

            let rollId = updateBtn.getAttribute("data-rollid");

            // Create an AJAX request to fetch the student data
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "../controller/fetch_student_data.php?rollId=" + rollId, true);

            // Handle the response
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {
                        let data = response.data;

                        // Access the properties within the data object
                        let name = data.name;
                        let parentsName = data.parents_name;
                        let phoneNo = data.phone_no;
                        let relationship = data.relationship;
                        let email = data.email;
                        let roll_id = data.roll_id;
                        let address = data.address;
                        let parent_no = data.parent_no;

                        // Set the input values
                        document.getElementById("student_name").value = name;
                        document.getElementById("parents_Name").value = parentsName;
                        document.getElementById("phone_no").value = phoneNo;
                        document.getElementById("relationship").value = relationship;
                        document.getElementById("student_email").value = email;
                        document.getElementById("roll_id").value = roll_id;
                        document.getElementById("location").value = address;
                        document.getElementById("parent_no").value = parent_no;
                    } else {
                        console.error("Error: " + response.message);
                    }
                } else {
                    console.error("Error: " + xhr.status);
                }
            };


            // Send the request
            xhr.send();
        });
    });

    // end of the form prefilling logic

    // start of the deleting the row logic

    let deleteBtns = document.querySelectorAll(".delete-btn");

    deleteBtns.forEach(function(deleteBtn) {
        deleteBtn.addEventListener("click", function() {
            let rollId = deleteBtn.getAttribute("data-rollid");

            // Get the user type from the data attribute
            let userType = deleteBtn.getAttribute("data-usertype");

            // Check if the user type is "admin" and disable the update functionality
            if (userType === "admin") {
                console.log("Update functionality disabled for admin");
                return;
            }

            // Display a confirmation dialog
            let confirmDelete = confirm("Are you sure you want to delete this student?");

            // Create an AJAX request to delete the record
            if(confirmDelete) {

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "../controller/On_delete_record.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // Handle the response
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if (response.status === "success") {
                            // Remove the deleted row from the table
                            deleteBtn.closest("tr").remove();
                            console.log(response.message);
                        } else {
                            console.error(response.message);
                        }
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                };


                // Send the request with the delete ID
                xhr.send("delete_id=" + rollId);
            }
        });
    });

    // end of the delete row logic

    let wrongBtn = document.querySelector(".wrong-image");
    wrongBtn.addEventListener("click", function() {
        formElement.style.display = "none";
        tableData.style.filter = "none";
    });

</script>
