<?php
include('../components/patient_header-appoint.php');
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

		<!-- MAIN -->
		<main>
			<h1 class="title">Patient Appointment</h1>
			<ul class="breadcrumbs">
				<li><a href="#">patient</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Patient Appointment</a></li>
			</ul>
            <div class="container">
    <!-- Begin row -->
    <div class="row">
        <!-- First column: Upcoming Visit -->

        <?php
       $full_name = 'N/A'; // Default values
       $date_formatted = 'N/A';
       $time_formatted = 'N/A';
       $reason = 'N/A';
       
       if (isset($_SESSION['patient_id'])) {
           $patient_id = $_SESSION['patient_id'];
       
           // Prepare the SQL statement with a parameter placeholder to prevent SQL injection
           $stmt = $conn->prepare("SELECT full_name, date, time, reason FROM tbl_appoint WHERE patient_id = ?");
           $stmt->bind_param("i", $patient_id);
       
           if ($stmt->execute()) {
               // Get the result set
               $res = $stmt->get_result();
       
               if ($res->num_rows > 0) {
                   // Fetch the first row of the result
                   $row = $res->fetch_assoc();
       
                   // Extract the required information
                   $full_name = $row['full_name'] ?? 'N/A'; // Default to 'N/A' if null
                   $date_raw = $row['date'] ?? '';
                   $time_raw = $row['time'] ?? '';
                   $reason = $row['reason'] ?? 'N/A';
       
                   // Format the date and time
                   if ($date_raw) {
                       $date_formatted = date('F d, Y', strtotime($date_raw));
                   }
       
                   if ($time_raw) {
                       $time_formatted = date('h:i A', strtotime($time_raw));
                   }
               }
           } else {
               echo "Error executing query: " . $stmt->error;
           }
       
           // Close the prepared statement
           $stmt->close();
       } else {
           echo "Patient ID is not set in session.";
       }
       ?>
      <div class="col-md-5">
    <div class="content-data">
        <div class="head">
            <h3>Upcoming Visit</h3>
        </div>
        <div class="container mt-3 table-border">
            <ul>
                <li><strong>Patient Name:</strong> <?php echo htmlspecialchars($full_name); ?></li>
                <li><strong>Date:</strong> <?php echo htmlspecialchars($date_formatted); ?></li>
                <li><strong>Time:</strong> <?php echo htmlspecialchars($time_formatted); ?></li>
                <li><strong>Reason:</strong> <?php echo htmlspecialchars($reason); ?></li>
            </ul>
        </div>
    </div>
</div>


        <!-- Second column: Booked Appointment -->
        <div class="col-md-7"> <!-- Use 7 columns for the second part for a larger table -->
            <div class="content-data">
                <div class="head">
                    <h3>Booked Appointment</h3>
                </div>
                <div class="container mt-3 table-border">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th style="background-color: #FFAA2B !important;">ID</th>
                                <th style="background-color: #FFAA2B !important;">Patient Full Name</th>
                                <th style="background-color: #FFAA2B !important;">Appointment Date</th>
                                <th style="background-color: #FFAA2B !important;">Appointment Time</th>
                            </tr>
                        </thead>

                        
        <?php
        $sql = "SELECT * FROM tbl_appoint WHERE patient_id = $patient_id AND status = 'Approve'";

        $res = mysqli_query($conn,$sql);

        if($res == true)
        {
            $count = mysqli_num_rows($res);
            $ids = 1;
            if($count > 0)
            {
                while($row = mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $full_name = $row['full_name'];
                    $date_raw = $row['date'];
            $date_formatted = date('F d, Y', strtotime($date_raw));

            // Format the time to "hh:mm AM/PM"
            $time_raw = $row['time'];
            $time_formatted = date('h:i A', strtotime($time_raw));
                    $reason = $row['reason'];


                    ?>



                            <tbody>
                            <tr>
                                <td><?php echo $ids++;?></td>
                                <td><?php echo $full_name;?></td>
                                <td><?php echo htmlspecialchars($date_formatted);?></td>
                                <td> <?php echo htmlspecialchars($time_formatted); ?></td>
                            </tr>
                            <!-- More rows can be added here -->
                        </tbody>


                        <?php
                }
                
            }
        }
        
        ?>
    
                        

                
                        
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

   

</div>

			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>