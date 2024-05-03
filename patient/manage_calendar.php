<?php
include('../components/patient_header-calendar.php');
include('../config/dbcon.php');

?>

<?php
if(!isset($_SESSION['patient_id']))


{
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


?>

<style>
  /* Toolbar Button Colors */
  .fc-toolbar .fc-button {
    background-color: #0097B2;
    color: white;
  }

  .fc-toolbar .fc-button:hover {
    background-color: #007c93;
  }



  .fc-event {
    background-color: #FFAA2B;
    border-color: #FFAA2B;
  }

  .fc-event .fc-event-title {
    color: black;
  }

    /* Change the background color of the day headers (Sun to Sat) */
    .fc-col-header-cell {
    background-color: #FFAA2B; /* Desired background color */
    color: black !important;
  }

  /* Optional: Change the text color of the day names */
  .fc-col-header-cell.fc-day-header {
    color: black !important;
  }

  .fc-day-sun {
    background-color: lightgray; /* Visually indicate Sundays are disabled */
  }

</style>


		<!-- MAIN -->
		<main>
			<h1 class="title">Appointment Calendar</h1>
			<ul class="breadcrumbs">
				<li><a href="#">patient</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Appointment Calendar</a></li>
			</ul>

            <div id="calendar" style="width: 80%; margin: 0 auto; display:flex; margin-top: 5%;"></div> <!-- Container for the calendar -->
			
		</main>
		<!-- MAIN -->

    

    <?php
    if(isset($_SESSION['patient_id']))
    {
      $patient_id = $_SESSION['patient_id'];

      $sql = "SELECT * FROM tbl_patient WHERE id = $patient_id";

    $res = mysqli_query($conn, $sql);


//check if the query is executed or not!
if($res == True)
{
    //check if the query is executed or not!
if ($res == True) {
  // Check if the data is available or not
  $count = mysqli_num_rows($res); // Should use $res, not $result

  if ($count > 0) {
      // Get the data
      $rows = mysqli_fetch_assoc($res);

      // These lines set the variable you want
      $id = $rows['id'];
      $full_name = $rows['full_name']; 
  } else {
      // Redirect if no data found
      header('Location: manage_profile.php');
      exit();
  }
} else {
  // Handle query failure
  echo 'Error executing query';
}
}
    }
    

    ?>


        <!-- Bootstrap Modal -->
<div
  class="modal fade"
  id="appointmentModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="appointmentModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Add Appointment</h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close"
          onclick="closeAppointment()"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="appointmentForm" method="post">
          <div class="form-group">
            <label for="patientName">Patient Name</label>
            <input
              type="text"
              class="form-control"
              id="patientName"
              name="patient_name"
              placeholder="Enter patient name"
              value="<?php echo $full_name;?>"
              readonly
            />
          </div>
          <div class="form-group">
            <label for="appointmentDate">Appointment Date</label>
            <input
              type="date"
              class="form-control"
              name="date"
              id="appointmentDate"
            />
          </div>
          <div class="form-group">
  <label for="appointmentTime">Appointment Time</label>
  <input
    type="time"
    class="form-control"
    id="appointmentTime"
    name="time"
    min="09:00"  
    max="14:00"  
    step="1800" 
  />
</div>



          <div class="form-group">
            <label for="appointmentReason">Reason</label>
            <textarea
              class="form-control"
              id="appointmentReason"
              placeholder="Enter reason for the appointment"
              name="reason"
            ></textarea>
          </div>
          <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="closeAppointment()">Cancel</button>
        <button type="submit" name="add_appoint" class="btn btn-primary">Submit</button>
      </div>
        </form>
      </div>
     
    </div>
  </div>
</div>


<?php
if (isset($_POST['add_appoint'])) {
    $patient_name = $_POST['patient_name'];
    $patient_date = $_POST['date'];
    $patient_time = $_POST['time'];
    $patient_reason = $_POST['reason'];

    // Check for existing appointment at the same date and time
    $check_sql = "SELECT * FROM tbl_appoint WHERE date = '$patient_date' AND time = '$patient_time'";
    $result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($result) > 0) {
        // There's already an appointment at this date and time
        echo '<script>
            swal({
                title: "Error",
                text: "The selected time is already booked. Please choose a different time.",
                icon: "error"
            });
        </script>';
    } else {
        // Insert new appointment data
        $insert_sql = "INSERT INTO tbl_appoint (full_name, date, time, reason , patient_id)
                       VALUES ('$patient_name', '$patient_date', '$patient_time', '$patient_reason', '$patient_id')";

        if (mysqli_query($conn, $insert_sql)) {
            echo '<script>
                swal({
                    title: "Success",
                    text: "Appointment Successfully Booked!",
                    icon: "success"
                }).then(function() {
                    window.location = "manage_calendar.php";
                });
            </script>';
        } else {
            echo '<script>
                swal({
                    title: "Error",
                    text: "Failed to book appointment.",
                    icon: "error"
                });
            </script>';
        }
    }
}
?>




<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
            // Check if the clicked date is Sunday
            var day = new Date(info.dateStr).getDay(); // Get the day of the week (0 = Sunday)
            if (day === 0) {
                // If it's Sunday, show an alert or do nothing
                alert("Clinic is closed on Sundays.");
                return;
            }
            document.getElementById('appointmentDate').value = info.dateStr; // Set the appointment date in the modal

$('#appointmentModal').modal('show'); // Open the moda
            // Normal behavior for other days (e.g., open a modal)
            console.log("Clicked date:", info.dateStr);
            // You can add additional code to handle the non-Sunday date click
        },
     
    });

    calendar.render();
});
</script>


 <script>


function closeAppointment()
{
    $('#appointmentModal').modal('hide');
}
</script> 


<script>
document.getElementById('appointmentTime').addEventListener('change', function () {
    const timeValue = this.value;
    const startTime = '09:00';
    const endTime = '14:00';

    if (timeValue < startTime || timeValue > endTime) {
        alert("Please select a time between 9 am and 2 pm.");
        this.value = ''; // Clear the input to force re-selection
    }
});
</script>


	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>