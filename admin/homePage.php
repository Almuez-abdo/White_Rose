<?php
    ob_start();


    session_start();

if(isset($_SESSION['Name_Boss'])){

    $pageTitle  = "الإدارة" ;

    if (!isset($_SESSION['Name_Boss'])){
        header('location: index.php');
        exit();
    }
    include 'init.php';

    $stPat = $con->prepare("SELECT * FROM user");
    $stPat ->execute();
    $allPat = $stPat->fetchAll();
    ?>

        <h1 class= "text-center py-3">التحكم </h1>';
        <div class= "container">
            <div class="row">
                <div class= "col-md-4">
                    <h2> المرضي</h2>
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>أسم المريض</td>
                        </tr>
                <?php 
                    foreach($allPat as $Pat){

                        echo"<tr>";
                            echo "<td>" .$Pat['Patient_ID'] . "</td>";
                            echo "<td>" .$Pat['Patient_Name'] . "</td>";
                        echo "<tr>";                   
                        }?>
                    </table>
                </div>
        

<?php
                $stDoc = $con->prepare("SELECT * FROM doctor WHERE Doctor_State < 2");
                $stDoc ->execute();
                $allDoc = $stDoc->fetchAll();
    ?>

                <div class= "col-md-4">
                    <h2> الاطباء</h2>
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>أسم الطبيب</td> 
                            <td> التحكم </td>                  
                        </tr>
                <?php 
                    foreach($allDoc as $doc){

                        echo"<tr>";
                            echo "<td>" .$doc['Doctor_ID'] . "</td>";
                            echo "<td>" .$doc['Doctor_Name'] . "</td>";
                              echo "<td>";
                                echo "<a href= '../active.php?do=DeleteDoc&userID=" . $doc['Doctor_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                                echo "<a href= '../active.php?do=emprove&userID=" . $doc['Doctor_ID'] . " ' class= 'btn btn-success confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>ترقية</a>"; 
                            echo "</td>";
                        echo "<tr>";                   
                        }?>
                    </table>
                </div>
<?php
                $stBoss = $con->prepare("SELECT * FROM doctor WHERE Doctor_State = 2");
                $stBoss ->execute();
                $allBoss = $stBoss->fetchAll();
    ?>

                <div class= "col-md-4">
                    <h2> المدير الطبي</h2>
                    <table class= "table table-bordered text-center">
                        <tr class="bg-dark text-light">
                            <td>الرقم</td>      
                            <td>أسم الطبيب</td>
                             <td> التحكم </td>         
                        </tr>
                <?php 
                    foreach($allBoss as $boss){

                        echo"<tr>";
                            echo "<td>" .$boss['Doctor_ID'] . "</td>";
                            echo "<td>" .$boss['Doctor_Name'] . "</td>";
                            echo "<td>";
                                echo "<a href= '../active.php?do=DeleteDoc&userID=" . $boss['Doctor_ID'] . " ' class= 'btn btn-danger confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>حزف</a>";
                                echo "<a href= '../active.php?do=drop&userID=" . $boss['Doctor_ID'] . " ' class= 'btn btn-info confirm'>
                                    <i class= 'fa fa-close fa-sm ms-1'></i>تخفيض</a>"; 
                            echo "</td>";
                        echo "<tr>";                   
                        }?>
                    </table>
                </div>
            </div>
        </div>
    

                            

<?php
}
    include 'includes/footer.php';

    ob_end_flush();

    ?>




