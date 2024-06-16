<?php
$error_fields = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!(isset($_POST['Name']) && !empty($_POST['Name']))) {
        $error_fields[] = 'Name';
    }
    if (!(isset($_POST['Email']) && filter_input(INPUT_POST, 'Email', FILTER_VALIDATE_EMAIL))) {
        $error_fields[] = 'Email';
    }
    if (!(isset($_POST['dob']) && !empty($_POST['dob']))) {
        $error_fields[] = 'dob';
    }
    if (!(isset($_POST['Password']) && strlen($_POST['Password']) > 5)) {
        $error_fields[] = 'Password';
    }

    if (!$error_fields) {
        // Connect to database
        $conn = mysqli_connect('localhost', 'root', '', 'test1');
        if (!$conn) {
            echo mysqli_connect_error();
            exit;
        }

        // Escape special characters to avoid SQL injection
        $Name = mysqli_real_escape_string($conn, $_POST['Name']);
        $Email = mysqli_real_escape_string($conn, $_POST['Email']);
        $Password = sha1($_POST['Password']);
        $Admin = (isset($_POST['admin'])) ? 1 : 0;
        $DOB = $_POST['dob'];

        // Insert data into database
        $query = "INSERT INTO `employees` (Name, Password, Email, admin, dob) VALUES ('$Name', '$Password', '$Email', '$Admin', '$DOB')";

        if (mysqli_query($conn, $query)) {
            header("Location: List_user.php");
            exit;
        } else {
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD USER</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        input[type="checkbox"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add User</h1>
        <form method="post">
            <label for="Name">Name</label>
            <input type="text" name="Name" id="Name" value="<?= isset($_POST['Name']) ? htmlspecialchars($_POST['Name']) : '' ?>">
            <?php if (in_array('Name', $error_fields)) echo '<div class="error">*Please Enter Your Name*</div>' ?>

            <label for="Email">Email</label>
            <input type="text" name="Email" id="Email" value="<?= isset($_POST['Email']) ? htmlspecialchars($_POST['Email']) : '' ?>">
            <?php if (in_array('Email', $error_fields)) echo '<div class="error">*Please Enter a Valid Email*</div>' ?>

            <label for="Password">Password</label>
            <input type="password" name="Password" id="Password">
            <?php if (in_array('Password', $error_fields)) echo '<div class="error">*Please Enter a Password Longer Than 5 Characters*</div>' ?>

            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" id="dob" value="<?= isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : '' ?>">
            <?php if (in_array('dob', $error_fields)) echo '<div class="error">*Please Enter a Date of Birth*</div>' ?>

            <input type="checkbox" name="admin" id="admin" <?= isset($_POST['admin']) ? 'checked' : '' ?>>
            <label for="admin">Admin</label>

            <input type="submit" value="Add User" name="submit">
        </form>
    </div>
</body>
</html>
