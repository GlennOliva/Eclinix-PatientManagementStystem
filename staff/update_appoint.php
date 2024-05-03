<?php
include('../components/staff_header-appoint.php');
include('../config/dbcon.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
?>


<?php
if(!isset($_SESSION['staff_id']))
{
    echo '<script>
                                    swal({
                                        title: "Error",
                                        text: "You must login first before you proceed!",
                                        icon: "error"
                                    }).then(function() {
                                        window.location = "staff_login.php";
                                    });
                                </script>';
                                exit;
}

?>


<?php

//1get the id 
$id = $_GET['id'];

//create sql querty

$sql = "
    SELECT 
        tbl_appoint.id, 
        tbl_appoint.full_name, 
        tbl_appoint.date, 
        tbl_appoint.time, 
        tbl_appoint.reason, 
        tbl_appoint.status,
        tbl_patient.email
    FROM 
        tbl_appoint
    INNER JOIN 
        tbl_patient 
    ON 
        tbl_appoint.patient_id = tbl_patient.id
    WHERE 
        tbl_appoint.id = $id
";

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
        $row = mysqli_fetch_assoc($result);

        $id = $row['id'];
        $full_name = $row['full_name'];
        $date_raw = $row['date'];
$date_formatted = date('F d, Y', strtotime($date_raw));

// Format the time to "hh:mm AM/PM"
$time_raw = $row['time'];
$time_formatted = date('h:i A', strtotime($time_raw));
        $reason = $row['reason'];
        $status = $row['status'];
        $email = $row['email'];

        $date_formatted_input = date('Y-m-d', strtotime($date_raw)); // 2024-05-03
$time_formatted_input = date('H:i', strtotime($time_raw));   // 14:00

      
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
			<h1 class="title">Update Appointment</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update Appointment</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form style="border: 2px solid #00204a; padding: 20px; border-radius: 12px;" method="post">
          <div class="mb-3">
            <label for="patientName">Patient Name</label>
            <input
              type="text"
              class="form-control"
              id="patientName"
              name="patient_name"
              placeholder="Enter patient name"
              value="<?php echo $full_name;?>"
              readonly
            />
          </div>
          <div class="mb-3">
            <label for="appointmentDate">Appointment Date</label>
            <input
              type="date"
              class="form-control"
              name="date"
              id="appointmentDate"
              value="<?php echo htmlspecialchars($date_formatted_input); ?>"
              readonly
            />
          </div>
          <div class="mb-3">
  <label for="appointmentTime">Appointment Time</label>
  <input
    type="time"
    class="form-control"
    id="appointmentTime"
    name="time"
    min="09:00"  
    max="14:00"  
    step="1800" 
    value="<?php echo htmlspecialchars($time_formatted_input); ?>"
    readonly
  />
</div>



          <div class="mb-3">
            <label for="appointmentReason">Reason</label>
            <textarea
              class="form-control"
              id="appointmentReason"
              placeholder="Enter reason for the appointment"
              name="reason"
              readonly
            ><?php echo $reason;?></textarea>
            
          </div>

                            <div class="mb-3">
                                <label for="organizationTitle" class="form-label">Appointment Status</label>
                                <select class="form-control" name="appointment_type">
                                    <option value="">Select Status</option>
                                    <option value="Approve">Approve</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Revision">Pending</option>
                                </select>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="hidden" name="email" value="<?php echo $email;?>">
                            <input type="submit" name="update_appoint" class="btn btn-primary" value="Update Appoint Status">
                        </form>
                    </div>
                </div>
            </div>

			
		</main>


        <?php
        function sendEmail($to, $appointmentDateFormatted, $time_12, $patient_name , $appointment_type, $reason)
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
                $mail->Subject = 'Thankyou for booking appoint Eclinicx';
                $mail->Body = "
    <p>Dear $patient_name,</p>

    <p>We are writing to confirm your appointment at Ocampos Children & Maternity Clinic.</p>

    <p><strong>Appointment Details:</strong></p>
    <ul>
        <li><strong>Your Appointment is: </strong> $appointment_type</li>
        <li><strong>Appointment Date:</strong> $appointmentDateFormatted</li>
        <li><strong>Appointment Time:</strong> $time_12</li>
        <li><strong>Reason:</strong> $reason</li>
    </ul>

    <p>Thank you for choosing Ocampos Children & Maternity Clinic. We look forward to seeing you.</p>

    <p>If you have any questions or need to reschedule, please contact us at eclinixpediatric@gmail.com.</p>

    <p>Sincerely,<br>Ocampos Children & Maternity Clinic</p>
";

        
                $mail->send();
            } catch (Exception $e) {
                // Handle exception (you can log it or display an error message)
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }


        if(isset($_POST['update_appoint']))
        {
            $patient_name = $_POST['patient_name'];
            $patient_email = $_POST['email'];
            $appointmentDate = $_POST['date'];
            $appointmentDateFormatted = date('F d, Y', strtotime($appointmentDate));
            $time = $_POST['time'];
            $time_12 = date('h:i A', strtotime($time));
            $reason = $_POST['reason'];
            $appointment_type = $_POST['appointment_type'];
      
            
           
    //SQL query to save the data into database
    $sql = "UPDATE tbl_appoint SET full_name = '$patient_name' , date = '$appointmentDate', time = '$time',
    reason = '$reason' , status = '$appointment_type'  WHERE id = $id";

    //execute query to insert data in database
    $result = mysqli_query($conn , $sql) or die(mysqli_error());

    //check the query is executed or not

    if ($result == true) {
      
        sendEmail($patient_email, $appointmentDateFormatted, $time_12, $patient_name , $appointment_type, $reason);
        echo '<script>
            swal({
                title: "Success",
                text: "Update Successfully Appoint",
                icon: "success"
            }).then(function() {
                window.location = "manage_appoint.php";
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




        <style>
            .table-border {
                border: 2px solid #dee2e6; /* Bootstrap's default border color */
                padding: 10px;
                border-radius: 5px; /* Optional: rounds the corners of the border */
            }
        </style>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>