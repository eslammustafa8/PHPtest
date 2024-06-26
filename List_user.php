<?php
// Connect to the database:
$conn = mysqli_connect("localhost", "root", "", "test1");
if (!$conn) {
    echo mysqli_connect_errno();
    exit;
}

$query = "SELECT * FROM employees";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query .= " WHERE Name LIKE '%" . $search . "%' OR Email LIKE '%" . $search . "%'";
}

$result = mysqli_query($conn, $query);

// Making an HTML page to display 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN :: List users</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }
        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .dashboard-container h1 {
            color: #5a67d8;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-inline {
            margin-bottom: 20px;
        }
        .form-inline input[type="text"] {
            flex-grow: 1;
        }
        .users-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .users-table th, .users-table td {
            padding: 10px;
            text-align: left;
        }
        .users-table thead {
            background-color: #5a67d8;
            color: #fff;
        }
        .action-link {
            color: #5a67d8;
            text-decoration: none;
        }
        .action-link:hover {
            text-decoration: underline;
        }
        .add-user-link {
            color: #fff;
            background-color: #5a67d8;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .add-user-link:hover {
            background-color: #434190;
        }
        .total-users {
            text-align: right;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-container">
            <h1>List of Users</h1>
            <form method="GET" class="form-inline">
                <input type="text" class="form-control mr-2" name="search" placeholder="Enter Name or Email to search">
                <input type="submit" value="Search" class="btn btn-primary">
            </form>

            <table class="table users-table">
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
                    <td><?= htmlspecialchars($row['EmployeeID']) ?></td>
                    <td><?= htmlspecialchars($row['Name']) ?></td>
                    <td><?= htmlspecialchars($row['dob']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= ($row['admin']) ? "Yes" : "No" ?></td>
                    <td>
                        <a href="edit.php?id=<?= htmlspecialchars($row['EmployeeID']) ?>" class="action-link">Edit</a> | 
                        <a href="delete.php?id=<?= htmlspecialchars($row['EmployeeID']) ?>" class="action-link">Delete</a>
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
                            <a href="add.php" class="add-user-link">Add User</a>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
