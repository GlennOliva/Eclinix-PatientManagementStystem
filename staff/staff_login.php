
<?php 

include('../config/dbcon.php');
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
    <title>Staff Login</title>
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
    

   <!-- Login Box -->
   <div class="login-box">
        <!-- Logo and Clinic Name -->
        <img src="../images/eclinix.png" alt="Ocampo's Clinic Logo" class="logo"> <!-- Change to your logo -->
        <h1>Ocampo’s Children and Maternity Clinic</h1>
        
        <!-- Login Form -->
        <form  method="post">
            <div class="input-field">
                <!-- Icon inside the input field -->
                <i class="fas fa-user"></i>
                <input type="text" name="username" id="email" placeholder="Username" required>
            </div>

            <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>

            <button type="submit" name="login" class="login-button">Login</button>
        </form>

        <div class="additional-links">
            <a href="../patient/patient_login.php">Patient</a> || 
            <a href="../admin/admin_login.php">Admin</a> <!-- Change admin login path as needed -->
        </div>
    </div>


  </body>
</html>


<?php


    //check if the submit button is clicked or not
    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        //sql to check the user with username and password exists or not
        $sql = "SELECT * FROM tbl_staff WHERE username = '$username' AND password = '$password'";

        //execute the sql queery
        $result = mysqli_query($conn,$sql);

        //count the rows 
        $count = mysqli_num_rows($result);

        if($count==1)
        {

            $row = mysqli_fetch_assoc($result);
            $_SESSION['staff_id'] = $row['id'];
            
            //user is exist
            echo '<script>
            swal({
                title: "Success",
                text: "Login Successfully",
                icon: "success"
            }).then(function() {
                window.location = "manage_appoint.php";
            });
        </script>';

       



       
        
        exit;

        }
        else{
            //user not available
            echo '<script>
            swal({
                title: "Error",
                text: "Username or Password did not match",
                icon: "error"
            }).then(function() {
                window.location = "staff_login.php";
            });
        </script>';
        
        exit;
        }
    }

?>