<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rar";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: "  .$conn->connect_error);
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $surname = $_POST['surname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    $occupation = $_POST['occupation'];

    
    
    $stmt = $conn->prepare("INSERT INTO users (surname, firstname, middlename, gender, dob, email, address, contact, status, occupation) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    // Handle the error
    die("Error preparing the SQL statement: " . $conn->error);
}

$stmt->bind_param("ssssssssss", $surname, $firstname, $middlename, $gender, $dob, $email, $address, $contact, $status, $occupation);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: ");
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $surname = $_POST['surname'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $status = $_POST['status'];
    $occupation = $_POST['occupation'];
    
    $stmt = $conn->prepare("UPDATE users SET surname = ?, firstname = ?, middlename = ?, gender = ?, dob = ?, email = ?, address = ?, contact = ?, status = ?, occupation = ? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $surname, $firstname, $middlename, $gender, $dob, $email, $address, $contact, $status, $occupation, $id);
    
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
 
$result = $conn->query("SELECT * FROM users");
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Operations</title>
</head>
<body>
    <form method="post" action="">
        Surname: <input type="text" name="surname" required><br>
        First Name: <input type="text" name="firstname" required><br>
        Middle Name: <input type="text" name="middlename" required><br>
        Gender: <input type="text" name="gender" required><br>
        Date of Birth: <input type="text" name="dob" required><br>
        Email: <input type="email" name="email" required><br>
        Address: <input type="text" name="address" required><br>
        Contact: <input type="text" name="contact" required><br>
        Status: <input type="text" name="status" required><br>
        Occupation: <input type="text" name="occupation" required><br>
        <input type="submit" name="submit" value="Submit">
    </form><h2>Users List</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Surname</th>
        <th>First Name</th>
        <th>Middle Name</th>
        <th>Gender</th>
        <th>Date of Birth</th>
        <th>Email</th>
        <th>Address</th>
        <th>Contact</th>
        <th>Status</th>
        <th>Occupation</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['surname']; ?></td>
        <td><?php echo $row['firstname']; ?></td>
        <td><?php echo $row['middlename']; ?></td>
        <td><?php echo $row['gender']; ?></td>
        <td><?php echo $row['dob']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['contact']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td><?php echo $row['occupation']; ?></td>
        <td>
            <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
            <form method="post" action="">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="surname" value="<?php echo $row['surname']; ?>" required>
                <input type="text" name="firstname" value="<?php echo $row['firstname']; ?>" required>
                <input type="text" name="middlename" value="<?php echo $row['middlename']; ?>" required>
                <input type="text" name="gender" value="<?php echo $row['gender']; ?>" required>
                <input type="text" name="dob" value="<?php echo $row['dob']; ?>" required>
                <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
                <input type="text" name="address" value="<?php echo $row['address']; ?>" required>
                <input type="text" name="contact" value="<?php echo $row['contact']; ?>" required>
                <input type="text" name="status" value="<?php echo $row['status']; ?>" required>
                <input type="text" name="occupation" value="<?php echo $row['occupation']; ?>" required>
                <input type="submit" name="update" value="Update">
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
 
</body>
</html>