
<?php 

include('config/dbcon.php');
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- FontAwesome for icons -->
</head>
    <title>Sign in & Sign up Form</title>
  </head>
  <body>

  <style>
/* Styling for the login box */
.login-box {
    background-color: #ECECEC; /* Light gray background */
    padding: 20px; /* Padding around the box */
    border-radius: 10px; /* Rounded corners */
    max-width: 450px; /* Maximum width */
    height: 55vh;
    margin: 100px auto; /* Center the box */
    text-align: center; /* Center text */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Shadow for depth */
}

/* Styling for the logo and clinic name */
.logo {
    width: 150px; /* Logo size */
    height: auto; /* Maintain aspect ratio */
}

h1 {
    font-size: 24px; /* Font size for clinic name */
    margin-bottom: 35px; /* Spacing below the heading */
}

/* Styling for input fields with icons */
.input-field {
    position: relative; /* Required for absolute positioning of icons */
    margin-bottom: 15px; /* Spacing between inputs */
}

.input-field i {
    position: absolute; /* Absolute positioning for the icon */
    top: 50%; /* Align icon vertically in the center */
    left: 30px; /* Position icon 10px from the left */
    transform: translateY(-50%); /* Center the icon vertically */
    color: black; /* Icon color */
}

.input-field input {
    width: 80%; /* Full width */
    padding: 15px; /* Padding for the input */
    padding-left: 35px; /* Additional padding for icon space */
    border: 1px solid #ccc; /* Border style */
    border-radius: 5px; /* Rounded corners */
    font-size: 14px; /* Font size */
}

/* Styling for the login button */
.login-button {
    background-color: #0097B2; /* Button background */
    color: white; /* Text color */
    margin-top: 5%;
    padding: 15px 25px; /* Button padding */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer on hover */
    margin-bottom: 5%;
}

.login-button:hover {
    background-color: #007b8b; /* Darker shade on hover */
}


/* Styling for additional links */
.additional-links {
    margin-top: 12px; /* Spacing above the links */
    font-size: 16px; /* Font size */
}

.additional-links a {
    text-decoration: none; /* No underline */
    color: #0097B2; /* Link color */
    padding: 5px 10px; /* Padding for spacing */
}

.additional-links a:hover {
    text-decoration: underline; /* Underline on hover */
}

  </style>
    

    <div class="login-box">
    <!-- Logo and Clinic Name -->
    <img src="images/eclinix.png" alt="Clinic Logo" class="logo">
    <h1>Ocampo’s Children and Maternity Clinic</h1>



    <!-- Login Form -->
    <form method="post">
        <!-- Email Field -->
            <!-- Role Selection -->
    <div class="input-field">
        <i class="fas fa-user-tag"></i>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="Admin">Admin</option>
            <option value="Staff">Staff</option>
            <option value="Patient">Patient</option>
        </select>
    </div>



        <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" name="username" placeholder="Email" required>
        </div>

        <!-- Password Field -->
        <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <!-- Login Button -->
        <button type="submit" name="login" class="login-button">Login</button>
    </form>
</div>

  </body>
</html>


<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate the role selection
    if (!in_array($role, ['Admin', 'Staff', 'Patient'])) {
        echo '<script>
            swal({
                title: "Error",
                text: "Invalid role selection",
                icon: "error"
            }).then(function() {
                window.location = "patient_login.php";
            });
        </script>';
        exit;
    }

    // SQL queries to check the user with email and password
    $queries = [
        'Admin' => "SELECT * FROM tbl_admin WHERE email = '$username' AND password = '$password'",
        'Staff' => "SELECT * FROM tbl_staff WHERE email = '$username' AND password = '$password'",
        'Patient' => "SELECT * FROM tbl_patient WHERE email = '$username' AND password = '$password'",
    ];

    // Execute the correct query based on the selected role
    $result = mysqli_query($conn, $queries[$role]);
    $count = mysqli_num_rows($result);

    if ($count === 1) {
        $row = mysqli_fetch_assoc($result);

        // Set session variables based on role
        if ($role === 'Admin') {
            $_SESSION['admin_id'] = $row['id'];
            $redirect_url = '../capstone-patient/admin/dashboard.php';
        } elseif ($role === 'Staff') {
            $_SESSION['staff_id'] = $row['id'];
            $redirect_url = '../capstone-patient/staff/dashboard.php';
        } else {
            $_SESSION['patient_id'] = $row['id'];
            $redirect_url = '../capstone-patient/patient/terms.php';
        }

        echo '<script>
            swal({
                title: "Success",
                text: "Login Successfully",
                icon: "success"
            }).then(function() {
                window.location = "' . $redirect_url . '";
            });
        </script>';
        exit;
    } else {
        echo '<script>
            swal({
                title: "Error",
                text: "Invalid email or password",
                icon: "error"
            }).then(function() {
                window.location = "patient_login.php";
            });
        </script>';
        exit;
    }
}


?>