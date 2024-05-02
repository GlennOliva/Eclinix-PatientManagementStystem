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
        <div class="col-md-5"> <!-- Use 5 columns out of 12 for a slightly smaller split -->
            <div class="content-data">
                <div class="head">
                    <h3>Upcoming Visit</h3>
                </div>
                <div class="container mt-3 table-border">
                    <ul>
                        <li><strong>Patient Name:</strong> John Doe</li>
                        <li><strong>Date:</strong> May 3, 2024</li>
                        <li><strong>Time:</strong> 2:00 PM</li>
                        <li><strong>Reason:</strong> Annual Checkup</li>
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
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>John Doe</td>
                                <td>May 3, 2024</td>
                                <td>2:00 PM</td>
                            </tr>
                            <!-- More rows can be added here -->
                        </tbody>
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