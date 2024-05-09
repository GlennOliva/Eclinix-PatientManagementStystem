<?php
session_start();

// Ensure no output before header redirects
ob_start(); // Start output buffering to prevent headers already sent error

// If the session does not contain a logged-in patient, redirect to login
if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit;
}

// If the user has already accepted the terms, redirect to manage_appoint.php
if (isset($_SESSION['accepted_terms']) && $_SESSION['accepted_terms'] === true) {
    header("Location: manage_calendar.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Terms and Conditions</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<style>
    /* CSS for the terms and conditions box */
.terms-box {
    background-color: #ECECEC; /* Light gray background color */
    padding: 20px;
    border-radius: 10px;
    width: 60%;
    margin: 50px auto; /* Center the box */
    text-align: center;
}

/* Styling the header with the logo and title */
.header {
    margin-bottom: 20px;
}

.logo {
    width: 80px; /* Adjust logo size as needed */
    height: auto;
}

h1 {
    font-size: 24px; /* Heading size */
}

/* Styling the content of the terms and conditions */
.content {
    font-size: 16px; /* Content font size */
    text-align: left; /* Align text to the left */
}

/* Styling the buttons */
.buttons {
    margin-top: 20px;
}

button {
    padding: 10px 20px; /* Button padding */
    border: none; /* No border */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Change cursor on hover */
}

/* Accept button styles */
button.accept {
    background-color: #FAFAFA; /* Green background for accept */
    color: black; /* White text */
}

button.accept:hover {
    background-color: #0097B2; /* Hover effect for accept */
}

/* Decline button styles */
button.decline {
    background-color: #FAFAFA; /* Red background for decline */
    color: black; /* White text */
}

button.decline:hover {
    background-color: #0097B2; /* Hover effect for decline */
}

</style>

    <!-- Terms and Conditions Box -->
    <div class="terms-box">
        <!-- Logo and Title -->
        <div class="header">
            <img src="../images/eclinix.png" alt="Ocampo's Clinic Logo" class="logo"> <!-- Place your logo file path here -->
            <h1>Ocampos Children and Maternity Clinic Terms and Conditions</h1>
        </div>

        <!-- Terms and Conditions Content -->
        <div class="content">
    <p>
        Welcome to Ocampo's Children and Maternity Clinic. These terms and conditions ("Terms") govern your use of our services. Please read them carefully.
    </p>

    <h2>1. Services</h2>
    <p>
        Ocampo's Children and Maternity Clinic provides healthcare services specializing in pediatrics and maternity care. Our services include medical consultations, diagnostic tests, immunizations, and other related treatments. By accessing our services, you agree to these Terms.
    </p>

    <h2>2. Privacy and Confidentiality</h2>
    <p>
        We are committed to maintaining the privacy of our patients. All patient information, including medical records and personal details, is kept confidential and is used solely for the purpose of providing healthcare services. We comply with applicable privacy laws and regulations.
    </p>

    <h2>3. Patient Responsibilities</h2>
    <p>
        As a patient or guardian, you are responsible for providing accurate and complete information about your medical history, current medications, allergies, and other relevant information. You must follow the medical advice given by our healthcare professionals and attend scheduled appointments.
    </p>


    <h2>4. Changes to Terms and Conditions</h2>
    <p>
        We reserve the right to update these Terms at any time. Changes will be effective upon posting to our website or clinic. By continuing to use our services, you agree to the updated Terms.
    </p>

    <h2>5. Contact Information</h2>
    <p>
        If you have questions about these Terms, please contact us at:
        <br>
        Ocampo's Children and Maternity Clinic
        <br>
        Address: No.1 Rockville Subdv Quirino Highway San Bartolome, Novaliches, Quezon City

        <br>
        Email: eclinixpediatric@gmail.com
    </p>
</div>

        <!-- Action Buttons -->
        <div class="buttons">
        <form method="post">
                <button type="submit" name="accept" class="btn accept">Accept</button>
                <button type="submit" name="decline" class="btn decline">Decline</button>
            </form>
        </div>
    </div>

</body>
</html>


<?php
if (isset($_POST['accept'])) {
    // Set session variable indicating that terms were accepted
    $_SESSION['accepted_terms'] = true;
    // Redirect to manage_appoint.php
    header("Location: manage_calendar.php");
    exit;
}

if (isset($_POST['decline'])) {
    // If the user declines, redirect them to the login page
    unset($_SESSION['patient_id']); // Clear the session if needed
    header("Location: ../login.php");
    exit;
}
?>