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
	





<!-- Begin container for the whole row -->
<div class="container">
    <!-- Begin row -->
    <div class="row">
        <!-- First column: Booked Appointment -->
        <div class="col-md-12"> <!-- Use 6 columns out of 12 for a 50/50 split -->
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
                </div>
            </div>
        </div>

        


</div>



			
		</main>
		<!-- MAIN -->
	</section>


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

	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="js/appoint.js"></script>
</body>
</html>