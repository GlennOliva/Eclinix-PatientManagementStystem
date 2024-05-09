<?php
include('../config/dbcon.php');
session_start();

if(isset($_POST['delete_adminbtn']))
{

    $id = $_POST['admin_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_admin WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_admin WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("admin_image/".$image_name2))
        {
            unlink("admin_image/".$image_name2);
        }

        echo 200;

    }
    else
    {
        echo 500;
    }


}

else if(isset($_POST['delete_medicalbtn']))
{

    $id = $_POST['medical_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_archivemedical WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_archivemedical WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("medical_image/".$image_name2))
        {
            unlink("medical_image/".$image_name2);
        }

        echo 300;

    }
    else
    {
        echo 600;
    }


}
else if(isset($_POST['delete_equipmentbtn']))
{

    $id = $_POST['equipment_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_archiveequipment WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_archiveequipment WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("equipment_image/".$image_name2))
        {
            unlink("equipment_image/".$image_name2);
        }

        echo 20;

    }
    else
    {
        echo 2;
    }


}
else if(isset($_POST['delete_patientbtn']))
{

    $id = $_POST['patient_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_archivepatient WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_archivepatient WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("patient_image/".$image_name2))
        {
            unlink("patient_image/".$image_name2);
        }

        echo 1;

    }
    else
    {
        echo 2;
    }


}

else if(isset($_POST['delete_staffbtn']))
{

    $id = $_POST['staff_id'];
    //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_staff WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);


$image_name2 = $count2['image'];

   $sql1 = "DELETE FROM tbl_staff WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
        if(file_exists("staff_image/".$image_name2))
        {
            unlink("staff_image/".$image_name2);
        }

        echo 3;

    }
    else
    {
        echo 4;
    }


}

else if(isset($_POST['delete_patientrecordsbtn']))
{
    $id = $_POST['record_id'];
      //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_archivepatientrecords WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);




   $sql1 = "DELETE FROM tbl_archivepatientrecords WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
    

        echo 5;

    }
    else
    {
        echo 6;
    }
}
else if(isset($_POST['delete_appointbtn']))
{
    $id = $_POST['appoint_id'];
      //Create SQL query to delete admin
$sql = "SELECT * FROM tbl_appoint WHERE id=$id";

// Execute the query
$result = mysqli_query($conn, $sql);

$count2 = mysqli_fetch_array($result);




   $sql1 = "DELETE FROM tbl_appoint WHERE id=$id";
   $result1 = mysqli_query($conn,$sql1);

   if($result1)
   {
    

        echo 10;

    }
    else
    {
        echo 15;
    }
}

?>