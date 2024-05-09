<?php
include('../components/header-patients.php');
include('../config/dbcon.php');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';


?>


<?php
if(!isset($_SESSION['admin_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "admin_login.php";
                                    });
                                </script>';
                                exit;
}

?>

		<!-- MAIN -->
		<main>
			<h1 class="title">Add Patient</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Add Patient</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">
                            <div class="mb-3">
                                <label for="adminFullname" class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="adminFullname" placeholder="Enter full name">
                            </div>

                            <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            <!-- Date of Birth Field -->
                            <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Select your date of birth">
                                </div>

                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="adminEmail" placeholder="Enter email">
                            </div>
                           
                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control"  name="adminPhoneNumber" placeholder="Enter phone number" maxlength="11">
                            </div>
                            <div class="mb-3">
                                <label for="adminPassword" class="form-label">Password</label>
                                <input type="password" class="form-control" name="adminPassword" placeholder="Password">
                            </div>

                            <div class="mb-3">
                            <label for="adminAddress" class="form-label">Address</label>
                            <textarea class="form-control" name="adminAddress" id="adminAddress" rows="4" placeholder="Enter your address"></textarea>
                        </div>



                            <div class="mb-3">
                                <label for="adminImage" class="form-label">Image</label>
                                <input type="file" class="form-control" name="adminImage">
                            </div>
                            
                            <input type="submit" name="add_admin" class="btn btn-primary" value="Add Patient">
                        </form>
                    </div>
                </div>
            </div>
			

			
		</main>
		<!-- MAIN -->

        <?php

function sendEmail($to, $patient_password, $patient_email, $patient_name)
{
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'eclinixpediatric@gmail.com';
        $mail->Password   = 'izss qaxw gubb rxnb'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('eclinixpediatric@gmail.com', 'Ocampos Children & Maternity Clinic.'); // Replace 'Your Name' with your desired sender name
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Weclome to Eclinix, Your Account Details';
        $mail->Body    = "Dear $patient_name,<br><br>Your email: $patient_email<br>Your Password: $patient_password<br><br>Thank you for registering!";

        $mail->send();
    } catch (Exception $e) {
        // Handle exception (you can log it or display an error message)
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}


        if(isset($_POST['add_admin']))
        {
            $patient_name = $_POST['adminFullname'];
            $patient_email = $_POST['adminEmail'];
            $patient_address = $_POST['adminAddress'];
            $patient_phonenumber = $_POST['adminPhoneNumber'];
            $patient_password = $_POST['adminPassword'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
            
            if(isset($_FILES['adminImage']['name']))
    {
        //get the details of the selected image
        $image_name = $_FILES['adminImage']['name'];

        //check if the imaage selected or not.
        if ($image_name != "") {
            // Image is selected
            // Rename the image
            $ext_parts = explode('.', $image_name);
            $ext = end($ext_parts);
        
            // Create a new name for the image
            $image_name = "Patient-Pic" . rand(0000, 9999) . "." . $ext;
        
            // Upload the image
        
            // Get the src path and destination path
        
            // Source path is the current location of the image
            $src = $_FILES['adminImage']['tmp_name'];
        
            // Destination path for the image to be uploaded
            $destination = "patient_image/" . $image_name;
        
            // Upload the food image
            $upload = move_uploaded_file($src, $destination);
        
            // Check if the image uploaded or not
            if ($upload == false) {
                // Failed to upload the image
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to upload image",
                        icon: "error"
                    }).then(function() {
                        window.location = "add_patient.php";
                    });
                </script>';
        
                die();
                exit;
            } else {
                // Image uploaded successfully
            }
        }
    
    }
    else
    {
        $image_name = ""; 
    }

    //SQL query to save the data into database
    $sql = "INSERT INTO tbl_patient SET  full_name = '$patient_name' , email = '$patient_email', address = '$patient_address',
    phone_number = '$patient_phonenumber' , password = '$patient_password' ,  image = '$image_name' , dob = '$dob', gender = '$gender' , 
    date = NOW()";

    //execute query to insert data in database
    $result = mysqli_query($conn , $sql) or die(mysqli_error());

    //check the query is executed or not

    if ($result == true) {
      
        sendEmail($patient_email, $patient_password, $patient_email, $patient_name);
        echo '<script>
            swal({
                title: "Success",
                text: "Patient Successfully Inserted",
                icon: "success"
            }).then(function() {
                window.location = "manage_patient.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
    }
    
else{
    echo '<script>
    swal({
        title: "Error",
        text: "Patient Failed to  Insert",
        icon: "error"
    }).then(function() {
        window.location = "add_patient.php";
    });
</script>';

exit;

}


            
        }


        
        
        
        ?>
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>