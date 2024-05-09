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
//Data for second chart
// This example assumes you're getting data for Patient Age Group
$age_sql = "
SELECT
  CASE
    WHEN age BETWEEN 0 AND 1 THEN 'Infants'
    WHEN age BETWEEN 2 AND 3 THEN 'Toddlers'
    WHEN age BETWEEN 4 AND 7 THEN 'Early Childhood'
    WHEN age BETWEEN 8 AND 11 THEN 'Middle Childhood'
    WHEN age BETWEEN 12 AND 80 THEN 'Adolescence'
    ELSE 'Other'  -- Default case for ages outside these groups
  END AS age_group,
  COUNT(*) AS count
FROM tbl_records
GROUP BY age_group
";


$age_result = mysqli_query($conn, $age_sql);

$age_groups = [];
$counts = [];

if (mysqli_num_rows($age_result) > 0) {
    while ($row = mysqli_fetch_assoc($age_result)) {
        $age_groups[] = $row['age_group'];
        $counts[] = $row['count'];
    }
}

?>




<!-- Patient Age Group Bar Chart -->
<div class="content-data">
    <div class="head">
        <h3>Patient Age Group</h3>
    </div>
    <div class="chart">
        <div id="chart2"></div> <!-- Unique ID for the second chart -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var ageCounts = <?php echo json_encode($counts); ?>;
    var ageGroups = <?php echo json_encode($age_groups); ?>;

    // Ensure ageCounts has data
    if (ageCounts.length === 0) {
        console.error("No data for Patient Age Group.");
        return;
    }

    var options = {
        series: [{
            name: "Patient Count",
            data: ageCounts
        }],
        chart: {
            height: 350,
            type: 'bar', // Bar chart
            zoom: {
                enabled: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false, // Vertical bars
                distributed: true // Use individual colors for each category
            }
        },
        xaxis: {
            categories: ageGroups // Labels for the X-axis
        },
        colors: [
            '#FFBD59', // Infants
            '#F05556', // Toddlers
            '#0097B2', // Early Childhood
            '#FF914D', // Middle Childhood
            '#30ADDB'  // Adolescence
        ],
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " patients"; // Tooltip text
                }
            }
        }
    };

    var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
    chart2.render();
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