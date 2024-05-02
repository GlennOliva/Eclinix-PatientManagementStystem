<?php
include('../components/staff_header-patient.php');
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
    <h1 class="title">Manage Patient</h1>
    <ul class="breadcrumbs">
        <li><a href="#">Staff</a></li>
        <li class="divider">/</li>
        <li><a href="#" class="active">Manage Patient</a></li>
    </ul>

    <div class="container mt-3 table-border">
        <div class="input-group mb-3" style="width: 30%;">
            <input type="text" id="searchInput" class="form-control" placeholder="Search Patient">
            <div class="input-group-append" style="padding-left: 10px;">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
            </div>
        </div>
        <a href="add_patient.php" class="btn btn-success btn-sm" style="margin-bottom: 10px;">Create</a>
        <br>
        <table class="table table-hover" id="patientTable" id="admin_table">
            <thead class="thead-dark">
            <tr>
                    <th>ID</th>
                    <th>Full_Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Dob</th>
                    <th>Address</th>
                    <th>Phone_number</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM tbl_patient";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $count = mysqli_num_rows($result);
                    $ids = 1;
                    if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($result)) {
                            $id = $rows['id'];
                            $full_name = $rows['full_name'];
                            $email = $rows['email'];
                            $Gender = $rows['gender'];
                            $Dob = $rows['dob'];
                            $address = $rows['address'];
                            $phone_number = $rows['phone_number'];
                            $image_name = $rows['image'];
                            $status = $rows['status'];
                            ?>
                            <tr>
                                <td><?php echo $ids++; ?></td>
                                <td><?php echo $full_name; ?></td>
                                <td><?php echo $email; ?></td>
                                <td><?php echo $Gender; ?></td>
                                <td><?php echo $Dob; ?></td>
                                <td><?php echo $address; ?></td>
                                <td><?php echo $phone_number; ?></td>
                                <td><img src="../admin/patient_image/<?php echo $image_name ?>" style="width: 70px;"></td>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <a href="update_patient.php?id=<?php echo $id; ?>" class="btn btn-primary btn-sm">Update</a>
                                    <form action="code.php" method="post">
                                        <button type="button" class="btn-del delete_patientbtn" value="<?= $id; ?>">Delete</button>
                                    </form>
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
<script src="../admin/js/patient.js"></script>
