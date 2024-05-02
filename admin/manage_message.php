<?php
include('../components/header-message.php');
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
			<h1 class="title">Manage Message</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Admin</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Manage Message</a></li>
			</ul>

            
              
            <div class="message-form-container" style="margin-top: 20px;">
                <form method="post" id="sendMessageForm">
                    <div class="form-group">
                        <label for="recipientType">Choose recipient:</label>
                        <select name="recipientType" class="form-control">
                            <option value="patient">Patient</option>
                            <option value="staff">Staff</option>
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="messageSubject">Subject:</label>
                        <select name="messageSubject" class="form-control">
                            <option value="appointment">Appointment</option>
                            <option value="reminder">Reminder</option>
                        </select>
                    </div>
        
                    <div class="form-group">
                        <label for="messageText">Message:</label>
                        <textarea name="messageText" class="form-control" rows="4" placeholder="Type your message here..."></textarea>
                    </div>
        
                    <input type="submit" name="send_message" class="btn btn-primary">
                </form>
            </div>
            
            

           <?php
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
    if (isset($_POST['send_message'])) {
        $recipientType = $_POST['recipientType'];
        $messageSubject = $_POST['messageSubject'];
        $messageText = $_POST['messageText'];

        // Initialize SQL query variable
        $sql = "";

        // Determine recipient type and prepare the corresponding SQL query
        if ($recipientType == 'patient') {
            // SQL query for patient messages
            $sql = "INSERT INTO tbl_patientmessage (recipient, subject, message, created_at, admin_id) VALUES ('$recipientType', '$messageSubject', '$messageText', NOW(), $admin_id)";
        } elseif ($recipientType == 'staff') {
            // SQL query for staff messages
            $sql = "INSERT INTO tbl_staffmessage (recipient, subject, message, created_at, admin_id) VALUES ('$recipientType', '$messageSubject', '$messageText', NOW(), $admin_id)";
        }

        // Execute the query if it's set
        if ($sql !== "") {
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>
                    swal({
                        title: "Success",
                        text: "Message sent Successfully",
                        icon: "success"
                    }).then(function() {
                        window.location = "manage_message.php";
                    });
                </script>';
            } else {
                echo '<script>
                    swal({
                        title: "Error",
                        text: "Message Failed to Send",
                        icon: "error"
                    }).then(function() {
                        window.location = "manage_message.php";
                    });
                </script>';
            }
            exit;
        }
    }
}
?>

			
		</main>

        <style>
            .message-form-container {
    width: 100%;
    margin: auto;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    border-radius: 8px;
}

.form-group {
    margin-bottom: 15px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

textarea {
    resize: none; /* Disables resizing the textarea */
}

        </style>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
</body>
</html>