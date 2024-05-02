<?php
include('../components/header-user.php');
include('../config/dbcon.php');

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
			<h1 class="title">Add Staff</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Staff</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Add Staff</a></li>
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
                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" name="adminEmail" placeholder="Enter email">
                            </div>
                            <div class="mb-3">
                                <label for="adminUsername" class="form-label">Username</label>
                                <input type="text" class="form-control" name="adminUsername" placeholder="Enter username">
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
                                <label for="adminImage" class="form-label">Image</label>
                                <input type="file" class="form-control" name="adminImage">
                            </div>
                            
                            <input type="submit" name="add_staff" class="btn btn-primary" value="Add Staff">
                        </form>
                    </div>
                </div>
            </div>
			

			
		</main>
		<!-- MAIN -->

        <?php
        if(isset($_POST['add_staff']))
        {

            $check_sql = "SELECT * FROM tbl_staff";
            $check_result = mysqli_query($conn, $check_sql);
        
            if (mysqli_num_rows($check_result) > 0) {
                // If there's already an admin, prevent creation
                echo '<script>
                    swal({
                        title: "Error",
                        text: "An staff account already exists. Only one staff account is allowed.",
                        icon: "error"
                    }).then(function() {
                        window.location = "add_staff.php";
                    });
                </script>';
                exit;
            } else {

            $admin_name = $_POST['adminFullname'];
            $admin_email = $_POST['adminEmail'];
            $admin_username = $_POST['adminUsername'];
            $admin_phonenumber = $_POST['adminPhoneNumber'];
            $admin_password = $_POST['adminPassword'];
            
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
            $image_name = "Staff-Pic" . rand(0000, 9999) . "." . $ext;
        
            // Upload the image
        
            // Get the src path and destination path
        
            // Source path is the current location of the image
            $src = $_FILES['adminImage']['tmp_name'];
        
            // Destination path for the image to be uploaded
            $destination = "staff_image/" . $image_name;
        
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
                        window.location = "add_staff.php";
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
    $sql = "INSERT INTO tbl_staff SET  full_name = '$admin_name' , email = '$admin_email', username = '$admin_username',
    phone_number = '$admin_phonenumber' , password = '$admin_password' ,  image = '$image_name', created_at = NOW()
    ";

    //execute query to insert data in database
    $result = mysqli_query($conn , $sql) or die(mysqli_error());

    //check the query is executed or not

    if ($result == true) {
      
        
        echo '<script>
            swal({
                title: "Success",
                text: "Staff Successfully Inserted",
                icon: "success"
            }).then(function() {
                window.location = "manage_staff.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
    }
    
else{
    echo '<script>
    swal({
        title: "Error",
        text: "Staff Failed to  Insert",
        icon: "error"
    }).then(function() {
        window.location = "add_staff.php";
    });
</script>';

exit;

}
        }
    }
        
        ?>
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>