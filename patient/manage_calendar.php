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
        <form id="appointmentForm">
          <div class="form-group">
            <label for="patientName">Patient Name</label>
            <input
              type="text"
              class="form-control"
              id="patientName"
              name="patient_name"
              placeholder="Enter patient name"
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
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" onclick="closeAppointment()">Cancel</button>
        <button type="button" class="btn btn-primary" onclick="submitAppointment()">Submit</button>
      </div>
    </div>
  </div>
</div>



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
        events: [
            {
                title: 'Doctor Appointment',
                start: '2024-05-03T14:00:00',
                end: '2024-05-03T15:00:00'
            },
            {
                title: 'Dental Checkup',
                start: '2024-05-10T10:00:00',
                end: '2024-05-10T11:00:00'
            },
        ],
    });

    calendar.render();
});
</script>


<script>
function submitAppointment() {
    var patientName = document.getElementById('patientName').value;
    var appointmentDate = document.getElementById('appointmentDate').value;
    var appointmentTime = document.getElementById('appointmentTime').value;
    var appointmentReason = document.getElementById('appointmentReason').value;

    // Do something with the appointment data
    // For example, send it to the backend via AJAX or add it to the FullCalendar events

    console.log('Appointment Details:', {
        patientName,
        appointmentDate,
        appointmentTime,
        appointmentReason,
    });

    // Close the modal after submitting
    $('#appointmentModal').modal('hide');
}

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