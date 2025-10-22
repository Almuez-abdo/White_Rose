<?php
ob_start();

    session_start();
    $pageTitle = "دخول المرضي";

    if (isset($_SESSION['Name_Patient'])){
        header('location: home.blade.php');
        exit();
    }
    include "init.php";


    if($_SERVER ['REQUEST_METHOD'] == "POST"){

        if($_POST['patientEmail'] === FILTER_SANITIZE_EMAIL){
            $user = filter_var($_POST['patientEmail']);
        }else{
            $user = filter_var($_POST['patientEmail']);
        }
        
        $password = $_POST['password'];        
        $hashpass = sha1($password);

         $stmt = $con-> prepare("SELECT 
                                        *
                                    FROM
                                        user
                                    WHERE
                                        (Patient_Email = ? OR Patient_Phone = ?)
                                    AND
                                        Patient_Pass = ? 
                                    ");
            $stmt-> execute(array($user, $user, $hashpass));
            $stLog = $stmt->fetch();
            $count = $stmt-> rowCount();


        $maxAttempts = 100;
        $lockoutTime = 3600;
        if(!isset($_SESSION['attempts'])){
            $_SESSION['attempts'] = 0;
        }
        if(isset($_SESSION['lockout']) && time() < $_SESSION['lockout']){
            $remaining = $_SESSION['lockout'] - time();
            $minutes = floor($remaining / 60);
            $seconds = $remaining % 60 ;        
        }else if($_SESSION['attempts'] < $maxAttempts & $count > 0){
            if($stLog['Patient_State'] != 0){
                $_SESSION['Name_Patient']= $stLog['Patient_Name'];
                $_SESSION['Id'] = $stLog['ID'];
                header('location: home.blade.php');
                exit();

                $_SESSION['attempts'] = 0;
             }else{
                $theMsg= '<div class= "alert alert-danger"> لم يتم تفعيل حسابك بعد الرجاء الانتظار والمحاولة لاحقا </div>';
                redirectHome($theMsg, 3, 'index.php');
            }
        }else{
            $_SESSION['attempts']++;
            if($_SESSION['attempts'] >= $maxAttempts){
                $_SESSION['lockout'] = time() + $lockoutTime;
                $theMsg= '<div class= "alert alert-danger"> لقد تجاوزت العدد المحدد لتسجيل الدخول يجب المحاولة بعد ساعة </div>';

                echo $theMsg;
            }else{
                $remaining = $maxAttempts - $_SESSION['attempts'];
                $theMsg= '<div class= "alert alert-danger"> اسم المستخدم او كلمة المرور خاطئة تبقت لك ' . $remaining . 'محاولة" </div>';

                echo $theMsg;     
            }
    }
}
?>


<div style="font-size: 25px;">
    <div class="patient_h">
        <h2> تسجيل دخول المرضى</h2>
    </div>

    <div class="row" style="margin: 20px 0px;">
        <form class="form-login" method="POST" action= "<?php echo $_SERVER['PHP_SELF'] ?>">
            <fieldset>
                <legend>
                سجل الدخول الى حسابك
                </legend>
                <p>
                الرجاء إدخال البريد او رقم الهاتف وكلمة المرور لتسجيل الدخول..<br />
                </p>
                <div class="form-group mb-2">
                    <span class="input-icon">
                        <input type="text" class="form-control" name="patientEmail" placeholder=" رقم الهاتف اوالبريد الالكتروني ">
                        <i class="fa fa-user"></i> </span>
                </div>
                <div class="form-group form-actions mb-2">
                    <span class="input-icon">
                        <input type="password" class="form-control password" name="password" placeholder="كلمة المرور">
                        <i class="fa fa-lock"></i>
                    </span>
                </div>
                <div class="form-actions">
                    
                    <button type="submit" class="btn btn-primary pull-right" name="submit">
                    دخول <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </fieldset>
        </form>
        <form method="POST" action="forgot-password.php">
            <input type="submit" value="نسيت كلمة المرور ؟" name="forgotPat" class="btnNew">
        </form>
        <form action="registration.php" method="POST">
            <input type="submit" name="newPat" value="ليس لدي حساب" class="btnNew">
        </form>
    </div>
</div>


<?php
    include "includes/footer.php";

    ob_end_flush();
?>
