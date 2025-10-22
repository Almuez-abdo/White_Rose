<?php

ob_start();
session_start();

$pageTitle = "update";

include "init.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(isset($_POST['submitPe'])){

        $pass = $_POST['password'];
        $rePass = $_POST['rePassword'];

        if($pass === $rePass){

            $userPe = $_SESSION['userId'];
            $namePe =  $_SESSION['userName'];
            $shaPassPe = sha1($pass);

            $upPe = $con->prepare("UPDATE user SET Patient_Pass = ? WHERE Patient_ID = ?");
            $upPe->execute(array($shaPassPe, $userPe));

            
            $theMsg= '<div class= "alert alert-success"> مرحبا ' . $namePe . '  تم أرسال رمز التحقق الي البريد الالكتروني المسجل </div>';
            redirectHome($theMsg, 3, 'index.php');
        }
    }elseif(isset($_POST['submitDoc'])){

        $password= $_POST['password'];
        $repassword= $_POST['rePassword'];

        if($password=== $repassword){

            $userDoc = $_SESSION['userId'];
            $nameDoc =  $_SESSION['userName'];
            $shaPassDoc = sha1($password);

            $upDoc = $con->prepare("UPDATE doctor SET Doctor_Pass = ? WHERE Doctor_ID = ?");
            $upDoc->execute(array($shaPassDoc, $userDoc));

            $theMsg= '<div class= "alert alert-success"> مرحبا ' . $nameDoc . '  تم أرسال رمز التحقق الي البريد الالكتروني المسجل </div>';
            redirectHome($theMsg, 3, 'index.php');
        }
    }
}



    include "includes/footer.php";
    
    ob_end_flush();

?>



