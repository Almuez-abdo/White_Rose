<?php
ob_start();

    session_start();
    $pageTitle = "استرجاع كلمة المرور";

    include "init.php";


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if((!isset($_POST['forgotPat'])) && (!isset($_POST['forgotDoc']))){
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if(isset($_POST['submitPat'])){
                $gaEmail = $con->prepare("SELECT * FROM user WHERE Patient_Email = ?");
                $gaEmail->execute(array($email));
                $all = $gaEmail->fetch();
                $count = $gaEmail->rowCount();

            }elseif(isset($_POST['submitDoc'])){
                $gaEmail = $con->prepare("SELECT * FROM doctor WHERE Doctor_Email = ?");
                $gaEmail->execute(array($email));
                $all = $gaEmail->fetch();
                $count = $gaEmail->rowCount();
            }

            if($count > 0){
                if(isset($all['Patient_Name'])){
                    $_SESSION['userName'] = $all['Patient_Name'];
                    $_SESSION['userId'] = $all['Patient_ID'];
                }else{
                    $_SESSION['userName'] = $all['Doctor_Name'];
                    $_SESSION['userId'] = $all['Doctor_ID'];
                }


?>
            <div class="row forgot">
                <div class="col-md-5">
                    <form action="update.php" method="POST">
                        <fieldset>
                            <legend>
                                أعادة تعيين كلمة المرور
                            </legend>
                            <div class="form-group form-actions mb-2">
                                <span class="input-icon">
                                    <input type="password" class="form-control password" name="password" placeholder="كلمة المرور" required />
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <div class="form-group form-actions mb-2">
                                <span class="input-icon">
                                    <input type="password" class="form-control password" name="rePassword" placeholder="تكرار كلمة المرور" required />
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <div class="form-actions">
                                <?php
                                if($_SESSION['userName'] = isset($all['Patient_Name'])){
                                echo '<input type="submit" class="btn btn-primary pull-right" name="submitPe" value="أرسال">
                                    <i class="fa fa-arrow-circle-right"></i>
                                    </input>';
                                }elseif($_SESSION['userName'] = isset($all['Doctor_Name'])){
                                    echo '<input type="submit" class="btn btn-primary pull-right" name="submitDoc" value="أرسال">
                                    <i class="fa fa-arrow-circle-right"></i>
                                    </input>';
                                }
                                ?>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="col-md-5">
                    <p>
                        لا تخبر احد بكلمات المرور خاصتك </br>
                        يجب ان تكون الكلمتان متطابقتان تماما </br>
                    </p>
                </div>
            </div>
<?php
        
        }else{
            
            $theMsg= '<div class= "alert alert-danger"> البريد الالكتروني خطا يرجي التاكد من البريد الصحيح </div>';
            redirectHome($theMsg, 3, 'index.php');
        }
   
    }else{
?>

    <div class="row forgot">
        <div class="col-md-5">
            <form class="form-login" method="POST" action= "<?php echo $_SERVER['PHP_SELF'] ?>">
                <fieldset>
                    <legend>
                    استرجاع كلمة المرور
                    </legend>
                    <p>
                    الرجاء إدخال البريد ..<br />
                    </p>
                    <div class="form-group mb-2">
                        <span class="input-icon">
                            <input type="text" class="form-control" name="email" placeholder=" البريد الالكتروني" required/>
                            <i class="fa fa-user"></i> </span>
                    </div>
                    <div class="form-actions">
                        <?php
                        if(isset($_POST['forgotPat'])){
                            echo '<button type="submit" class="btn btn-primary pull-right" name="submitPat">
                            تحقق <i class="fa fa-arrow-circle-right"></i>
                            </button>';
                        }elseif(isset($_POST['forgotDoc'])){
                            echo '<button type="submit" class="btn btn-primary pull-right" name="submitDoc">
                            تحقق <i class="fa fa-arrow-circle-right"></i>
                            </button>';
                        }
                        ?>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-6">
            <p>
                سوف يتم أرسال رسالة تاكيد في البريد الالكتروني المسجل <br>
                أذا لم تكن لديك حساب بالفعل اضغط هنا <br>
                <a href="registration.php">أنشاء حساب جديد</a>
            </p>
        </div>
    </div>


<?php
    }
}
    include "includes/footer.php";

    ob_end_flush();
?>