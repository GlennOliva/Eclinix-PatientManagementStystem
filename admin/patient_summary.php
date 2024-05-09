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



			<div class="data">
			<?php

// SQL query to count patients grouped by month and year
$sql = "
    SELECT DATE_FORMAT(date, '%Y-%m') AS creation_month, COUNT(*) AS patient_count
    FROM tbl_patient
    GROUP BY creation_month
    ORDER BY creation_month
";

$result = mysqli_query($conn, $sql);

$months = [];
$patient_counts = [];

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Get the raw date in "YYYY-MM" format
        $raw_date = $row['creation_month'];

        // Convert the date to a readable month format like "January 2024"
        $date_obj = DateTime::createFromFormat('Y-m', $raw_date);
        $formatted_month = $date_obj->format('F Y'); // "F" gives the full month name, "Y" is the year

        $months[] = $formatted_month;
        $patient_counts[] = $row['patient_count'];
    }
}
?>





<!-- Patient Summary Area Chart -->
<div class="content-data">
    <div class="head">
        <h3>Patient Summary</h3>
    </div>
    <div class="chart">
        <div id="chart1"></div> <!-- Unique ID for the first chart -->
    </div>
</div>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
document.addEventListener('DOMContentLoaded', function() { // Ensures DOM is fully loaded
    var patientCounts = <?php echo json_encode($patient_counts); ?>;
    var months = <?php echo json_encode($months); ?>;

    // Ensure patientCounts has data
    if (patientCounts.length === 0) {
        console.error("No data for Patient Summary.");
        return;
    }

    var options = {
        series: [
            {
                name: 'Patient Count',
                data: patientCounts
            }
        ],
        chart: {
            height: 350,
            type: 'area', // Area chart
            stacked: false,
            zoom: {
                enabled: true
            }
        },
        xaxis: {
            type: 'category', // Since we're using month names
            categories: months, // The formatted month names
            title: {
                text: 'Month'
            }
        },
        yaxis: {
            title: {
                text: 'Number of Patients' // Label for the y-axis
            }
        },
        stroke: {
            curve: 'smooth' // For smoother lines in the area chart
        },
        tooltip: {
            x: {
                format: 'MMMM yyyy' // Display full month and year in tooltip
            }
        },
        dataLabels: {
            enabled: false // Hides data labels for a cleaner look
        }
    };

    var chart1 = new ApexCharts(document.querySelector("#chart1"), options);
    chart1.render();
});
</script>


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