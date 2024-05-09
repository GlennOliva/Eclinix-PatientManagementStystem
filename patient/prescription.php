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
                    <th style="background-color: #FFAA2B !important;">Id</th>
                    <th style="background-color: #FFAA2B !important;">Date</th>
                    <th style="background-color: #FFAA2B !important;">Diagnosis</th>
                    <th style="background-color: #FFAA2B !important;">Actions</th>
     
                   
                </tr>
            </thead>
            <tbody>
                <?php
          $sql = "SELECT 
          r.id as record_id,  -- Using an alias for clarity
          r.patient_id,
          r.medical_id,
          r.treatment,
          r.prescriptions,
          r.illness,
          r.laboratory_req,
          r.age,
          p.date  -- Assuming date comes from tbl_patient or elsewhere
      FROM 
          tbl_records as r
      JOIN 
          tbl_patient as p 
      ON 
          r.patient_id = p.id 
      WHERE 
          r.patient_id = $patient_id";  // Ensure the correct patient_id is used

$result = mysqli_query($conn, $sql);

if ($result) {
  $count = mysqli_num_rows($result);
  if ($count > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          // Extract the record ID and other details from the query result
          $record_id = $row['record_id'];  // ID of the record from tbl_records
          $treatment = $row['treatment'];
          $prescriptions = $row['prescriptions'];
          $illness = $row['illness'];
          $laboratory_req = $row['laboratory_req'];
          $age = $row['age'];
          $date = $row['date'];

          // Output the data into a table row, ensuring data is sanitized
          ?>
          <tr>
              <td><?php echo htmlspecialchars($record_id); ?></td>
              <td><?php echo htmlspecialchars($date); ?></td>
              <td><?php echo htmlspecialchars($prescriptions); ?></td>
           
              <td>
                  <!-- Pass the record ID as a query parameter to the invoice.php page -->
                  <a href="invoice.php?record_id=<?php echo $record_id; ?>">
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
