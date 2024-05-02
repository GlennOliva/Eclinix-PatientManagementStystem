<?php

include('../config/dbcon.php');
session_start();

if (!isset($_SESSION['patient_id'])) {
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

if (isset($_SESSION['patient_id'])) {
    $patient_id = $_SESSION['patient_id'];
    $sql = "SELECT * FROM tbl_patient WHERE id = $patient_id";

    // Assuming you are using mysqli for database operations
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
		$id = $row['id'];
        $patient_name = $row['full_name'];
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
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link
  href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
  rel="stylesheet"
/>

<script
  src="https://cdn.jsdelivr.net/npm/flatpickr"
></script>


	<link rel="stylesheet" href="../style.css">
	<!-- FullCalendar CSS -->
<link
  href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css"
  rel="stylesheet"
/>

<!-- FullCalendar JavaScript -->
<script
  src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"
></script>

<!-- Optional: jQuery, if needed by FullCalendar -->
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
></script>



	<title>patient</title>



</head>
<body>


	
	
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand" style="padding-top: 5%;">
        <img src="../image/eclinicx-logo.png" style="width: 95%; height: auto; padding-top: 25%;" alt="Logo"> 
		  </a>
		  
		<ul class="side-menu" style="padding-top: 3%;">
		<li style="padding-top: 3%;"><a href="manage_calendar.php" class="active"><i class='bx bxs-calendar icon' ></i>Appointment Calendar</a></li>
			<li><a href="manage_appoint.php" ><i class='bx bxs-calendar-week icon' ></i>Appointment</a></li>
			
			<li><a href="manage_medicalrecord.php" class=""><i class='bx bxs-file icon'></i> Medical Record</a></li>
			<li><a href="prescription.php" class=""><i class='bx bxs-capsule icon' ></i> Prescriptions</a></li>
			<ul/>
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
			<img src="../admin/patient_image/<?php echo $image;?>" alt="">
				<ul class="profile-link">
					<li><p style="padding-left: 10%; padding-top: 3%;">Hi there! <b><?php echo $patient_name;?></b></p></li>
					<li><a href="manage_profile.php?id=<?php echo $id;?>"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
					<li><a href="patient_logout.php"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
				</ul>
			</div>
		</nav>
		<!-- NAVBAR -->