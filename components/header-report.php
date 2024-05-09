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
    <!-- Brand Section with Logo -->
    <a href="#" class="brand" style="padding-top: 5%;">
        <img src="../image/eclinicx-logo.png" style="width: 95%; height: auto; padding-top: 25%;" alt="Logo"> 
    </a>
    
    <!-- Main Menu -->
    <ul class="side-menu" style="margin-top: 25%;">
	<li onclick="toggleDropdown(event)" class="divider" data-text="Dashboard" style="color: black !important;">
            <i class='bx bxs-user-management icon'></i> Dashboard
        </li>
        
        <!-- Dropdown for User Management -->
        <ul class="sub-menu" style="display: none;">
            <li><a href="dashboard.php"><i class='bx bxs-dashboard icon'></i> Dashboard</a></li>

        </ul>


        <!-- User Management Section -->
        <li onclick="toggleDropdown(event)" class="divider" data-text="User Management" style="color: black !important;">
            <i class='bx bxs-user-management icon'></i> User Management
        </li>
        
        <!-- Dropdown for User Management -->
        <ul class="sub-menu" style="display: none;">
            <li><a href="manage_admin.php"><i class='bx bxs-user icon'></i> Doctor</a></li>
            <li><a href="manage_patient.php"><i class='bx bxs-user icon'></i> Patient</a></li>
            <li><a href="manage_staff.php"><i class='bx bxs-user icon'></i> Staff</a></li>
        </ul>
        
        <!-- Appointment Management Section -->
        <li class="divider" data-text="Appointment Management" onclick="toggleDropdown(event)" style="color: black !important;">
            <i class='bx bxs-book icon'></i> Appointment Management
        </li>
        
        <!-- Dropdown for Appointment Management -->
        <ul class="sub-menu" style="display: none;">
		<li><a href="manage_appoint.php" class="active"><i class='bx bxs-calendar icon'></i> Appointment</a></li>
        </ul>
        
        <!-- Patient Management Section -->
        <li class="divider" data-text="Patient Management" onclick="toggleDropdown(event)" style="color: black !important;">
            <i class='bx bxs-user-plus icon'></i> Patient Management
        </li>
        
        <!-- Dropdown for Patient Management -->
        <ul class="sub-menun" style="display: none;">
            <li><a href="patient_records.php"><i class='bx bxs-user-plus icon'></i>Patient Records</a></li>
            <li><a href="patient_list.php"><i class='bx bxs-user-detail icon'></i>Patient List</a></li>
        </ul>
        
        <!-- Inventory Management Section -->
        <li class="divider" data-text="Inventory Management" onclick="toggleDropdown(event)" style="color: black !important;">
            <i class='bx bxs-capsule icon'></i> Inventory Management
        </li>
        
         <!-- Dropdown for Inventory Management -->
         <ul class="sub-menu" style="display: none;">
            <li><a href="manage_inventory.php"><i class='bx bxs-capsule icon'></i>Medicine Records</a></li>
			<li><a href="manage_equipments.php"><i class='bx bxs-store-alt icon'></i>Equipments Records</a></li>
        </ul>
        
        <!-- Reporting and Analytics Section -->
        <li class="divider" data-text="Reporting and Analytics" onclick="toggleDropdown(event)" style="color: black !important;">
            <i class='bx bxs-report icon'></i> Reporting and Analytics
        </li>
        
        <!-- Dropdown for Reporting and Analytics -->
        <ul class="sub-menu" style="display: none;">
		<li><a href="manage_report.php"><i class='bx bxs-report icon'></i>Manage Reports</a></li>
        </ul>

		<!-- Reporting and Analytics Section -->
        <li class="divider" data-text="Archive Management" onclick="toggleDropdown(event)" style="color: black !important;">
            <i class='bx bxs-report icon'></i> Archive Management
        </li>
        
       <!-- Dropdown for Reporting and Analytics -->
       <ul class="sub-menu" style="display: none;">
		<li><a href="archive_patient.php"><i class='bx bxs-archive icon'></i>Patient Archive</a></li>
		<!-- <li><a href="manage_report.php"><i class='bx bxs-archive icon'></i>Staff Archive</a></li>
		<li><a href="manage_report.php"><i class='bx bxs-archive icon'></i>Admin Archive</a></li> -->
		<li><a href="archive_medicine.php"><i class='bx bxs-archive icon'></i>Medicine Archive</a></li>
		<li><a href="archive_equipment.php"><i class='bx bxs-archive icon'></i>Equipment Archive</a></li>
		<li><a href="archive_records.php"><i class='bx bxs-archive icon'></i>Records Archive</a></li>
        </ul>
    </ul>
    
    <!-- JavaScript for Toggling Dropdowns -->
    <script>
        function toggleDropdown(event) {
            const subMenu = event.currentTarget.nextElementSibling;
            const isVisible = subMenu.style.display === 'block';
            subMenu.style.display = isVisible ? 'none' : 'block';
        }
    </script>
</section>

	<!-- NAVBAR -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu toggle-sidebar' ></i>
			<form action="#"></form>
	
			
		
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