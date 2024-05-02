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
			<h1 class="title">Add Admin</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Add Admin</a></li>
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
                            
                            <input type="submit" name="add_admin" class="btn btn-primary" value="add_admin">
                        </form>
                    </div>
                </div>
            </div>
			

			
		</main>
		<!-- MAIN -->

        <?php
if (isset($_POST['add_admin'])) {
    // Check if there are any admins in the database
    $check_sql = "SELECT * FROM tbl_admin";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If there's already an admin, prevent creation
        echo '<script>
            swal({
                title: "Error",
                text: "An admin account already exists. Only one admin account is allowed.",
                icon: "error"
            }).then(function() {
                window.location = "add_admin.php";
            });
        </script>';
        exit;
    } else {
        // If no admin exists, proceed with account creation
        $admin_name = $_POST['adminFullname'];
        $admin_email = $_POST['adminEmail'];
        $admin_username = $_POST['adminUsername'];
        $admin_phonenumber = $_POST['adminPhoneNumber'];
        $admin_password = $_POST['adminPassword'];
        
        // Image handling
        $image_name = isset($_FILES['adminImage']['name']) ? $_FILES['adminImage']['name'] : "";
        if ($image_name != "") {
            $ext_parts = explode('.', $image_name);
            $ext = end($ext_parts);
            $image_name = "Admin-Pic" . rand(0000, 9999) . "." . $ext;
            $src = $_FILES['adminImage']['tmp_name'];
            $destination = "admin_image/" . $image_name;

            if (!move_uploaded_file($src, $destination)) {
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to upload image",
                        icon: "error"
                    }).then(function() {
                        window.location = "add_admin.php";
                    });
                </script>';
                exit;
            }
        }

        // Insert new admin data
        $sql = "INSERT INTO tbl_admin (full_name, email, username, phone_number, password, image, created_at)
                VALUES ('$admin_name', '$admin_email', '$admin_username', '$admin_phonenumber', '$admin_password', '$image_name', NOW())";

        if (mysqli_query($conn, $sql)) {
            echo '<script>
                swal({
                    title: "Success",
                    text: "Admin successfully created",
                    icon: "success"
                }).then(function() {
                    window.location = "manage_user.php";
                });
            </script>';
        } else {
            echo '<script>
                swal({
                    title: "Error",
                    text: "Failed to create admin",
                    icon: "error"
                }).then(function() {
                    window.location = "add_admin.php";
                });
            </script>';
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