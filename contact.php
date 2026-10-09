<?php
ob_start();
    session_start();
    $pageTitle  = "الاستشارات" ;


    include "init.php";
    


    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['newCon'])){
            $name = strip_tags($_POST['user']);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
            $phone = $_POST['phone'];
            $msg = strip_tags($_POST['message']);

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

        
            if(! empty($formError)){
                foreach($formError as $error){
                    echo '<div class= "alert alert-danger">' . $error . '</div>';
                }
            }else{
        
                $stCons = $con-> prepare("INSERT INTO 
                                                consultation(Cons_Name, Cons_Email, Cons_Age, Cons_Phone, Cons_Msg, Cons_State, Cons_Date)
                                        VALUES(:Zname, :zmail, :zage, :zphone, :zmsg, 0, now());
                                            ");
                    $stCons->execute(array(
                        'Zname'     => $name,
                        'zmail'     => $email,
                        'zage'      => $age,
                        'zphone'    => $phone,
                        'zmsg'      => $msg
                    ));


                    $stcode = $con-> prepare("SELECT * FROM consultation WHERE Cons_Name = '$name'");
                    $stcode->execute();
                    $codes = $stcode->fetchAll();
                    foreach($codes as $code);
                
                $theMsg= '<div class= "alert alert-success"> تمت رفع استشارتك بنجاح بالرقم (' . $code['Cons_ID'] . ') </div>';
                redirectHome($theMsg, 4, 'index.php');

            }
        } 
    }else{

    ?>

            <div class="container">
                <div class="row" style="display: flex; justify-content: space-between;">
                    <div class="col-md-5">
                        <h3 class="pt-4">استشارة جديدة</h3>
                        <form action= "<?php echo $_SERVER['PHP_SELF'] ?>" method = "POST">
                            <div class= "input_cont mb-2">
                                <input class="form-control" type="text" name= "user" placeholder= "الاسم رباعي" autocomplete="off" required/>
                                <span class= "asterisk">*</span>
                            </div>
                            <div class= "input_cont mb-2">
                                <input class="form-control" type="mail" name= "email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$" placeholder= "example@email.com" autocomplete="off" required/>
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
                            <div class="input_cont mb-2">
                                <textarea style="width: -webkit-fill-available" name="message" placeholder="نص الاستشارة" required></textarea>
                                <span class= "asterisk">*</span>
                            </div>
                            <input type="submit" class="btn btn-primary my-3" value="إرسال" name="newCon">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <h3 class="pt-4">متابعة الأستشارة</h3>
                        <form method="POST" action=" <?php echo $_SERVER['PHP_SELF'] ?>">
                            <div class= "input_cont mb-2">
                                <input class="form-control" type="text" name= "num" placeholder= "رقم الاستشارة" required/>
                                <span class= "asterisk">*</span>
                            </div>
                            <div class= "input_cont mb-2">
                                <input class="form-control" type="mail" name= "mail" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-z]{2,}$" placeholder= "example@email.com" autocomplete="off" required/>
                                <span class= "asterisk">*</span>
                            </div>
                            <input type="submit" class="btn btn-primary my-3" value="بحث">
                        </form>
                    </div>
                </div>
            </div>
<?php
    }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!isset($_POST['newCon'])){
                $code = $_POST['num'];
                $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);

                $stCons = $con-> prepare("SELECT * FROM consultation WHERE Cons_ID = ?");
                $stCons->execute(array($code));
                $cons = $stCons->fetchAll();
                $coCount = $stCons->rowCount();

                if($coCount > 0){
?>
                <div class="conatainer mt-3">
                    <div class="patient_t">
                        <h2>مرحباً بك  في مستشفى الوردة البيضاء لعلاج الإدمان</h2>
                        <h4>نحن هنا لمساعدتك على بداية حياة جديدة خالية من الإدمان.</h4>
                    </div>
                    <div class= "table-responsive">
                        <table class= "table table-bordered text-center">
                            <tr class="bg-dark text-light">
                                <td>الأسم</td>      
                                <td>الأيميل</td>      
                                <td>الاستشارة</td>      
                                <td>الرد</td>
                                <td>للتواصل</td>                  
                            </tr>
<?php
                foreach($cons as $con){
                        echo"<tr>";
                            echo "<td>" . $con['Cons_Name'] . "</td>";
                            echo "<td>" . $con['Cons_Email'] . "</td>";
                            echo "<td>" . $con['Cons_Msg'] . "</td>";
                            echo "<td>"; 
                            if($con['Doctor_Answer'] != NULL){
                                echo $con['Doctor_Answer'];
                            }else{
                                echo 'في انتظار الرد';
                            }
                                echo "</td>";
                            echo "<td> white_rose888@gmail.com</td>";
                        echo"</tr>";
                    }
?>
                        </table>
                    </div>
                </div>
                
<?php            
                }else{
                    $theMsg= '<div class= "alert alert-denger"> رقم الشكوي او البريد الالكتروني غير صحيح </div>';
                    redirectHome($theMsg, 4, 'back'); 
                } 
            }
        }
        
    

        include "includes/footer.php";

        ob_end_flush();

    ?>