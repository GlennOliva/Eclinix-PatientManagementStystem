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
                    <table class="table table-hover" id="patientTable" id="admin_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Patient Full_name</th>
                            <th>Appointment Time</th>
                            <th>Status</th>
                            <th>Action</th>
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

            // Format the time to "hh:mm AM/PM"
            $time_raw = $row['time'];
            $time_formatted = date('h:i A', strtotime($time_raw));
                    $status = $row['status'];


                    ?>



                            <tbody>
                            <tr>
                                <td><?php echo $ids++;?></td>
                                <td><?php echo $full_name;?></td>
                                <td> <?php echo htmlspecialchars($time_formatted); ?></td>
                                <td><?php echo $status;?></td>
                                <td>
                                <a href="update_appoint.php?id=<?php echo $id;?>" class="btn btn-primary btn-sm">Update</a>
                                <form action="code.php" method="post">
                                    <button type="button"  class="btn-del delete_appointbtn" value="<?= $id;?>">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <!-- More rows can be added here -->
                        </tbody>


                        <?php
                }
                
            }
        }
        
        ?>
                       
              
                    </tbody>
                </table>
                    </table>
                </div>
            </div>
 

       




</div>



			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script>
document.getElementById('searchButton').addEventListener('click', () => {
    filterTable();
});

document.getElementById('searchInput').addEventListener('keyup', () => {
    filterTable();
});

function filterTable() {
    // Get the input field value
    var input = document.getElementById('searchInput').value.toLowerCase();

    // Get the table rows
    var rows = document.querySelectorAll('#patientTable tbody tr');

    rows.forEach(row => {
        // Check if any cell content matches the search term
        var match = false;
        var cells = row.querySelectorAll('td');

        cells.forEach(cell => {
            if (cell.textContent.toLowerCase().includes(input)) {
                match = true;
            }
        });

        // Show or hide the row based on whether it matches
        row.style.display = match ? '' : 'none';
    });
}
</script>

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>