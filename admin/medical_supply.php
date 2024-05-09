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
        <div class="col-md-12"> <!-- Use 6 columns for the second part -->
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
        text: "Quantity" // X-axis title
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
    <script src="js/appoint.js"></script>
</body>
</html>