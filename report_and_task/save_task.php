<?php
// require ("inc_db.php");;

$connection = mysqli_connect("localhost","root","kuse@fse2018");
$db = mysqli_select_db($connection, 'smartlift');

// $id=$_POST["id"];
// $username=$_POST["username"];
// $fname=$_POST["first_name"];
// $lname=$_POST["last_name"];
// $email=$_POST["email"];
// $phone=$_POST["phone"];
// $bd =$_POST["bd"];
// $role=$_POST["role"];

// echo "id:$id first_name:$fname last_name:$lname email:$email phone:$phone role:$role";
// $sql="UPDATE users set first_name='$fname',last_name='$lname',email='$email',phone='$phone',role='$role' WHERE id=$id";
// $conn->query($sql);
// header( "location: User.php" );

if(isset($_POST['updatedata']))
    {   
        $id=$_POST["id"];
        $username=$_POST["username"];
        $password=$_POST["password"];
        $fname=$_POST["first_name"];
        $lname=$_POST["last_name"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        $bd =$_POST["bd"];
        $role=$_POST["role"];

        $query = "UPDATE users set username='$username', password='$password',first_name='$fname',last_name='$lname',email='$email',phone='$phone',bd='$bd', role='$role' WHERE id=$id ";
        $query_run = mysqli_query($connection, $query);

        if($query_run)
        {
            echo '<script> alert("Data Updated"); </script>';
            header("Location:user_information.php");
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
?>