<?php
    ob_start();
    session_start();
    $pageTitle = "Edit_Avatar";

    include "init.php";


    if($_SERVER['REQUEST_METHOD']== 'POST'){

        if(!empty($_FILES['avatar']['name'])){
            // Avatar Upload
            $avatarName = $_FILES['avatar']['name'];
            $avatarSize = $_FILES['avatar']['size'];
            $avatarTmp  = $_FILES['avatar']['tmp_name'];
            $avatarType = $_FILES['avatar']['type'];
            $avatarExt  = array("jpeg", "jpg", "png", "gif");
            $extensionArray  = explode(".", $avatarName);
            $endExten = strtolower(end($extensionArray));

            // Validate The Form
            $formError = array();

            if(! empty($avatarName) && ! in_array($endExten, $avatarExt)){
                $formError[]= 'امتداد الصورة  <strong> غير مطابق </strong>';
            }
            if($avatarSize > 4194304 ){
                $formError[]= 'حجم الصورة يجب ان لا يتعدي <strong> 4 ميغابايت</strong>';
            }

            if(empty($formError)){
                $avatar = rand(0, 10000000) . $avatarName;
                move_uploaded_file($avatarTmp, "upload\avatar\Patient\\" . $avatar);

                $stUpload = $con->Prepare("UPDATE user SET Patient_Avatar = ? WHERE ID = ?");
                $stUpload->execute(array($avatar, $_SESSION['Id']));

                $theMsg= '<div class= "alert alert-success"> تمت العملية بنجاح</div>';
                redirectHome($theMsg, 3, 'index.php');
                }
            
            }else{
                $theMsg= '<div class= "alert alert-danger"> لم يتم تغيير الصورة</div>';
                redirectHome($theMsg, 3, 'back');           
             }
    }

    $stAvatar = $con->prepare("SELECT Patient_Avatar FROM user WHERE ID = ?");
    $stAvatar->execute(array($_SESSION['Id']));
    $pro = $stAvatar->fetch();
    ?>
    <div class= "container avatar">
        <div class= "row">
            <div class= "col-lg-4">
            </div>
            <div class= "col-lg-3">
                <form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method= "POST" enctype= "multipart/form-data">';
                <?php
                    if(! empty($pro['Patient_Avatar'])){
                        echo '<img src="upload/avatar/Patient/' . $pro['Patient_Avatar'] . '" alt="" class="card-img-top avatar-img">';
                    }else{
                        echo '<img src="layout/images/pro.jpeg" alt="صورة افتراضية" class="card-img-top avatar-img avatar-placeholder">';
                    }
                ?> 
                    <div class= "load_image">
                        <input type= "file" name= "avatar" class= "form-control" value= "<?php echo $pro['Patient_Avatar'] ?>" />
                        <input type= "submit" value= "تحميل" class= "btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php

    include "includes/footer.php";
    ob_end_flush();
    ?>