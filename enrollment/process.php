
<?php
include 'conn.php';

// insert/create
if (isset($_POST['addData'])) {
    $Id = $_POST['user_id'];
    $Lname =  $_POST['lastname'];
    $Fname =  $_POST['firstname'];
    $Mname = $_POST['middlename'];
    $Contact = $_POST['contact'];
    $Address = $_POST['address'];
    $Date = $_POST['date'];
    $Grade = $_POST['grade'];
   


    //     INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
    $insertData = $conn->prepare("INSERT INTO enrollment (user_id, lname, fname, mname,  contact, address, date, grade ) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
    $insertData->execute([
        $Id, 
        $Lname, 
        $Fname, 
        $Mname, 
        $Contact, 
        $Address, 
        $Date, 
        $Grade
    ]);

    $msg = "Data inserted!";
    header("location: index.php?msg=$msg");
}

// update
if (isset($_POST['editData'])) {
    $Id = $_POST['user_id'];
    $Lname =  $_POST['lastname'];
    $Fname =  $_POST['firstname'];
    $Mname = $_POST['middlename'];
    $Contact = $_POST['contact'];
    $Address = $_POST['address'];
    $Date = $_POST['date'];
    $Grade = $_POST['grade'];

    //UPDATE table_name SET column1 = value1, column2 = value2, ... WHERE condition;
    $update = $conn->prepare("UPDATE enrollment SET lname = ?, fname = ?, mname = ?,  contact = ?, address = ?,  date = ?, grade= ? WHERE id = ?");
    $update->execute([
    $Lname, 
    $Fname, 
    $Mname, 
    $Contact, 
    $Address, 
    $Date, 
    $Grade,
    $Id
    ]);

    $msg = "Data updated!";
    header("location: index.php?msg=$msg");
}


    // delete
if(isset($_GET['delete'])){
    $id = $_GET['id'];

    // DELETE FROM table_name WHERE condition;
    $delete = $conn->prepare("DELETE FROM enrollment WHERE id = ?");
    $delete->execute([$id]);

    $msg = "Data Deleted!";
    header("location: index.php?msg=$msg");

}


//Register
    if(isset($_POST['register'])){
        $fname = $_POST['f_name'];
        $lname = $_POST['l_name'];
        $email = $_POST['email'];
        $pass1 = $_POST['password1'];
        $pass2 = $_POST['password2'];
    
        if($pass1 == $pass2){
            $hash = password_hash($pass1, PASSWORD_DEFAULT);
            //INSERT INTO table_name (column1, column2, column3, ...) VALUES (value1, value2, value3, ...);
            $addUser = $conn->prepare("INSERT INTO users (u_fname, u_lname, u_email, u_pass) VALUES(?, ?, ?, ?)");
            $addUser->execute([
                $fname,
                $lname,
                $email,
                $hash
            ]);
    
            $msg = "User registration successful!";
            header("location: register.php?msg=$msg");
        }else{
            $msg = "Password do not match!";
            header("location: register.php?msg=$msg");
        }
    }

    // logout
if(isset($_GET['logout'])){
    session_start();

    unset($_SESSION['logged_in']);
    unset($_SESSION['u_id']);

    header("location: login.php");
}
   ?> 
