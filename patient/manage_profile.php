<?php
include('../components/patient_header-patient.php');
include('../config/dbcon.php');

?>

<?php
if(!isset($_SESSION['patient_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "patient_login.php";
                                    });
                                </script>';
                                exit;
}




?>


<?php

//1get the id 
$id = $_GET['id'];

//create sql querty

$sql = "SELECT * FROM tbl_patient WHERE id=$id";

//execute the query
$result = mysqli_query($conn,$sql);

//check if the query is executed or not!
if($result == True)
{
    //check if the data is available or not
    $count = mysqli_num_rows($result);

    //ccheck if we have admin data or not
    if($count == 1)
    {
        //display the details
        //echo "admin available"; 
        $rows = mysqli_fetch_assoc($result);

        $id = $rows['id'];
        $full_name = $rows['full_name'];
        $email = $rows['email'];
        $dob = $rows['dob'];
        $gender = $rows['gender'];
        $phone_number = $rows['phone_number'];
        $current_image = $rows['image'];
        $date = $rows['date'];
        $status = $rows['status'];

      
    }
    else
    {
        header('Location: manage_profile.php');
        exit();
    }
}

?>










		<!-- MAIN -->
		<main>
			<h1 class="title">Update patient Profile</h1>
			<ul class="breadcrumbs">
				<li><a href="#">patient</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update patient Profile</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">
                        <div class="mb-3">
                                <label for="adminFullname" class="form-label">Profile Image</label>
                                <img src="../admin/patient_image/<?php echo $current_image;?>" style="width: 30%; margin: 2%;">
                            </div>
                            <div class="mb-3">
                                <label for="adminFullname" class="form-label">patient Full Name</label>
                                <input type="text" class="form-control" name="adminFullname" placeholder="Enter full name" value="<?php echo $full_name;?>">
                            </div>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">patient Email</label>
                                <input type="email" class="form-control" name="adminEmail" placeholder="Enter email" value="<?php echo $email;?>">
                            </div>
                 
                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">patient Phone Number</label>
                                <input type="tel" class="form-control" name="adminPhoneNumber" placeholder="Enter phone number" maxlength="11" value="<?php echo $phone_number;?>">
                            </div>


                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">patient Current Password</label>
                                <input type="password" class="form-control" name="adminCurrentpassword" placeholder="Enter current password">
                                
                            </div>

                            <div class="mb-3">
                                <label for="adminPhoneNumber" class="form-label">patient New Password</label>
                                <input type="password" class="form-control" name="adminNewpassword" placeholder="Enter New password">
                            </div>

                            <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Male" <?php echo ($gender == 'Male')? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($gender == 'Female')? 'selected' : ''; ?>>Female</option>
                                        <option value="Lgbtq" <?php echo ($gender == 'Lgbtq')? 'selected' : ''; ?>>Lgbtq</option>
                                    </select>
                                </div>


                                                     <!-- Date of Birth Field -->
                            <div class="mb-3">
                                    <label for="dob" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Select your date of birth">
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
        $admin_phonenumber = $_POST['adminPhoneNumber'];
        $current_image = $_POST['current_image'];
        $new_password = $_POST['adminNewpassword'];
        $current_password = $_POST['adminCurrentpassword'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];

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
                $image_name = "patient-Pic-".rand(0000, 9999).'.'.$ext;

                //get the source path and destination
                $src_path = $_FILES['adminImage']['tmp_name'];
                $destination_path = "../admin/patient_image/".$image_name;

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
                        window.location = "manage_patient.php";
                    });
                </script>';

                exit;

                                
                }
                //remove the current image if available
                if($current_image!="")
                {
                    //current image is available
                    $remove_path = "../admin/patient_image/".$current_image;

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
                            window.location = "manage_patient.php";
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


        $sql1 = "SELECT * FROM  tbl_patient WHERE id = $id && password = '$current_password'";

        $result1 = mysqli_query($conn, $sql1);

        if($result1==true)
        {
            $count1 = mysqli_num_rows($result1);

            if($count1 == 1)
            {
                    //create sql query update
        $sql = "UPDATE tbl_patient SET full_name = '$admin_name' , email = '$admin_email',
        phone_number = '$admin_phonenumber' ,   image = '$image_name',  password = '$new_password', status = 'Active' , gender = '$gender' , dob = '$dob'  WHERE id = '$id'";

        //execute the query
        $result = mysqli_query($conn,$sql);

        //check the query executed or not
        if($result == True)
        {
            //query update sucess
            echo '<script>
            swal({
                title: "Success",
                text: "patient Profile Successfully Update",
                icon: "success"
            }).then(function() {
                window.location = "manage_calendar.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
        }
        else{
            //failed to update
            echo '<script>
                swal({
                    title: "Error",
                    text: "patient Failed to  Update",
                    icon: "error"
                }).then(function() {
                    window.location = "manage_calendar.php";
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