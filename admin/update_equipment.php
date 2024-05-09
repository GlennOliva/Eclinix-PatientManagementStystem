<?php
include('../components/header-inventory.php');
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

//1get the id 
$id = $_GET['id'];

//create sql querty

$sql = "SELECT * FROM tbl_equipment WHERE id=$id";

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
        $medical_name = $rows['equipment_name'];
        $medical_slot = $rows['equipment_slot'];
        $current_image = $rows['image'];
        $date = $rows['created_at'];

      
    }
    else
    {
        header('Location: manage_equipments.php');
        exit();
    }
}

?>

		<!-- MAIN -->
		<main>
			<h1 class="title">Update Equipments</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update Equipments</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">
                        <div class="mb-3">
                                <label for="adminFullname" class="form-label">Current Image</label>
                                <img src="equipment_image/<?php echo $current_image;?>" style="width: 30%; margin: 2%;">
                            </div>
                            <div class="mb-3">
                                <label for="inventoryImage" class="form-label">New Image</label>
                                <input type="file" class="form-control" name="medicalImage">
                            </div>
                            <div class="mb-3">
                                <label for="medicalame" class="form-label">New Medical Name</label>
                                <input type="text" class="form-control" name="medicalName" placeholder="Enter Medical Name" value="<?php echo $medical_name;?>">
                            </div>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">New Quantity</label>
                                <input type="number" class="form-control" name="medicalSlot" placeholder="Enter Medical slot" value="<?php echo $medical_slot;?>">
                            </div>
                            
                           
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                            <input type="submit" name="update_medical" class="btn btn-primary" value = "Update Equipment">
                        </form>
                    </div>
                </div>
            </div>
			
            <?php
    
    //check whether the submit button is clicked or not
    if(isset($_POST['update_medical']))
    {
        $id = $_POST['id'];
        $medical_name = $_POST['medicalName'];
        $medical_slot = $_POST['medicalSlot'];
        $current_image = $_POST['current_image'];

        //check whether upload button is click or not
        if(isset($_FILES['medicalImage']['name']))
        {
            $image_name = $_FILES['medicalImage']['name']; //new image nname

            //check if the file is available or not
            if($image_name!="")
            {
                //image is available

                //rename the image
                $parts = explode('.', $image_name);

                // Then, use end() on the array to get the last part (i.e., file extension).
                $ext = end($parts);
                
                // Construct the new image name.
                $image_name = "Equipment-Pic-" . rand(0000, 9999) . '.' . $ext;
                
                // Get the source path and destination path.
                $src_path = $_FILES['medicalImage']['tmp_name'];
                $destination_path = "equipment_image/" . $image_name;
                
                // Attempt to upload the image.
                $upload = move_uploaded_file($src_path, $destination_path);

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
                        window.location = "manage_equipments.php";
                    });
                </script>';

                exit;

                                
                }
                //remove the current image if available
                if($current_image!="")
                {
                    //current image is available
                    $remove_path = "equipment_image/".$current_image;

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
                            window.location = "manage_equipments.php";
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




        //create sql query update
        $sql = "UPDATE tbl_equipment SET equipment_name = '$medical_name' , equipment_slot = '$medical_slot',    
        image = '$image_name', created_at = NOW()  WHERE id = '$id'";

        //execute the query
        $result = mysqli_query($conn,$sql);

        //check the query executed or not
        if($result == True)
        {
            //query update sucess
            echo '<script>
            swal({
                title: "Success",
                text: "Equipment Successfully Update",
                icon: "success"
            }).then(function() {
                window.location = "manage_equipments.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
        }
        else{
            //failed to update
            echo '<script>
                swal({
                    title: "Error",
                    text: "Medical Failed to  Update",
                    icon: "error"
                }).then(function() {
                    window.location = "update_equipment.php";
                });
            </script>';

            exit;
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