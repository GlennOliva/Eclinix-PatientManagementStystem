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

		<!-- MAIN -->
		<main>
			<h1 class="title">Add Medical Supplies</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Add Medical Supplies</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">
                            <div class="mb-3">
                                <label for="inventoryImage" class="form-label">Medical Image</label>
                                <input type="file" class="form-control" name="medicalImage">
                            </div>
                            <div class="mb-3">
                                <label for="medicalame" class="form-label">Medical Name</label>
                                <input type="text" class="form-control" name="medicalName" placeholder="Enter Medical Name">
                            </div>
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">Medical Slot</label>
                                <input type="number" class="form-control" name="medicalSlot" placeholder="Enter Medical slot">
                            </div>
                            
                           
                            
                            <input type="submit" name = "add_medical" class="btn btn-primary" value="Add Medical">
                        </form>
                    </div>
                </div>
            </div>
			
            <?php
            if(isset($_SESSION['admin_id']))
            {
                $admin_id = $_SESSION['admin_id'];
        if(isset($_POST['add_medical']))
        {
            $medicalName = $_POST['medicalName'];
            $medicalSlot = $_POST['medicalSlot'];
            
            if(isset($_FILES['medicalImage']['name']))
    {
        //get the details of the selected image
        $image_name = $_FILES['medicalImage']['name'];

        //check if the imaage selected or not.
        if ($image_name != "") {
            // Image is selected
            // Rename the image
            $ext_parts = explode('.', $image_name);
            $ext = end($ext_parts);
        
            // Create a new name for the image
            $image_name = "Medical-Pic" . rand(0000, 9999) . "." . $ext;
        
            // Upload the image
        
            // Get the src path and destination path
        
            // Source path is the current location of the image
            $src = $_FILES['medicalImage']['tmp_name'];
        
            // Destination path for the image to be uploaded
            $destination = "medical_image/" . $image_name;
        
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
                        window.location = "add_inventory.php";
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
    $sql = "INSERT INTO tbl_medical SET  medical_name = '$medicalName' , medical_slot = $medicalSlot, 
     image = '$image_name', created_at = NOW(), admin_id = $admin_id
    ";

    //execute query to insert data in database
    $result = mysqli_query($conn , $sql) or die(mysqli_error());

    //check the query is executed or not

    if ($result == true) {
      
        
        echo '<script>
            swal({
                title: "Success",
                text: "Medical Successfully Inserted",
                icon: "success"
            }).then(function() {
                window.location = "manage_inventory.php";
            });
        </script>';
        
        exit; // Make sure to exit after performing the redirect
    }
    
else{
    echo '<script>
    swal({
        title: "Error",
        text: "Medical Failed to  Insert",
        icon: "error"
    }).then(function() {
        window.location = "add_medical.php";
    });
</script>';

exit;
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