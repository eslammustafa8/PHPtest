<?php
$error_fields = [];
$conn = mysqli_connect('localhost', 'root', '', 'test1');
if (!$conn) {
    echo mysqli_connect_errno();
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$select = "SELECT * FROM employees WHERE EmployeeID = $id LIMIT 1";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!(isset($_POST['Name']) && !empty($_POST['Name']))) {
        $error_fields[] = 'Name';
    }
    if (!(isset($_POST['Email']) && filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL))) {
        $error_fields[] = 'Email';
    }
    if (!(isset($_POST['dob']) && !empty($_POST['dob']))) {
        $error_fields[] = 'dob';
    }

    if (empty($error_fields)) {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        $Name = mysqli_real_escape_string($conn, $_POST['Name']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $Admin = isset($_POST['admin']) ? 1 : 0;
        $DOB = $_POST['dob'];

        $query = "UPDATE employees SET Name ='$Name', Email='$Email', admin=$Admin, dob='$DOB' WHERE EmployeeID='$id'";

        if (mysqli_query($conn, $query)) {
            header("Location: List_user.php");
            exit;
        } else {
            echo mysqli_error($conn);
        }
    }
}

mysqli_free_result($result);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #35424a; /* Dark blue background */
            color: #fff; /* White text */
            padding-top: 20px; /* Space from top */
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff; /* White background for form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            color: #35424a; /* Dark blue text */
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #5a67d8; /* Blue button */
            border: none;
        }
        .btn-primary:hover {
            background-color: #434190; /* Darker blue on hover */
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Edit User</h2>
            <form method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['EmployeeID']) ?>">
                
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" class="form-control" name="Name" id="Name" value="<?= htmlspecialchars($row['Name']) ?>">
                    <?php if (in_array('Name', $error_fields)) echo '<div class="error-message">Please enter your name.</div>' ?>
                </div>
                
                <div class="form-group">
                    <label for="Email">Email</label>
                    <input type="email" class="form-control" name="Email" id="Email" value="<?= htmlspecialchars($row['Email']) ?>">
                    <?php if (in_array('Email', $error_fields)) echo '<div class="error-message">Please enter a valid email.</div>' ?>
                </div>
                
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" id="dob" value="<?= htmlspecialchars($row['dob']) ?>">
                    <?php if (in_array('dob', $error_fields)) echo '<div class="error-message">Please enter a valid date of birth.</div>' ?>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="admin" id="admin" <?= $row['admin'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="admin">
                            Admin
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
