<?php
include('../components/header-dashboard.php');
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
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="dashboard.php">Home</a></li>
				<li class="divider">/</li>
                <li><a href="patient_summary.php">Patient Summary</a></li>
				<li class="divider">/</li>
                <li><a href="patient_group.php">Patient Age Group</a></li>
				<li class="divider">/</li>
                <li><a href="booked_appoint.php">Booked Appointment</a></li>
				<li class="divider">/</li>
                <li><a href="medical_supply.php">Medical Supplies</a></li>
			</ul>


			<?php
				// Assuming $conn is your database connection and is already opened

				// $sql = "SELECT COUNT(*) AS count FROM tbl_patient";
				// $res = mysqli_query($conn, $sql);

				// if ($res) {
				// 	$row = mysqli_fetch_assoc($res);
				// 	$patientCount = $row['count']; // Directly access the count
				// } else {
				// 	$venueCount = 0; // In case the query fails
				// }
				?>


			<div class="info-data">
				<div class="card">
				<?php
				// Assuming $conn is your database connection and is already opened

				$sql = "SELECT COUNT(*) AS count FROM tbl_patient";
				$res = mysqli_query($conn, $sql);

				if ($res) {
					$row = mysqli_fetch_assoc($res);
					$patientCount = $row['count']; // Directly access the count
				} else {
					$patientCount = 0; // In case the query fails
				}
				?>


					<div class="head">
						<div>
							<h2><?php echo $patientCount;?></h2>
							<p>New Patients</p>
						</div>
						<i class='bx bx-user-plus icon' ></i>
					</div>
				
				</div>


				<?php
				// Assuming $conn is your database connection and is already opened

				$sql = "SELECT COUNT(*) AS count FROM tbl_medical";
				$res = mysqli_query($conn, $sql);

				if ($res) {
					$row = mysqli_fetch_assoc($res);
					$medicalCount = $row['count']; // Directly access the count
				} else {
					$medicalCount = 0; // In case the query fails
				}
				?>


				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $medicalCount;?></h2>
							<p>Medical Supplies No.</p>
						</div>
						<i class='bx bx-trending-down icon down' ></i>
					</div>
				
				</div>


				<?php
				// Assuming $conn is your database connection and is already opened

				$sql = "SELECT COUNT(*) AS count FROM tbl_staff";
				$res = mysqli_query($conn, $sql);

				if ($res) {
					$row = mysqli_fetch_assoc($res);
					$staffCount = $row['count']; // Directly access the count
				} else {
					$staffCount = 0; // In case the query fails
				}
				?>

				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $staffCount;?></h2>
							<p>Staff no.</p>
						</div>
						<i class='bx bx-trending-up icon' ></i>
					</div>
				
			


				</div>

                <?php
				// Assuming $conn is your database connection and is already opened

				$sql = "SELECT COUNT(*) AS count FROM tbl_appoint";
				$res = mysqli_query($conn, $sql);

				if ($res) {
					$row = mysqli_fetch_assoc($res);
					$appointCount = $row['count']; // Directly access the count
				} else {
					$appointCount = 0; // In case the query fails
				}
				?>
				<div class="card">
					<div class="head">
						<div>
							<h2><?php echo $appointCount;?></h2>
							<p>Total Appointment.</p>
						</div>
						<i class='bx bx-book icon' ></i>
					</div>
					
				</div>
			</div>
			


			
		</main>
		<!-- MAIN -->
	</section>


    

	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="js/appoint.js"></script>
</body>
</html>