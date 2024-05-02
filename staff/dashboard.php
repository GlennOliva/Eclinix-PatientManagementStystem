<?php
include('../components/staff_header-dashboard.php');
include('../config/dbcon.php');

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


		<!-- MAIN -->
		<main>
			<h1 class="title">Dashboard</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Home</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Dashboard</a></li>
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
				
					<?php
				// // Assuming $conn is your database connection and is already opened

				// $sql = "SELECT COUNT(*) AS count FROM tbl_appoint";
				// $res = mysqli_query($conn, $sql);

				// if ($res) {
				// 	$row = mysqli_fetch_assoc($res);
				// 	$appointCount = $row['count']; // Directly access the count
				// } else {
				// 	$appointCount = 0; // In case the query fails
				// }
				?>


				</div>
				<div class="card">
					<div class="head">
						<div>
							<h2></h2>
							<p>Total Appointment.</p>
						</div>
						<i class='bx bx-book icon' ></i>
					</div>
					
				</div>
			</div>
			<div class="data">
			



<!-- Begin container for the whole row -->

            <div class="content-data">
                <div class="head">
                    <h3>Booked Appointment</h3>
                </div>
                <div class="container mt-3 table-border">
                    <div class="input-group mb-3" style="width: 30%;"> <!-- Adjust width to fill the column -->
                        <input type="text" id="searchInput" class="form-control" placeholder="Search Patient">
                        <div class="input-group-append" style="padding-left: 10px;">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                        </div>
                    </div>
                    <table class="table table-hover" style="width: 100%;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Queue</th>
                                <th>ID</th>
                                <th>Patient Name</th>
                                <th>Status</th>
                                <th>Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>110</td>
                                <td>John</td>
                                <td>Old</td>
                                <td>1:00 am</td>
                                <td>
                                    <a href="update_appoint.php" class="btn btn-primary btn-sm">Update</a>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                            <!-- More rows can be added here -->
                        </tbody>
                    </table>
                </div>
            </div>
 

       




</div>



			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>