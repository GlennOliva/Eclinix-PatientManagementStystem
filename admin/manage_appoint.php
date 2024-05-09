<?php
include('../components/header-appoint.php');
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
			<h1 class="title">Manage Appoint</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Manage Appoint</a></li>
			</ul>

            <div id="calendar" style="width: 80%; margin: 0 auto; display:flex; margin-top: 5%;"></div> <!-- Container for the calendar -->
			

                <!-- Modal for Options (Add Appointment or View Bookings) -->
<div class="modal" id="optionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Choose an Action</h5>
      </div>
      <div class="modal-body">
        <p>Would you like to add an appointment or view existing bookings?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addAppointmentButton">Add Appointment</button>
        <button type="button" class="btn btn-secondary" id="viewBookingsButton">View Bookings</button>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="viewBookingsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Bookings for <span id="bookingDate"></span></h5>
      </div>
      <div class="modal-body">
        <div class="container mt-3 table-border">
          <div class="input-group mb-3" style="width: 30%;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Patient">
            <div class="input-group-append" style="padding-left: 10px;">
              <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
            </div>
          </div>
          <table class="table table-hover" id="patientTable">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Patient Full_name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Rows will be dynamically generated here -->
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeAndReload()">Close</button>
      </div>
    </div>
  </div>
</div>



        <!-- Bootstrap Modal -->
        <div
  class="modal fade"
 
id="addAppointmentModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="addAppointmentModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAppointmentModalLabel">Add Appointment</h5>

      </div>
      <div class="modal-body">
  <form id="appointmentForm" method="post">
    <!-- Patient Name -->
    <div class="form-group row">
  <label for="patientName" class="col-sm-3 col-form-label">Patient Name</label>
  <div class="col-sm-9">
    <select
      class="form-control"
      id="patientName"
      name="patient_name"
    >
    <?php
                                // Query to fetch all courses from the table
                                $sql = "SELECT * FROM tbl_patient";

                                // Execute the query
                                $result = mysqli_query($conn, $sql);

                               $count = mysqli_num_rows($result);
                               if($count > 0 )
                               {
                                   while($row = mysqli_fetch_assoc($result))
                                   {   
                                       $patient_id = $row['id'];
                                       $patient_name = $row['full_name'];
                                      
                                       ?>
                   
                   <option value="<?php echo $patient_id; ?>"><?php echo $patient_name;?></option>
                                       
                   
                                       <?php
                                   }
                               }
                               else
                               {
                                   //we don't have faculty member
                                   ?>
                                   <option value="0" >No Patient Found</option>                                    
                   
                                   <?php
                               }
                               ?>
    </select>
  </div>
</div>


    <!-- Appointment Date -->
    <div class="form-group row">
      <label for="appointmentDate" class="col-sm-3 col-form-label">Appointment Date</label>
      <div class="col-sm-9">
        <input
          type="date"
          class="form-control"
          name="date"
          id="appointmentDate"
        />
      </div>
    </div>

    <!-- Appointment Time -->
    <div class="form-group row">
      <label for="appointmentTime" class="col-sm-3 col-form-label">Appointment Time</label>
      <div class="col-sm-9">
        <select class="form-control" id="appointmentTime" name="time">
          <!-- Times from 9:00 am to 2:00 pm in 15-minute intervals -->
          <?php
          for ($hour = 9; $hour <= 13; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {
              $display_hour = ($hour > 12) ? $hour - 12 : $hour;
              $suffix = ($hour >= 12) ? 'PM' : 'AM';
              $time = sprintf('%02d:%02d %s', $display_hour, $minute, $suffix);
              $value_time = sprintf('%02d:%02d', $hour, $minute);
              echo "<option value=\"$value_time\">$time</option>";
            }
          }
          ?>
        </select>
      </div>
    </div>

    <!-- Appointment Reason -->
    <div class="form-group row">
      <label for="appointmentReason" class="col-sm-3 col-form-label">Reason</label>
      <div class="col-sm-9">
        <textarea
          class="form-control"
          id="appointmentReason"
          name="reason"
          placeholder="Enter the reason for the appointment"
        ></textarea>
      </div>
    </div>

    <!-- Modal Footer -->
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="closeAppointment()">Cancel</button>
      <button type="submit" name="add_appoint" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>



