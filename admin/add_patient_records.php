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

		<!-- MAIN -->
		<main>
			<h1 class="title">Add Patient Records</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Add Patient Records</a></li>
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
                                <input type="text" class="form-control" name="patientIllness" placeholder="Enter Patient Illness">
                            </div>

                            <div class="mb-3">
                                <label for="medicalame" class="form-label">Patient Age</label>
                                <input type="text" class="form-control" name="patientAge" placeholder="Enter Patient Age">
                            </div>
               
                            <!-- Text area for Treatment -->
<div class="mb-3">
    <label for="treatment" class="form-label">Treatment</label>
    <textarea class="form-control" name="patientTreatment" rows="4" placeholder="Describe the treatment plan"></textarea>
</div>

<!-- Text area for Prescription -->
<div class="mb-3">
    <label for="prescription" class="form-label">Prescription</label>
    <textarea class="form-control" name="patientPrescription" rows="4" placeholder="List any prescribed medications"></textarea>
</div>


<!-- Text area for Prescription -->
<div class="mb-3">
    <label for="prescription" class="form-label">Laboratory Request</label>
    <textarea class="form-control" name="laboratoryReq" rows="4" placeholder="List of Laboratory Request"></textarea>
</div>
                           
                            
                            <input type="submit" name = "add_patientrecords" class="btn btn-primary" value="Add Patient Records">
                        </form>
                    </div>
                </div>
            </div>
			
            <?php
 
 if (isset($_POST['add_patientrecords'])) {
    $patient = $_POST['patient_id'];
    $medical = $_POST['medical_id'];
    $patientIllness = $_POST['patientIllness'];
    $patientTreatment = $_POST['patientTreatment'];
    $patientPrescription = $_POST['patientPrescription'];
    $laboratoryReq = $_POST['laboratoryReq'];
    $age = $_POST['patientAge'];

    // Start a transaction to ensure both operations succeed or fail together
    mysqli_begin_transaction($conn);

    try {
        // Insert the patient record
        $insert_sql = "INSERT INTO tbl_records (patient_id, medical_id, illness, treatment, prescriptions, laboratory_req, age) 
                       VALUES ('$patient', '$medical', '$patientIllness', '$patientTreatment', '$patientPrescription' , '$laboratoryReq', $age)";
        $insert_result = mysqli_query($conn, $insert_sql);
        
        if (!$insert_result) {
            throw new Exception(mysqli_error($conn)); // Trigger rollback on error
        }

        // Deduct a slot from tbl_medical
        $update_slot_sql = "UPDATE tbl_medical SET medical_slot = medical_slot - 1 WHERE id = '$medical'";
        $update_slot_result = mysqli_query($conn, $update_slot_sql);

        if (!$update_slot_result) {
            throw new Exception(mysqli_error($conn)); // Trigger rollback on error
        }

        // Commit the transaction
        mysqli_commit($conn);

        echo '<script>
            swal({
                title: "Success",
                text: "Patient Records Successfully Inserted, and Medical Slot Deducted",
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
                text: "Failed to Insert Patient Record or Deduct Slot: ' . $e->getMessage() . '",
                icon: "error"
            }).then(function() {
                window.location = "add_patient_records.php";
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