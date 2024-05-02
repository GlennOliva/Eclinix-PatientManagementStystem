<?php
include('../components/staff_header-appoint.php');
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
			<h1 class="title">Update Appointment</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Staff</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Update Appoint</a></li>
			</ul>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <form style="border: 2px solid #00204a; padding: 20px; border-radius: 12px;">
                            <div class="mb-3">
                                <label for="organizationTitle" class="form-label">Appointment Status</label>
                                <select class="form-control" name="appointment_type">
                                    <option value="">Select Status</option>
                                    <option value="Approve">Approve</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Revision">Pending</option>
                                </select>
                            </div>
                            
                            
                            <input type="submit" name="update_appoint" class="btn btn-primary" value="Update Appoint Status">
                        </form>
                    </div>
                </div>
            </div>

			
		</main>


        <style>
            .table-border {
                border: 2px solid #dee2e6; /* Bootstrap's default border color */
                padding: 10px;
                border-radius: 5px; /* Optional: rounds the corners of the border */
            }
        </style>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>