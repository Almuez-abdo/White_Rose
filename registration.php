<?php
ob_start();

    session_start();
    $pageTitle = "تسجيل جديد";

    if(isset($_SESSION['Name_Petient'])){
        header('location: home.blade.php');
        exit();
    }
    include "init.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if((!isset($_POST['newPat']) AND (!isset($_POST['newDoc'])))){
            $name = strip_tags($_POST['userN']);
            $pass = $_POST['pass'];
            $rePass = $_POST['rePass'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
            $phone = $_POST['phone'];
        

            

            // Validate The Form
            $formError = array();

            if(strlen($name) < 11 ){
                $formError[]= ' الاسم يجب ان لا يقل عن  <strong> 11 حرف </strong>';
            }
            if(!(preg_match("/^[\p{L}\s]+$/u", $name))){
                $formError[]= ' الاسم الشخصي يجب ان يحتوي علي احرف فقط';
            }
            if($age < 18){
                $formError[]= 'يجب ان يكون عمرك اكبر من <strong> 18 سنه </strong>';
            }
            if(preg_match('/^249[0-9]{9}$/', $phone)){
            }else{
            $formError[]= 'رقم الهاتف غير صحيح';
            }
            if($pass === $rePass){
                $hashPass = sha1($pass);
            }else{
                $formError[]= 'كلمه المرور غير متطابقة';
            }

        
            if(! empty($formError)){
                foreach($formError as $error){
                    echo '<div class= "alert alert-danger">' . $error . '</div>';
                }
            }else{
                
                if(isset($_POST['subDoctor'])){
                    $stDoc = $con-> prepare("INSERT INTO 
                                                    doctor(Doctor_Name, Doctor_Pass, Doctor_Email, Doctor_Age, Doctor_Phone, Doctor_State)
                                            VALUES(:zname, :zpass, :zmail, :zage, :zphone, 0);
                                                ");
                        $stDoc->execute(array(
                            'zname'     => $name,
                            'zpass'     => $hashPass,
                            'zmail'     => $email,
                            'zage'      => $age,
                            'zphone'    => $phone
                        ));

                    
                    $theMsg= '<div class= "alert alert-success"> تم تسجيل حسابك بنجاح سيتم تفعيل حسابك خلال 24 ساعة </div>';
                    redirectHome($theMsg, 4, 'index.php');

                }elseif(isset($_POST['subPatient'])){
                    $stPat = $con-> prepare("INSERT INTO 
                                                    user(Patient_Name, Patient_Pass, Patient_Email, Patient_Age, Patient_Phone, Patient_Step, Patient_State)
                                            VALUES(:zname, :zpass, :zmail, :zage, :zphone, 1, 0);
                                                ");
                        $stPat->execute(array(
                            'zname'     => $name,
                            'zpass'     => $hashPass,
                            'zmail'     => $email,
                            'zage'      => $age,
                            'zphone'    => $phone
                        ));

                    
                    $theMsg= '<div class= "alert alert-success"> تم تسجيل حسابك بنجاح سيتم تفعيل حسابك خلال 24 ساعة </div>';
                    redirectHome($theMsg, 4, 'index.php');
                }

            }
        }
    }
    
    ?>

    <div class="container">
        <h3 class="pt-4">تسجيل جديدة</h3>
        <form class= "newConsultation" action= "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
            <div class= "input_cont mb-2">
                <input class="form-control" type="text" name= "userN" placeholder= "الاسم رباعي" autocomplete="on" required/>
                <span class= "asterisk">*</span>
            </div>
            <div class= "input_cont mb-2">
                <input class="form-control" type="password" name= "pass" placeholder= "كلمة المرور" autocomplete="off" required/>
                <span class= "asterisk">*</span>
            </div>
            <div class= "input_cont mb-2">
                <input class="form-control" type="password" name= "rePass" placeholder= "كلمة المرور" autocomplete="off" required/>
                <span class= "asterisk">*</span>
            </div>
            <div class= "input_cont mb-2">
                <input class="form-control" type="mail" name= "email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$" placeholder= "example@email.com" autocomplete="on" required/>
                <span class= "asterisk">*</span>
            </div>
            <div class= "input_cont mb-2">
                <input class="form-control" type="number" name= "age" placeholder= "العمر" autocomplete="off" required/>
                <span class= "asterisk">*</span>
            </div>
            
            <div class= "input_cont mb-2">
                <input class="form-control" type="tel" name= "phone" pattern="^249[19][0-9]{8}$" placeholder= "249" autocomplete="off" required />
                <span class= "asterisk">*</span>
            </div>
        <?php
            if(isset($_POST['newPat'])){
                echo '<input name= "subPatient" type="submit" class="btn btn-primary my-3" value= "إرسال"></input>';

            }elseif(isset($_POST['newDoc'])){
                echo '<input name= "subDoctor" type="submit" class="btn btn-primary my-3" value= "إرسال"></input>';
            }
        ?>
        </form>
    </div>



<?php

    include "includes/footer.php";

    ob_end_flush();
?>