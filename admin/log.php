<?php

ob_start();

    session_start();
    $pageTitle = "دخول مدير النظام";

    if (isset($_SESSION['Name_Admin'])){
        header('location: homePage.php');
        exit();
    }
    include "init.php";


    if($_SERVER ['REQUEST_METHOD'] == "POST"){

        $admin = filter_var($_POST['adminEmail'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $hashpass = sha1($password);

            $stAdmin = $con-> prepare("SELECT 
                                        *
                                    FROM
                                        boss
                                    WHERE
                                       Boss_Email = ? 
                                    AND
                                       Boss_Pass = ? 
                                    ");
            $stAdmin-> execute(array($admin, $hashpass));
            $logAdmin = $stAdmin->fetch();
            $count = $stAdmin-> rowCount();


        $maxAttempts = 3;
        $lockoutTime = 3600;
        if(!isset($_SESSION['attemptAdmin'])){
            $_SESSION['attemptAdmin'] = 0;
        }
        if(isset($_SESSION['lockoutAdmin']) && time() < $_SESSION['lockoutAdmin']){
            $remaining = $_SESSION['lockoutAdmin'] - time();
            $minutes = floor($remaining / 60);
            $seconds = $remaining % 60 ; 
            
        }else if($_SESSION['attemptAdmin'] < $maxAttempts & $count > 0){
                    $_SESSION['Name_Boss']= $logAdmin['Boss_Name'];
                    $_SESSION['Id'] = $logAdmin['Boss_ID'];
                    header('location: homePage.php');
                    exit();

                    $_SESSION['attemptAdmin'] = 0;
        }else{
            $_SESSION['attemptAdmin']++;
            if($_SESSION['attemptAdmin'] >= $maxAttempts){
                $_SESSION['lockoutAdmin'] = time() + $lockoutTime;
                $theMsg= '<div class= "alert alert-danger"> لقد تجاوزت العدد المحدد لتسجيل الدخول يجب المحاولة بعد ساعة </div>';

                echo $theMsg;
            }else{
                $remaining = $maxAttempts - $_SESSION['attemptAdmin'];
                $theMsg= '<div class= "alert alert-danger"> اسم المستخدم او كلمة المرور خاطئة تبقت لك ' . $remaining . 'محاولة" </div>';

                echo $theMsg;
            }
    }
}
?>


<div style="font-size: 25px;">
    <div class="patient_h">
        <h2> تسجيل دخول مدير النظام</h2>
    </div>

    <div class="row" style="margin: 20px 0px;">
        <form class="form-login" method="POST" action= "<?php echo $_SERVER['PHP_SELF'] ?>">
            <fieldset>
                <legend>
                سجل الدخول الى حسابك
                </legend>
                <p>
                الرجاء إدخال البريد الالكتروني وكلمة المرور لتسجيل الدخول..<br />
                </p>
                <div class="form-group mb-2">
                    <span class="input-icon">
                        <input type="mail" class="form-control" name="adminEmail" placeholder=" البريد الالكتروني ">
                        <i class="fa fa-user"></i> </span>
                </div>
                <div class="form-group form-actions mb-2">
                    <span class="input-icon">
                        <input type="password" class="form-control password" name="password" placeholder="كلمة المرور">
                        <i class="fa fa-lock"></i>
                            </span><a href="forgot-password.php">
                        نسيت كلمة المرور ؟
                    </a>
                </div>
                <div class="form-actions">
                    
                    <button type="submit" class="btn btn-primary pull-right" name="submit">
                    دخول <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </fieldset>
        </form>
    </div>
</div>


<?php
    include "includes/footer.php";

    ob_end_flush();
?>
