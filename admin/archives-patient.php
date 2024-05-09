<?php
include('../config/dbcon.php'); // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($patient_id > 0) {
        // Fetch patient data from tbl_patient
        $query = "SELECT * FROM tbl_patient WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'i', $patient_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $patient = mysqli_fetch_assoc($result);

            // Insert into tbl_archivepatient
            $insert_query = "INSERT INTO tbl_archivepatient 
                            (full_name, patient_id, email, phone_number, image, address, password, status, dob, gender, date) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'sisssssiss', 
                                  $patient['full_name'], 
                                  $patient_id,  // This is the ID passed from tbl_patient
                                  $patient['email'], 
                                  $patient['phone_number'], 
                                  $patient['image'], 
                                  $patient['address'], 
                                  $patient['password'], 
                                  $patient['status'], 
                                  $patient['dob'], 
                                  $patient['gender']);
            $inserted = mysqli_stmt_execute($stmt);

            if ($inserted) {
                // Delete from tbl_patient after successful insertion into tbl_archivepatient
                $delete_query = "DELETE FROM tbl_patient WHERE id = ?";
                $stmt = mysqli_prepare($conn, $delete_query);
                mysqli_stmt_bind_param($stmt, 'i', $patient_id);
                $deleted = mysqli_stmt_execute($stmt);

                if ($deleted) {
                    // Return success response
                    echo json_encode(['success' => true]);
                    exit;
                }
            }
        }
    }

    // If something goes wrong, return an error response
    echo json_encode(['success' => false]);
}
?>
