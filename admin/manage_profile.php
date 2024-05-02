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

<?php



$sql = "SELECT * FROM tbl_admin";

//execute the query
$result = mysqli_query($conn,$sql);

//check if the query is executed or not!
if($result == True)
{
    //check if the data is available or not
    $count = mysqli_num_rows($result);

    //ccheck if we have admin data or not
    if($count==1)
    {
        //display the details
        //echo "admin available"; 
        $rows = mysqli_fetch_assoc($result);

        $id = $rows['id'];
        $full_name = $rows['full_name'];
        $email = $rows['email'];
        $username = $rows['username'];
        $phone_number = $rows['phone_number'];
        $current_image = $rows['image'];
        $date = $rows['created_at'];
        $status = $rows['status'];

      
    }
    else
    {
        header('Location: manage_user.php');
        exit();
    }
}

?>

		<!-- MAIN -->
		<main>
			<h1 class="title">Update Admin</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update Admin</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">
                        <div class="mb-3">
                                <label for="adminFullname" class="form-label">Profile Image</label>
                                <img src="admin_image/<?php echo $current_image;?>" style="width: 30%; margin: 2%;">
                            </div>
                            <div class="mb-3">
                                <label for="adminFullname" class="form-label">Admin Full Name</label>
                                <input type="text" class="form-control" name="adminFullname" placeholder="Enter full name" value="<?php echo $full_name;?>">
                            </div>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">Admin Email</label>
                                <input type="email" class="form-control" name="adminEmail" placeholder="Enter email" value="<?php echo $email;?>">
                            </div>
                            <div class="mb-3">
                                <label for="adminUsername" class="form-label">Admin Username</label>
                                <input type="text" class="form-control" name="adminUsername" placeholder="Enter username" value="<?php echo $username;?>">
                            </div>
                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">Admin Phone Number</label>
                                <input type="tel" class="form-control" name="adminPhoneNumber" placeholder="Enter phone number" maxlength="11" value="<?php echo $phone_number;?>">
                            </div>


                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">Admin Current Password</label>
                                <input type="password" class="form-control" name="adminCurrentpassword" placeholder="Enter current password">
                                
                            </div>

                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">Admin New Password</label>
                                <input type="password" class="form-control" name="adminNewpassword" placeholder="Enter New password">
                            </div>


                           
                        
                            <div class="mb-3">
                                <label for="adminImage" class="form-label">New Image</label>
                                <input type="file" class="form-control" name="adminImage">
                            </div>
                            
                            <input type="hidden" name="id" value="<?php echo $id;?>">
      <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                            <input type="submit" name="update_profile" class="btn btn-primary" value="Update Profile">
                        </form>
                    </div>
                </div>
            </div>


            <?php
    
    //check whether the submit button is clicked or not
    if(isset($_POST['update_profile']))
    {
        $id = $_POST['id'];
        $admin_name = $_POST['adminFullname'];
        $admin_email = $_POST['adminEmail'];
        $admin_username = $_POST['adminUsername'];
        $admin_phonenumber = $_POST['adminPhoneNumber'];
        $current_image = $_POST['current_image'];
        $new_password = $_POST['adminNewpassword'];
        $adminStatus = $_POST['adminStatus'];
        $current_password = $_POST['adminCurrentpassword'];

        //check whether upload button is click or not
        if(isset($_FILES['adminImage']['name']))
        {
            $image_name = $_FILES['adminImage']['name']; //new image nname

            //check if the file is available or not
            if($image_name!="")
            {
                //image is available

                //rename the image
                $ext = end(explode('.', $image_name));
                $image_name = "Admin-Pic-".rand(0000, 9999).'.'.$ext;

                //get the source path and destination
                $src_path = $_FILES['adminImage']['tmp_name'];
                $destination_path = "admin_image/".$image_name;

                //upload the image
                $upload = move_uploaded_file($src_path,$destination_path);

                //check if the image is uploaded or not
                if($upload==false)
                {
                    //failed to upload
                    echo '<script>
                    swal({
                        title: "Error",
                        text: "Failed to upload image",
                        icon: "error"
                    }).then(function() {
                        window.location = "manage_user.php";
                    });
                </script>';

                exit;

                                
                }
                //remove the current image if available
                if($current_image!="")
                {
                    //current image is available
                    $remove_path = "admin_image/".$current_image;

                    $remove = unlink($remove_path);

                    //check whether the image is remove or not
                    if($remove==false)
                    {
                        //failed to remove current image
                        echo '<script>
                        swal({
                            title: "Error",
                            text: "Failed to remove current image",
                            icon: "error"
                        }).then(function() {
                            window.location = "manage_user.php";
                        });
                    </script>';

                    exit;

                        
                    }
                }
            }
        }
        else
        {
            $image_name = $current_image;
        }


        $sql1 = "SELECT * FROM  tbl_admin WHERE id = $id && password = '$current_password'";

        $result1 = mysqli_query($conn, $sql1);

        if($result1==true)
        {
            $count1 = mysqli_num_rows($result1);

            if($count1 == 1)
            {
                    //create sql query update
        $sql = "UPDATE tbl_admin SET full_name = '$admin_name' , email = '$admin_email', username = '$admin_username',
        phone_number = '$admin_phonenumber' ,   image = '$image_name', status = '$adminStatus' , password = '$new_password', status = 'Active'  WHERE id = '$id'";

        //execute the query
        $result = mysqli_query($conn,$sql);

        //check the query executed or not
        if($result == True)
        {
            //query update sucess
            echo '<script>
            swal({
                title: "Success",
                text: "Admin Profile Successfully Update",
                icon: "success"
            }).then(function() {
                window.location = "manage_profile.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
        }
        else{
            //failed to update
            echo '<script>
                swal({
                    title: "Error",
                    text: "Admin Failed to  Update",
                    icon: "error"
                }).then(function() {
                    window.location = "manage_profile.php";
                });
            </script>';

            exit;
        }
            }
        }
        

        
    }
?>

			

			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>