<?php
if (isset($_POST['add_appoint'])) {
    $patient_id = $_POST['patient_name']; // This is the patient ID
    $patient_date = $_POST['date'];
    $patient_time = $_POST['time'];
    $patient_reason = $_POST['reason'];

    // Fetch the full name from the patient ID
    $patient_query = "SELECT full_name FROM tbl_patient WHERE id = '$patient_id'";
    $patient_result = mysqli_query($conn, $patient_query);

    if ($patient_result && mysqli_num_rows($patient_result) > 0) {
        $patient_data = mysqli_fetch_assoc($patient_result);
        $patient_full_name = $patient_data['full_name']; // Get the full name

        // Validate the time is within the desired range
        $allowed_times = array(
            '09:00', '09:15', '09:30', '09:45',
            '10:00', '10:15', '10:30', '10:45',
            '11:00', '11:15', '11:30', '11:45',
            '12:00', '12:15', '12:30', '12:45',
            '13:00', '13:15', '13:30', '13:45', '14:00'
        );

        if (!in_array($patient_time, $allowed_times)) {
            echo '<script>
                swal({
                    title: "Invalid Time",
                    text: "Please select a valid time between 9:00 am and 2:00 pm in 15-minute increments.",
                    icon: "error"
                });
            </script>';
        } else {
            // Check for existing appointments at the same date and time
            $check_sql = "SELECT * FROM tbl_appoint WHERE date = '$patient_date' AND time = '$patient_time'";
            $result = mysqli_query($conn, $check_sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<script>
                    swal({
                        title: "Error",
                        text: "The selected time is already booked. Please choose a different time.",
                        icon: "error"
                    });
                </script>';
            } else {
                // Insert new appointment with full name and patient ID
                $insert_sql = "INSERT INTO tbl_appoint (full_name, date, time, reason, patient_id)
                               VALUES ('$patient_full_name', '$patient_date', '$patient_time', '$patient_reason', '$patient_id')";

                if (mysqli_query($conn, $insert_sql)) {
                    echo '<script>
                        swal({
                            title: "Success",
                            text: "Appointment Successfully Booked!",
                            icon: "success"
                        }).then(function() {
                            window.location = "manage_appoint.php";
                        });
                    </script>';
                } else {
                    echo '<script>
                        swal({
                            title: "Error",
                            text: "Failed to book appointment. Please try again later.",
                            icon: "error"
                        });
                    </script>';
                }
            }
        }
    } else {
        echo '<script>
            swal({
                title: "Error",
                text: "Patient not found. Please try again.",
                icon: "error"
            });
        </script>';
    }
}
?>




			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->


    <script>


function closeAppointment()
{
    $('#addAppointmentModal').modal('hide');

}

function closeAndReload() {
    $('#viewBookingsModal').modal('hide');
    window.location.href = 'manage_appoint.php';
}
</script> 





    <script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
            var day = new Date(info.dateStr).getDay();
            if (day === 0) { // Handle Sunday
                alert("Clinic is closed on Sundays.");
                return;
            }

            // Set the appointment date for later use
            document.getElementById('appointmentDate').value = info.dateStr;

            // Show the option modal
            $('#optionModal').modal('show');

            // Set event handlers for the modal buttons
            document.getElementById('addAppointmentButton').addEventListener('click', function() {
                $('#optionModal').modal('hide');
                $('#addAppointmentModal').modal('show');
            });

            document.getElementById('viewBookingsButton').addEventListener('click', function() {
                fetchBookingsForDate(info.dateStr); // Fetch and populate the bookings table
                $('#optionModal').modal('hide');
                $('#viewBookingsModal').modal('show');
            });
        }
    });

    calendar.render();
});

function fetchBookingsForDate(dateStr) {
    fetch('fetch_bookings.php?date=' + encodeURIComponent(dateStr))
        .then(response => response.json())
        .then(data => {
            var tableBody = document.querySelector('#patientTable tbody');
            tableBody.innerHTML = ''; // Clear previous data
            
            data.forEach(booking => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${booking.id}</td>
                    <td>${booking.full_name}</td>
                    <td>${booking.appointment_date}</td>
                    <td>${booking.appointment_time}</td>
                    <td>${booking.reason}</td>
                    <td>${booking.status}</td>
                    <td>
                        <a href="update_appoint.php?id=${booking.id}" class="btn btn-primary btn-sm">Update</a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching bookings:', error);
        });
}


</script>


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

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="js/appoint.js"></script>
</body>
</html>