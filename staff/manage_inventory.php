<?php
include('../components/staff_header-inventory.php');
include('../config/dbcon.php');

?>


<?php
if(!isset($_SESSION['staff_id']))
{
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
			<h1 class="title">Manage Inventory</h1>
			<ul class="breadcrumbs">
				<li><a href="#">Staff</a></li>
				<li class="divider">/</li>
				<li><a href="#" class="active">Manage Inventory</a></li>
			</ul>

            <div class="container mt-3 table-border">
                <table class="table table-hover" id="admin_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Medical Image</th>
                            <th>Medical Name</th>
                            <th>Medical slot</th>
                            <th>Created_at</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        //query to get all data from tbl_admin database
                $sql = "SELECT * FROM tbl_medical";

                //execute the query
                $result = mysqli_query($conn,$sql);

                //check whether if the query is execute or not

                if($result==True)
                {
                    //count the rows to check we have data in database or not
                    $count = mysqli_num_rows($result);

                    $ids=1;

                    //check the num of rows
                    if($count>0)
                    {
                        while($rows=mysqli_fetch_assoc($result))
                        {
                            $id = $rows['id'];
                            $medical_name = $rows['medical_name'];
                            $medical_slot = $rows['medical_slot'];
                            $image_name = $rows['image'];
                            $date = $rows['created_at'];

                            ?>
                        <tr>

                       
                        
                            <td><?php echo $ids++;?></td>
                            <td><img src="../admin/medical_image/<?php echo $image_name?>" style="width: 70px;"></td>
                            <td><?php echo $medical_name;?></td>
                            <td><?php echo $medical_slot;?></td>
                            <td><?php echo $date;?></td>
                            
                        </tr>
                        <!-- More rows can be added here -->

                        <?php

                        }
                    }
                    
                }

                ?>
                        
                    </tbody>
                </table>
            </div>

			
		</main>
		<!-- MAIN -->
	</section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="../script.js"></script>
    <script src="js/medical.js"></script>
</body>
</html>