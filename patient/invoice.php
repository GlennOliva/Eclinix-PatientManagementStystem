<?php
include('../components/patient_header-prescription.php');
include('../config/dbcon.php');

?>

<?php
if(!isset($_SESSION['patient_id'])) {
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

// Check if 'record_id' is set in the URL
if(!isset($_GET['record_id'])) {
    echo '<script>
        swal({
            title: "Error",
            text: "No record specified!",
            icon: "error"
        }).then(function() {
            window.location = "prescription.php"; // Redirect to some other page
        });
    </script>';
    exit;
}
?>

<!-- MAIN -->
<main>
    <h1 class="title">Prescription</h1>


    <style>
        /* Prescription box styling */
        .prescription-box {
            border: 1px solid black; /* Border for the outer box */
            padding: 20px; /* Padding inside the box */
            width: 80%; /* Width of the box */
            margin: 20px auto; /* Center the box */
            height: 110vh;
        }

        /* Divider styling */
        .divider {
            border-top: 2px solid black; /* 2px solid black divider */
            margin: 10px 0; /* Space above and below the divider */
        }

        /* Row styling */
        .row {
            display: flex; /* Flex layout for rows */
            justify-content: space-between; /* Space between columns */
        }

        /* Column styling */
        .column {
            flex: 1; /* Each column takes equal space */
            padding: 10px; /* Padding inside the columns */
        }

        /* Prescription image styling */
        .prescription-image {
            max-width: 100px; /* Maximum width for the Rx image */
        }

        .text-right {
    text-align: right; /* Aligns text to the right */
}
    </style>


<div class="prescription-box">
    <!-- Prescription header content -->
    <h1 style="text-align: center;">Rizalito C. Ocampo, M.D. FPPS</h1>
    <h2 style="text-align: center;">Pediatrician</h2>
    <p style="text-align: center;">
        Ocampo’s Children & Maternity Clinic<br>
        No.1 Rockville Subdv Quirino Highway<br>
        San Bartolome, Novaliches, Quezon City<br>
        Mon - Sat: 9AM - 2PM
    </p>

    <!-- Divider between header and patient information -->
    <div class="divider"></div>

    <!-- Patient information section -->
    <?php
                // Get the record ID from the query parameter
$record_id = intval($_GET['record_id']);

// Query to fetch the specific record based on the record ID
$sql = "SELECT 
            p.full_name, 
            p.address,
            r.id AS record_id,
            r.age,
            r.prescriptions,
            r.illness,
            r.treatment,
            r.laboratory_req,
            p.date AS patient_date
        FROM 
            tbl_records AS r
        JOIN 
            tbl_patient AS p 
        ON 
            r.patient_id = p.id
        WHERE 
            r.id = $record_id";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['record_id'];
                            $full_name = $rows['full_name'];
                            $address = $rows['address'];
                            $age = $rows['age'];
                            $prescriptions = $rows['prescriptions'];
                            $date = $rows['patient_date'];
                            $date_formatted = date('F d, Y', strtotime($date));
                            ?>
    <div class="row">
    <div class="column">Patient Name: <?php echo $full_name;?></div> <!-- Left aligned -->
    <div class="column" style="display: flex; justify-content: flex-end;">
        <div style="margin-right: 10px;">Age: <?php echo $age;?></div> <!-- Right aligned -->
        <div>Sex: Male</div> <!-- Right aligned -->
    </div>
</div>



<div class="row">
<div class="column">Address: <?php echo $address;?></div> <!-- Patient address -->
    <div class="column" style="display: flex; justify-content: flex-end;">
        <div style="margin-right: 10px;">Date: <?php echo htmlspecialchars($date_formatted); ?></div> <!-- Right aligned -->
       
    </div>
</div>



    <!-- Rx image section -->
    <div style="display: flex; align-items: center;"> <!-- Flexbox for horizontal alignment -->
    <img src="images/rxlogo.png" alt="Rx" class="prescription-image" style="margin-right: 10px;"> <!-- Image with margin-right -->
    <p><?php echo $prescriptions;?></p> <!-- Content beside the image -->
</div>






    <div class="row" style="margin-top: 25%;">
    <div class="column" style="display: flex; justify-content: flex-end;">
        <div style="margin-right: 10px;">Rizalito C. Ocampo, M.D.</div> <!-- Right aligned -->
       
    </div>
</div>

<?php
                        }
                    }
                }
                ?>

<div class="row">
    <div class="column" style="display: flex; justify-content: flex-end;">
    <div style="margin-right: 10px;">Lic. No.: 123456</div> <!-- Right aligned -->
       
    </div>
</div>


</div>

</body>
</html>


</main>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="../script.js"></script>
<script src="js/patient.js"></script>
