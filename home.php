<?php
ob_start();

    session_start();
    
    if(isset($_SESSION['Name_Patient'])){
        $pageTitle = " المرضي";
        include "init.php";

        $stPat = $con->prepare("SELECT * FROM user
                                INNER JOIN
                                    doctor
                                ON
                                    doctor.Doctor_ID = user.doctor_Id
                                INNER JOIN
                                    step
                                ON
                                    step.Step_ID = user.Patient_Step  
                                WHERE Patient_Name = ?");
        $stPat -> execute(array($_SESSION['Name_Patient']));
        $pat = $stPat->fetch();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $msg = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
    
            $upUser = $con->prepare("UPDATE user SET Patient_Message = ? WHERE Patient_Name = ?");
            $upUser -> execute(array($msg, $_SESSION['Name_Patient']));
    
            $theMsg= '<div class= "alert alert-success"> مرحبا ' . $_SESSION['Name_Patient'] . '  تم رفع شكوتك بنجاح </div>';
            redirectHome($theMsg, 3, 'index.php');
    
        }
?>
        <div class="conatainer">
            <div class="patient_t">
                <h2>مرحباً بك <?php echo $_SESSION['Name_Patient'] ?> في مستشفى الوردة البيضاء لعلاج الإدمان</h2>
                <h4>نحن هنا لمساعدتك على بداية حياة جديدة خالية من الإدمان.</h4>
            </div>
            <div class="row profile-row">
                <h2>البيانات الشخصية :- </h2>
                <hr>
                <div class="col-md-5 col-lg-5">
                    <div class="avatar-wrap">
                        <?php
                        if(! empty($pat['Patient_Avatar'])){
                            echo '<img src="upload/avatar/Patient/' . $pat['Patient_Avatar'] . '" alt="" class="card-img-top avatar-img">';
                        }else{
                            echo '<img src="layout/images/pro.jpeg" alt="" class="card-img-top avatar-img">';
                        }
                    ?>
                    <a href="avatar.php">تغيير الصورة </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <h4><span>الأسم : </span> <?php echo $pat['Patient_Name'] ?></h4>
                    <h4><span>البريد : </span> <?php echo $pat['Patient_Email'] ?></h4>
                    <h4><span>الهاتف : </span> <?php echo $pat['Patient_Phone'] ?></h4> 
                    <h4><span>العمر : </span> <?php echo $pat['Patient_Age'] ?></h4> 
                    <h4><span>الطبيب المعالج : </span> <?php echo $pat['Doctor_Name'] ?></h4> 
                    <h4><span>الحالة : </span> <?php echo $pat['Step_Name'] ?></h4>
                </div> 
            </div>
            <hr>
            <div class="row treatment-box">
                <div class="col-md-5">
                    <h2 class="treatment-title">تفاصيل العلاج :- </h2>
                    <hr>    
                    <h4><?php echo $pat['Step_Content'] ?></h4>
                    <hr>
                </div>
                <div class="col-md-5">
                    <h2> شكوي او مقترح :- </h2>
                    <hr>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                        <textarea name="message" placeholder="النص" required class="msg-box"></textarea>
                        <input type="submit" class="btn btn-primary" value="أرسال">
                    </form> 
                </div>
            </div>

<?php
    }elseif(isset($_SESSION['Name_Doctor'])){
        $pageTitle = " الاطباء";
        include "init.php";
        $stDoc = $con->prepare("SELECT * FROM doctor WHERE Doctor_Name = ?");
        $stDoc -> execute(array($_SESSION['Name_Doctor']));
        $doc = $stDoc->fetch();

        $stDocPat = $con ->prepare("SELECT * FROM user INNER JOIN step on step.Step_ID = user.Patient_Step WHERE doctor_Id = ?");
        $stDocPat -> execute(array($doc['Doctor_ID']));
        $doctor = $stDocPat->fetchAll();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $report = filter_var($_POST['report'],FILTER_SANITIZE_STRING);
            
            $upUser = $con->prepare("UPDATE user SET Doctor_Report = ? WHERE ID = ?");
            $upUser -> execute(array($report, $_POST ['pat_Id']));
    
            $theMsg= '<div class= "alert alert-success"> مرحبا ' . $_SESSION['Name_Doctor'] . '  تم رفع تقريرك بنجاح </div>';
            redirectHome($theMsg, 3, 'index.php');
    
        }
        if($doc['Doctor_State'] < 2){

?>
            <div class="patient_t">
                <h2>مرحباً بك د <?php echo $doc['Doctor_Name'] ?> في مستشفى الوردة البيضاء لعلاج الإدمان</h2>
                <h4>الطب رساله أنسانية وأنتم ملائكتنا</h4>
            </div>
            <div class="row profile-row">
                <h2>البيانات الشخصية :- </h2>
                <hr>
                <div class="col-md-5 col-lg-5">
                    <div class="avatar-wrap">
                        <?php
                        if(! empty($doc['Doctor_Avatar'])){
                            echo '<img src="upload/avatar/Doctor/' . $doc['Doctor_Avatar'] . '" alt="" class="card-img-top avatar-img">';
                        }else{
                            echo '<img src="layout/images/pro.jpeg" alt="" class="card-img-top avatar-img">';
                        }
                    ?>
                    <a href="avatar.php">تغيير الصورة </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <h4><span>الأسم : </span> <?php echo $doc['Doctor_Name'] ?></h4>
                    <h4><span>البريد : </span> <?php echo $doc['Doctor_Email'] ?></h4>
                    <h4><span>الهاتف : </span> <?php echo $doc['Doctor_Phone'] ?></h4>
                    <h4><span>العمر : </span> <?php echo $doc['Doctor_Age'] ?> سنة</h4>
                </div> 
            </div>
            <div>
                <h2 class="treatment-title">تفاصيل العلاج :- </h2>
                <hr>
                <div class="row">
                <?php
                foreach($doctor as $dPat){
                ?>
                    <div class="col-md-5 col-lg-5 doc-pat-card">
                        <h4><span>أسم المريض  : </span> <?php echo $dPat['Patient_Name'] ?></h4>
                        <h4><span>بريد المريض : </span> <?php echo $dPat['Patient_Email'] ?></h4>
                        <h4><span>هاتف المريض : </span> <?php echo $dPat['Patient_Phone'] ?></h4>
                        <h4><span>حالة العلاج  : </span> <?php echo $dPat['Step_Name'] ?></h4>
                        <h2><span>تقرير الطبيب  : </span></h2>
                        <?php
                        if($dPat['Doctor_Report'] == NULL){
                            echo '<form action="' . $_SERVER['PHP_SELF'] . '?>" method="POST">';
                                echo '<input type="hidden"  name= "pat_Id" value=" ' . $dPat['Patient_ID'] . '" >';
                                echo '<textarea name="report" placeholder="النص" required class="msg-box"></textarea>';
                                echo '<input type="submit" class="btn btn-primary" value="أرسال">';
                            echo '</form>';
                        }else{
                            echo '<h3>' . $dPat['Doctor_Report'] . '</h3>';
                        }
                        echo '<hr>';
                    echo '</div>';
                }
                ?> 
                </div>
            </div>
<?php
        }else{

            $stBussPa = $con ->prepare("SELECT * FROM user INNER JOIN 
                                                            step 
                                                        on 
                                                            step.Step_ID = user.Patient_Step 
                                                        INNER JOIN
                                                            doctor
                                                        on
                                                            doctor.Doctor_ID = user.doctor_Id
                                                        WHERE
                                                            Patient_State = 1
                                                        ");
            $stBussPa -> execute(array());
            $bussPat = $stBussPa->fetchAll();
?>
            <div class="patient_t">
                <h2>مرحباً بك د <?php echo $doc['Doctor_Name'] ?> في مستشفى الوردة البيضاء لعلاج الإدمان</h2>
                <h4>الطب رساله أنسانية وأنتم ملائكتنا</h4>
            </div>
            <div class="row profile-row">
                <h2>البيانات الشخصية :- </h2>
                <hr>
                <div class="col-md-5 col-lg-5">
                    <div class="avatar-wrap">
                        <?php
                        if(! empty($doc['Doctor_Avatar'])){
                            echo '<img src="upload/avatar/Doctor/' . $doc['Doctor_Avatar'] . '" alt="" class="card-img-top avatar-img">';
                        }else{
                            echo '<img src="layout/images/pro.jpeg" alt="" class="card-img-top avatar-img">';
                        }
                    ?>
                    <a href="avatar.php">تغيير الصورة </a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <h4><span>الأسم : </span> <?php echo $doc['Doctor_Name'] ?></h4>
                    <h4><span>البريد : </span> <?php echo $doc['Doctor_Email'] ?></h4>
                    <h4><span>الهاتف : </span> <?php echo $doc['Doctor_Phone'] ?></h4>
                    <h4><span>العمر : </span> <?php echo $doc['Doctor_Age'] ?> سنة</h4>
                </div> 
            </div>

            <h1 class= "text-left py-3">المرضي </h1>
            <div class= "table-responsive">
                <table class= "table table-bordered text-center">
                    <tr class="bg-dark text-light">
                        <td>الرقم</td>      
                        <td>الأسم</td>      
                        <td>الأيميل</td>      
                        <td>الهاتف</td>      
                        <td>العمر</td>
                        <td>المرحلة</td>                 
                        <td>الطبيب</td>           
                        <td>الشكوي</td>           
                        <td>تقرير الطبيب</td>           
                        <td>التحكم</td> 
                    </tr>

            <?php 
                foreach($bussPat as $buss){
                    echo"<tr>";
                        echo "<td>" . $buss['Patient_ID'] . "</td>";
                        echo "<td>" . $buss['Patient_Name'] . "</td>";
                        echo "<td>" . $buss['Patient_Email'] . "</td>";
                        echo "<td>" . $buss['Patient_Phone'] . "</td>";
                        echo "<td>" . $buss['Patient_Age'] . "</td>";
                        echo "<td>" . $buss['Step_Name'] . "</td>";
                        echo "<td>" . $buss['Doctor_Name'] . "</td>";
                        echo "<td>" . $buss['Patient_Message'] . "</td>";
                        echo "<td>" . $buss['Doctor_Report'] . "</td>";
                        echo "<td>
                                <a href= 'active.php?do=DeletePat&userID=" . $buss['Patient_ID'] . " ' class= 'btn btn-danger confirm'>
                            <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>
                            </td>";
                    echo "</tr>";
                }; 
                ?>  
                </table>
            </div>
<?php
            $noDoc = $con->prepare("SELECT * FROM user INNER JOIN step ON step.Step_ID = user.Patient_Step 
                                    WHERE doctor_Id IS NULL");
            $noDoc ->execute(array());
            $docs = $noDoc->fetchAll();
            $doCount = $noDoc->rowCount();

            if($doCount > 0){// don't have a doctor
                ?>
                <h1 class= "text-left py-3">لم يتم تعيين دكتور لهم </h1>
                <div class= "table-responsive">
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>الأسم</td>      
                            <td>الأيميل</td>      
                            <td>الهاتف</td>      
                            <td>العمر</td>
                            <td>الطبيب</td>           
                            <td>المرحلة</td>           
                            <td>التحكم</td> 
                        </tr>

                <?php 
                    foreach($docs as $doc){
                        echo"<tr>";
                            echo "<td>" . $doc['Patient_ID'] . "</td>";
                            echo "<td>" . $doc['Patient_Name'] . "</td>";
                            echo "<td>" . $doc['Patient_Email'] . "</td>";
                            echo "<td>" . $doc['Patient_Phone'] . "</td>";
                            echo "<td>" . $doc['Patient_Age'] . "</td>";
                            echo "<form method='POST' action='active.php'>";
                                echo "<input type='hidden' name='patId' value='" . $doc['Patient_ID'] . "'>";
                            echo "<td>";
                                    echo '<select name= "jDoc" class= "form-control" required= "requird">';
                                    $stmt3= $con->prepare("SELECT * FROM doctor");
                                    $stmt3->execute();
                                    $jDoctors = $stmt3->fetchAll();
                                    foreach($jDoctors as $jDoctor){
                                    echo "<option value='" . $jDoctor['Doctor_ID'] . "'>"  . $jDoctor['Doctor_Name'] . "</option>" ;
                                }
                                    echo "</select>";
                            echo "</td>";
                            echo "<td>";
                                echo '<select name= "jStep" class= "form-control" required= "requird">';
                                    $stmt4= $con->prepare("SELECT * FROM step");
                                    $stmt4->execute();
                                    $jSteps = $stmt4->fetchAll();
                                    foreach($jSteps as $jStep){
                                    echo "<option value='" . $jStep['Step_ID'] . "'>"  . $jStep['Step_Name'] . "</option>" ;
                                }
                                    echo "</select>";                                
                                    echo "</td>";
                                    echo "<td>";
                                        echo "<input type='submit' name='active' class='btn btn-success' value='تعيين'>";
                                    echo "</td>";
                                    echo "</form>";

                        echo "</tr>";
                    }
                ?>
                    
                    </table>
                </div>
<?php        
            }
            $stBussDoc = $con ->prepare("SELECT * FROM doctor  
                                                        WHERE
                                                            Doctor_State < 2
                                                        ");
            $stBussDoc -> execute(array());
            $bussDoc = $stBussDoc->fetchAll();


?>
            <h1 class= "text-left py-3">الأطباء </h1>
            <div class= "table-responsive">
                <table class= "table table-bordered text-center">
                    <tr class="bg-dark text-light">
                        <td>الرقم</td>      
                        <td>الأسم</td>      
                        <td>الأيميل</td>      
                        <td>الهاتف</td>      
                        <td>العمر</td>
                        <td>المرضي</td>           
                        <td>التحكم</td> 
                    </tr>

            <?php 
                foreach($bussDoc as $docs){
                    echo"<tr>";
                        echo "<td>" . $docs['Doctor_ID'] . "</td>";
                        echo "<td>" . $docs['Doctor_Name'] . "</td>";
                        echo "<td>" . $docs['Doctor_Email'] . "</td>";
                        echo "<td>" . $docs['Doctor_Phone'] . "</td>";
                        echo "<td>" . $docs['Doctor_Age'] . "</td>";
                        $st1 = $con->prepare("SELECT Patient_Name FROM user WHERE doctor_Id = ?");
                        $st1->execute(array($docs['Doctor_ID']));
                        $st = $st1->fetchAll();
                        echo "<td>";
                                foreach($st as $sts){
                                    echo $sts['Patient_Name'] . "<br>";
                                }  
                        echo "</td>";
                        
                        echo "<td>
                            <a href= 'active.php?do=DeleteDoc&userID=" . $docs['Doctor_ID'] . " ' class= 'btn btn-danger confirm'>
                            <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                        if($docs['Doctor_State'] == 0){
                        echo "<a href= 'active.php?do=Activate&userID=" . $docs['Doctor_ID'] . " ' class= 'btn btn-info'>
                        <i class= 'fa fa-close fa-sm ms-1'></i>تفعيل</a>";
                        }
                        echo "</td>";

                    echo "</tr>";
                    }
?>                        
                </table>
            </div>
<?php   

            $cons = $con->prepare("SELECT * FROM consultation WHERE Cons_State = 0");
            $cons->execute();
            $consultation = $cons->fetchAll();
            $conCount = $cons->rowCount();
            if($conCount > 0){
?>
            <h1 class= "text-left py-3">الاستشارات </h1>
            <div class= "table-responsive">
                <table class= "table table-bordered text-center">
                    <tr class="bg-dark text-light">
                        <td>الرقم</td>      
                        <td>الأسم</td>      
                        <td>الأيميل</td>      
                        <td>الهاتف</td>      
                        <td>العمر</td>
                        <td>نص الاستشارة</td>           
                        <td>الرد</td>
                        <td>ارسال</td>
                    </tr>

            <?php 
                foreach($consultation as $consult){
                    echo"<tr>";
                        echo "<td>" . $consult['Cons_ID'] . "</td>";
                        echo "<td>" . $consult['Cons_Name'] . "</td>";
                        echo "<td>" . $consult['Cons_Email'] . "</td>";
                        echo "<td>" . $consult['Cons_Phone'] . "</td>";
                        echo "<td>" . $consult['Cons_Age'] . "</td>";
                        echo "<td>" . $consult['Cons_Msg'] . "</td>";
                        echo "<form action='active.php' method='POST'>";
                            echo "<input type='hidden' value='" .  $consult['Cons_ID'] . "' name='consId'>";
                            echo "<td> <textarea name='ans'></textarea></td>";
                            echo "<td> <input type='submit' class='btn btn-success' name='cons_sub' value='أرسال'> </td>
                            </form>";
                    echo "</tr>";
                }
?>
                
                </table>
            </div>                
           
<?php
            }
        echo "</div>";
        }  
              
    }else {
        $theMsg= '<div class= "alert alert-danger"> لا يمكنك الدخول الي هذه الصفحة مباشره </div>';
        redirectHome($theMsg, 3, 'index.php');
    }


    include "includes/footer.php";

    ob_end_flush();
?>
