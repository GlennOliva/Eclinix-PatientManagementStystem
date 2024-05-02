<?php
include('../config/dbcon.php');
session_start();

if (!isset($_SESSION['admin_id'])) {
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

if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    $sql = "SELECT * FROM tbl_admin WHERE id = $admin_id";

    // Assuming you are using mysqli for database operations
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $admin_name = $row['username'];
		$image = $row['image'];
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link rel="stylesheet" href="../style.css">
	<title>Admin</title>
</head>
<body>
	
	<!-- SIDEBAR -->
<section id="sidebar">
<a href="#" class="brand" style="padding-top: 5%;">
        <img src="../image/eclinicx-logo.png" style="width: 95%; height: auto; padding-top: 25%;" alt="Logo"> 
		  </a>
		 
		<ul class="side-menu">
			<li style="padding-top: 3%;"><a href="dashboard.php" class=""><i class='bx bxs-dashboard icon' ></i> Dashboard</a></li>
			<li class="divider"  data-text="User Management">User Management</li>
			<li>
				<a href="manage_admin.php"><i class='bx bxs-user icon' ></i> Doctor </i></a>
			</li>

			<li>
				<a href="#" ><i class='bx bxs-user icon' ></i> Patient <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
				<li><a href="manage_patient.php">View Patient</a></li>
					<li><a href="add_patient.php">Add Patient</a></li>
	
				</ul>
			</li>

			<li>
				<a href="manage_staff.php" ><i class='bx bxs-user icon' ></i> Staff </a>
			
			
			</li>




			<li class="divider" data-text="Appointment Management">Appointment Management</li>
			<li>
				<a href="#" ><i class='bx bxs-book icon' ></i> Appointment manage <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="manage_appoint.php">View Appointment</a></li>
				</ul>
			</li>
		
			<li class="divider" data-text="Patient Management">Patient Management</li>
			<li>
				<a href="#"><i class='bx bxs-user-plus icon'></i> Patient Records <i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a href="patient_records.php">Patient Records</a></li>
					<li><a href="add_patient_records.php">Add Patient Records</a></li>

				</ul>
			</li>

			<li>
				<a href="#"><i class='bx bxs-user-circle icon'></i> Patient List<i class='bx bx-chevron-right icon-right'></i></a>
				<ul class="side-dropdown">
					<li><a href="patient_list.php">Patient List</a></li>
				
				</ul>
			</li>

			<li class="divider" data-text="Inventory Management">Inventory Management</li>
			<li>
				<a href="#" class="active"><i class='bx bxs-capsule icon' ></i> Inventory Manage <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="manage_inventory.php">Inventory Records</a></li>
					<li><a href="add_inventory.php">Add Inventory</a></li>

				</ul>
			</li>


			<li class="divider" data-text="Reporting & Analytics ">Reporting and Analytics</li>
			<li>
				<a href="#"><i class='bx bxs-report icon' ></i> Reports Management <i class='bx bx-chevron-right icon-right' ></i></a>
				<ul class="side-dropdown">
					<li><a href="manage_report.php">Manage Reports</a></li>
				</ul>
			</li>

	



		</ul>
		
	</section>
	<!-- SIDEBAR -->

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#"></form>
			<a href="#" class="nav-link">
				<i class='bx bxs-bell icon' ></i>
				<span class="badge">5</span>
			</a>
			
		
			<span class="divider"></span>
			<div class="profile">
				<img src="admin_image/<?php echo $image;?>" alt="">
				<ul class="profile-link">
					<li><p style="padding-left: 10%; padding-top: 3%;">Hi there! <b><?php echo $admin_name;?></b></p></li>
					<li><a href="manage_profile.php"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="admin_logout.php"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->