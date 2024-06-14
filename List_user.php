<?php
// Connect to the database:
$conn = mysqli_connect("localhost", "root", "", "test1");
if (!$conn) {
    echo mysqli_connect_errno();
}

$query = "SELECT * FROM employees";
$result = mysqli_query($conn, $query);

// Making an HTML page to display 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN :: List users</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
</head>
<body>
    <div class="dashboard-container">
        <h1>List of Users</h1>
        <table class="users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Dob</th>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $row['EmployeeID'] ?></td>
                <td><?= $row['Name'] ?></td>
                <td><?= $row['dob'] ?></td>
                <td><?= $row['Email'] ?></td>
                <td><?= ($row['admin']) ? "Yes" : "No" ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['EmployeeID'] ?>" class="action-link">Edit</a> | 
                    <a href="delete.php?id=<?= $row['EmployeeID'] ?>" class="action-link">Delete</a>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="total-users">
                        Total Users: <?= mysqli_num_rows($result) ?>
                    </td>
                    <td>
                        <a href="add.php" class="add-user-link">Add user</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>
