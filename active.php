<?php
ob_start();

    session_start();
    $pageTitle = " تعيين";

    include "init.php";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(!isset($_POST['cons_sub'])){
            $jDoc = $_POST['jDoc'];
            $jStep = $_POST['jStep'];
            $jID = $_POST['patId'];

            $upPatient = $con->prepare("UPDATE user SET doctor_Id = ?, Patient_Step = ?, Patient_State = ? WHERE Patient_ID = ?");
            $upPatient->execute(array($jDoc, $jStep, 1, $jID));

            $theMsg= '<div class= "alert alert-success"> تم التنفيذ بنجاح </div>';
            redirectHome($theMsg, 3, 'back');

        }else{

            $conID = $_POST['consId'];
            $conMsg = filter_var($_POST['ans'], FILTER_SANITIZE_STRING);
            echo '<div class="container">';
                    $check= checkItem("Cons_ID", "consultation", $conID);
                    if($check > 0){
                        $acDoc = $con->prepare("UPDATE consultation SET Cons_State = 1; Doctor_Answer = ? WHERE Cons_ID = ?");
                        $acDoc->execute(array($conMsg, $conID));

                        $theMsg= '<div class= "alert alert-success"> تم الرد علي الاستشارة بنجاح</div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        }
        }
    $do = isset($_GET['do']) ? $_GET['do'] : 'all';
    if($do == 'DeletePat'){
        echo '<div class="container">';
            $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
            $check= checkItem("Patient_ID", "user", $userId);
            
            if($check > 0){
                $delPat = $con->prepare("DELETE FROM user WHERE Patient_ID = ?");
                $delPat->execute(array($userId));

                $theMsg= '<div class= "alert alert-success">تم حزفه ' . $delPat-> rowCount() . ' سجل  </div>';
                redirectHome($theMsg, 5, 'back');

            }else {
                $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                redirectHome($theMsg, 5, "back");
            }
        echo '</div>';
    }elseif ($do == 'DeleteDoc'){ // Delete area

        echo '<div class="container">';
            $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
            $check= checkItem("Doctor_ID", "doctor", $userId);
            
            if($check > 0){
                $delDoc = $con->prepare("DELETE FROM doctor WHERE Doctor_ID = ?");
                $delDoc->execute(array($userId));

                $theMsg= '<div class= "alert alert-success">تم حزفه ' . $delDoc-> rowCount() . ' سجل  </div>';
                redirectHome($theMsg, 5, 'back');

            }else {
                $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                redirectHome($theMsg, 5, "back");
            }
    echo '</div>';
        }elseif ($do == 'Activate'){ // Activated area
            echo '<div class="container">';
                    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
                    $check= checkItem("Doctor_ID", "doctor", $userId);
                    
                    if($check > 0){
                        $acDoc = $con->prepare("UPDATE doctor SET Doctor_State = 1 WHERE Doctor_ID = ?");
                        $acDoc->execute(array($userId));

                        $theMsg= '<div class= "alert alert-success"> تم تفعيل المستخدم بنجاح</div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        }elseif($do == 'emprove'){
            echo '<div class="container">';
                    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
                    $check= checkItem("Doctor_ID", "doctor", $userId);
                    
                    if($check > 0){
                        $acDoc = $con->prepare("UPDATE doctor SET Doctor_State = 2 WHERE Doctor_ID = ?");
                        $acDoc->execute(array($userId));

                        $theMsg= '<div class= "alert alert-success"> تم ترقية المستخدم بنجاح</div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        }elseif($do == 'drop'){
            echo '<div class="container">';
                    $userId = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;     
                    $check= checkItem("Doctor_ID", "doctor", $userId);
                    
                    if($check > 0){
                        $acDoc = $con->prepare("UPDATE doctor SET Doctor_State = 1 WHERE Doctor_ID = ?");
                        $acDoc->execute(array($userId));

                        $theMsg= '<div class= "alert alert-success"> تم تخفيض المستخدم بنجاح</div>';
                        redirectHome($theMsg, 5, 'back');

                    }else {
                        $theMsg= '<div class= "alert alert-danger"> لايوجد مستخدم بهذا الاسم </div>';
                        redirectHome($theMsg, 5, "back");
                    }
            echo '</div>';
        }                  
            

    include "includes/footer.php";

    ob_end_flush();
?>
