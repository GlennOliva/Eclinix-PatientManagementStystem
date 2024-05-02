<?php
include('../components/header-patient.php');
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

$sql = "SELECT * FROM tbl_records WHERE id=$id";

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
        $patient_id = $rows['patient_id'];
        $medical_id = $rows['medical_id'];
        $illness = $rows['illness'];
        $treatment = $rows['treatment'];
        $prescriptions= $rows['prescriptions'];
        $age = $rows['age'];

      
    }
    else
    {
        header('Location: patient_records.php');
        exit();
    }
}

?>

		<!-- MAIN -->
		<main>
			<h1 class="title">Update Patient Records</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update Patient Records</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form method="post" enctype="multipart/form-data" style="box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 20px; border-radius: 12px;">

                          <!-- Patient -->
                          <div class="mb-3">
                                            <label for="eventOrganizer" class="form-label">Patient</label>
                                            <select class="form-control" name="patient_id" id="eventOrganizer">
                                                
 <?php
                                // Query to fetch all courses from the table
                                $sql = "SELECT * FROM tbl_patient";

                                // Execute the query
                                $result = mysqli_query($conn, $sql);

                               $count = mysqli_num_rows($result);
                               if($count > 0 )
                               {
                                   while($row = mysqli_fetch_assoc($result))
                                   {   
                                       $patient_id = $row['id'];
                                       $patient_name = $row['full_name'];
                                      
                                       ?>
                   
                   <option value="<?php echo $patient_id; ?>"><?php echo $patient_name;?></option>
                                       
                   
                                       <?php
                                   }
                               }
                               else
                               {
                                   //we don't have faculty member
                                   ?>
                                   <option value="0" >No Patient Found</option>                                    
                   
                                   <?php
                               }
                               ?>

                                            </select>
                                           
                                        </div>



                                           <!-- Medical -->
                          <div class="mb-3">
                                            <label for="eventOrganizer" class="form-label">Medical</label>
                                            <select class="form-control" name="medical_id" id="eventOrganizer">
                                                
 <?php
                                // Query to fetch all courses from the table
                                $sql = "SELECT * FROM tbl_medical";

                                // Execute the query
                                $result = mysqli_query($conn, $sql);

                               $count = mysqli_num_rows($result);
                               if($count > 0 )
                               {
                                   while($row = mysqli_fetch_assoc($result))
                                   {   
                                       $medical_id = $row['id'];
                                       $medical_name = $row['medical_name'];
                                      
                                       ?>
                   
                   <option value="<?php echo $medical_id; ?>"><?php echo $medical_name;?></option>
                                       
                   
                                       <?php
                                   }
                               }
                               else
                               {
                                   //we don't have faculty member
                                   ?>
                                   <option value="0" >No Medical Found</option>                                    
                   
                                   <?php
                               }
                               ?>

                                            </select>
                                           
                                        </div>
                            <div class="mb-3">
                                <label for="medicalame" class="form-label">Illness</label>
                                <input type="text" class="form-control" name="patientIllness" placeholder="Enter Patient Illness" value="<?php echo $illness;?>">
                            </div>
               
                            <!-- Text area for Treatment -->
<div class="mb-3">
    <label for="treatment" class="form-label">Treatment</label>
    <textarea class="form-control" name="patientTreatment" rows="4" placeholder="Describe the treatment plan"><?php echo $treatment;?></textarea>
</div>

<!-- Text area for Prescription -->
<div class="mb-3">
    <label for="prescription" class="form-label">Prescription</label>
    <textarea class="form-control" name="patientPrescription" rows="4" placeholder="List any prescribed medications"><?php echo $prescriptions;?></textarea>
</div>

<div class="mb-3">
                                <label for="medicalame" class="form-label">Patient Age</label>
                                <input type="text" class="form-control" name="patientAge" placeholder="Enter Patient Age">
                            </div>
                           
<input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="submit" name = "update_patientrecords" class="btn btn-primary" value="Update Medical">
                        </form>
                    </div>
                </div>
            </div>
			
          <?php
if (isset($_POST['update_patientrecords'])) {
    $record_id = $_POST['id']; // Get the record ID to be updated
    $new_patient_id = $_POST['patient_id']; // New patient ID
    $new_medical_id = $_POST['medical_id']; // New medical ID
    $new_patientIllness = $_POST['patientIllness'];
    $new_patientTreatment = $_POST['patientTreatment'];
    $new_patientPrescription = $_POST['patientPrescription'];
    $age = $_POST['patientAge'];

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Retrieve the current medical_id from the record to be updated
        $get_current_medical_sql = "SELECT medical_id FROM tbl_records WHERE id = '$record_id'";
        $current_medical_result = mysqli_query($conn, $get_current_medical_sql);
        
        if (!$current_medical_result) {
            throw new Exception("Failed to retrieve current medical ID");
        }

        $current_medical_row = mysqli_fetch_assoc($current_medical_result);
        $current_medical_id = $current_medical_row['medical_id'];

        // Update the record with the new data
        $update_record_sql = "UPDATE tbl_records
                              SET patient_id = '$new_patient_id', medical_id = '$new_medical_id', illness = '$new_patientIllness', treatment = '$new_patientTreatment', prescriptions = '$new_patientPrescription'
                              , age = '$age'
                              WHERE id = '$record_id'";
        $update_record_result = mysqli_query($conn, $update_record_sql);

        if (!$update_record_result) {
            throw new Exception("Failed to update patient record");
        }

        // If the medical ID has changed, adjust the slots
        if ($current_medical_id != $new_medical_id) {
            // Increase the slot for the old medical ID
            $increase_slot_sql = "UPDATE tbl_medical SET medical_slot = medical_slot + 1 WHERE id = '$current_medical_id'";
            $increase_slot_result = mysqli_query($conn, $increase_slot_sql);

            if (!$increase_slot_result) {
                throw new Exception("Failed to increase slot for old medical ID");
            }

            // Decrease the slot for the new medical ID
            $decrease_slot_sql = "UPDATE tbl_medical SET medical_slot = medical_slot - 1 WHERE id = '$new_medical_id'";
            $decrease_slot_result = mysqli_query($conn, $decrease_slot_sql);

            if (!$decrease_slot_result) {
                throw new Exception("Failed to decrease slot for new medical ID");
            }
        }

        // Commit the transaction
        mysqli_commit($conn);

        echo '<script>
            swal({
                title: "Success",
                text: "Patient Record Successfully Updated, Slot Adjusted",
                icon: "success"
            }).then(function() {
                window.location = "patient_records.php";
            });
        </script>';

    } catch (Exception $e) {
        // Rollback the transaction if there's an error
        mysqli_rollback($conn);

        echo '<script>
            swal({
                title: "Error",
                text: "Failed to Update Patient Record or Adjust Slots: ' . $e->getMessage() . '",
                icon: "error"
            }).then(function() {
                window.location = "edit_patient_record.php?id=' . $record_id . '";
            });
        </script>';
    }

    exit;
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