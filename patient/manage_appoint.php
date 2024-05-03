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
        $sql = "SELECT * FROM tbl_appoint";

        $res = mysqli_query($conn,$sql);

        if($res == true)
        {
            $count = mysqli_num_rows($res);

            if($count > 0)
            {
                while($row = mysqli_fetch_assoc($res))
                {
                    $full_name = $row['full_name'];
                    $date_raw = $row['date'];
            $date_formatted = date('F d, Y', strtotime($date_raw));

            // Format the time to "hh:mm AM/PM"
            $time_raw = $row['time'];
            $time_formatted = date('h:i A', strtotime($time_raw));
                    $reason = $row['reason'];
                }
                
            }
        }
        
        ?>
       <div class="col-md-5"> <!-- Use 5 columns out of 12 for a slightly smaller split -->
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
        $sql = "SELECT * FROM tbl_appoint";

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