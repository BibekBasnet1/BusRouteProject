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
                <th>Email</th>
                <th>Address</th>
                <th>Lat</th>
                <th>Long</th>
                <th>Phone no</th>
                <th>Bus</th>
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
                    <td>
                        <?php echo $result['email']; ?>
                    </td>
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
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
