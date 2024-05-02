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




<!-- Begin container for the whole row -->
<div class="container">
    <!-- Begin row -->
    <div class="row">
        <!-- First column: Booked Appointment -->
        <div class="col-md-5"> <!-- Use 6 columns out of 12 for a 50/50 split -->
            <div class="content-data">
                <div class="head">
                    <h3>Booked Appointment</h3>
                </div>
                <div class="container mt-3 table-border">
                    <div class="input-group mb-3" style="width: 70%;"> <!-- Adjust width to fill the column -->
                        <input type="text" id="searchInput" class="form-control" placeholder="Search Patient">
                        <div class="input-group-append" style="padding-left: 10px;">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                        </div>
                    </div>
                    <table class="table table-hover" style="width: 30%;">
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

        <?php


// Execute the SQL query
$sql = "
-- Updated SQL query
SELECT medical_name, medical_slot, COUNT(*) as supply_count
FROM tbl_medical
GROUP BY medical_name, medical_slot
ORDER BY medical_name, medical_slot

";

$result = $conn->query($sql);

// Fetch data into an array
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


?>

        <!-- Second column: Medical Supplies -->
        <div class="col-md-7"> <!-- Use 6 columns for the second part -->
            <div class="content-data">
                <div class="head">
                    <h3>Medical Supplies</h3>
                </div>
                <div class="chart">
                    <div id="chart3"></div> <!-- Unique ID for the chart -->
                </div>
            </div>
        </div>
    </div>
    <!-- End row -->

    <script>
document.addEventListener('DOMContentLoaded', function () {
  var supplyData = <?php echo json_encode($data); ?>;

  // Group data by medical_name
  var groupedData = {};

  // Iterate over the supplyData array to group by medical_name
  supplyData.forEach(item => {
    if (!groupedData[item.medical_name]) {
      groupedData[item.medical_name] = [];
    }
    groupedData[item.medical_name].push({
      x: item.medical_slot, // The x-axis represents the slot
      y: item.supply_count // The y-axis represents the supply count
    });
  });

  // Create series for each medical_name
  var series = [];
  for (var key in groupedData) {
    series.push({
      name: key, // Use medical_name as series name
      data: groupedData[key] // Data for the series
    });
  }

  // Create the chart options
  var options = {
    series: series, // Use the series created from groupedData
    chart: {
      height: 350,
      type: "line", // Line chart
      zoom: {
        enabled: true
      }
    },
    stroke: {
      curve: "smooth" // Smooth lines
    },
    markers: {
      size: 5, // Size of data point markers
      hover: {
        size: 7
      }
    },
    xaxis: {
      categories: [...new Set(supplyData.map(item => item.medical_slot))], // Unique medical slots
      title: {
        text: "Medical Slot" // X-axis title
      }
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + " items"; // Tooltip text
        }
      }
    }
  };

  var chart3 = new ApexCharts(document.querySelector("#chart3"), options);
  chart3.render(); // Render the chart
});
</script>





</div>



			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>