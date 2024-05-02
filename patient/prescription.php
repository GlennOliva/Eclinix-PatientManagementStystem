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
?>

<!-- MAIN -->
<main>
    <h1 class="title">Prescription</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Patient</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Prescription</a></li>
    </ul>

    <div class="container mt-3 table-border">
    
     
      
        <table class="table table-hover" id="patientTable" id="admin_table">
            <thead  >
                <tr>
                    <th style="background-color: #FFAA2B !important;">Title</th>
                    <th style="background-color: #FFAA2B !important;">Date</th>
                    <th style="background-color: #FFAA2B !important;">Diagnosis</th>
                    <th style="background-color: #FFAA2B !important;">Actions</th>
     
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id , p.date , r.illness , r.prescriptions
                FROM tbl_patient as p JOIN tbl_records as r ON p.id = r.patient_id WHERE p.id = $patient_id";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $prescriptions = $rows['prescriptions'];
                            $date = $rows['date'];
                            $medical_condtion = $rows['illness'];
                            ?>
                            <tr>
                                <td><?php echo $prescriptions; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $medical_condtion; ?></td>
                                <td>
                                <a href="invoice.php?<?php echo $id; ?>" >
  <i class="bx bx-show"></i>
</a>

                            </td>
                               
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- JavaScript to filter the table -->
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
<script src="js/patient.js"></script>
