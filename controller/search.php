<?php
require_once "../models/Database_Connection.php";
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
                        <button class="edit-button">Edit</button>
                    </td>
                    <td>
                        <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this student?')">
                            <button type="submit" class="delete-btn" name="delete_id" value="<?php echo $result['roll_id']; ?>">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Check if the user type is not "admin"
    $getUserTypeStmt = $db_connection->db_connection()->prepare("SELECT user_type FROM STUDENT WHERE roll_id = :id");
    $getUserTypeStmt->bindValue(':id', $deleteId);
    $getUserTypeStmt->execute();
    $userType = $getUserTypeStmt->fetchColumn();

    if ($userType !== 'admin') {
        // Delete associated records from other tables (e.g., locations, bus, route)
        // Modify the following code based on your table structure and foreign key relationships

        // Delete associated records from the "locations" table
        $deleteLocationsStmt = $db_connection->db_connection()->prepare("DELETE FROM STUDENT WHERE roll_id = :id");
        $deleteLocationsStmt->bindValue(':id', $deleteId);
        $deleteLocationsStmt->execute();

        // Refresh the page after a short delay
//        header("Location: ../views/admin_dashboard.php");
//        exit();

        // Perform any other actions or redirection after deletion if needed
    } else {
        // Handle the case where the user type is "admin" and deletion is not allowed
        // Display an error message or perform other actions as needed
        header("Location: ../views/admin_dashboard.php?error=cannotRemoveAdmin");
    }
}
