<?php
include('../components/staff_header-staff.php');
include('../config/dbcon.php');

?>

<?php
if(!isset($_SESSION['staff_id'])) {
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
    <h1 class="title">Patient List</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Admin</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Patient List</a></li>
    </ul>

    <div class="container mt-3 table-border">
        <div class="input-group mb-3" style="width: 30%;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Patient">
            <div class="input-group-append" style="padding-left: 10px;">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
            </div>
        </div>
     
      
        <table class="table table-hover" id="patientTable" id="admin_table">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Full_Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Phone_number</th>
                    <th>Patient Image</th>
                    <th>Medical Contdition</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT p.id , p.full_name , p.email , p.gender , p.phone_number , p.status , p.image , r.illness
                FROM tbl_patient as p JOIN tbl_records as r ON p.id = r.patient_id";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $email = $rows['email'];
                            $gender = $rows['gender'];
                            $phone_number = $rows['phone_number'];
                            $image_name = $rows['image'];
                            $medical_condtion = $rows['illness'];
                            ?>
                            <tr>
                                <td><?php echo $ids++; ?></td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $gender; ?></td>
                                <td><?php echo $phone_number; ?></td>
                                <td><img src="../admin/patient_image/<?php echo $image_name ?>" style="width: 70px;"></td>
                                <td><?php echo $medical_condtion; ?></td>
                               
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
