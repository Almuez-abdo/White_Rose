<?php
    ob_start();

    session_start();
    $pageTitle = "الرئيسية";

    if (isset($_SESSION['Name_Patient']) || isset($_SESSION['Name_Doctor'])){
        header('location: home.blade.php');
        exit();
    }elseif(isset($_SESSION['Name_Boss'])){
        header('location: admin/homePage.php');
        exit();
    }
    include "init.php";
    
?>



<div class="content-grids">
    <div class="section group">        
        <div class="listview_1_of_3 images_1_of_3">
            <div class="listimg listimg_1_of_2">
                <img src="layout/images/fever.png">
            </div>
            <div class="text list_1_of_2">
                <h3>تسجيل دخول المرضئ</h3>
                <div class="button"><a href="log_patient.php">تسجيل الدخول</a></div>
            </div>
        </div>	

        <div class="listview_1_of_3 images_1_of_3">
            <div class="listimg listimg_1_of_2">
                <img src="layout/images/doctor.png">
            </div>
            <div class="text list_1_of_2">
                <h3>تسجيل دخول الاطباء</h3>
                <div class="button"><a href="log_doctor.php">تسجيل الدخول</a></div>
            </div>
        </div>

        <div class="listview_1_of_3 images_1_of_3">
            <div class="listimg listimg_1_of_2">
                <img src="layout/images/ad.png">
            </div>
            <div class="text list_1_of_2">
                <h3>تسجيل دخول المسؤول</h3>	
                <div class="button"><a href="admin/log.php">تسجيل الدخول</a></div>
            </div>
        </div>			
	</div>
</div>

<div class="info">
    <p>
        الإدمان يعد من أخطر المشكلات الصحية والاجتماعية التي تواجه المجتمعات المعاصرة,
        <br>حيث لم يعد مقصورا علي فئة معينة من الأفراد,
        <br>بل اصبح ظاهرة عالمية تتزايد بشكل ملحوظ مع التطور التكنولوجي والانفتاح الثقافي والاقتصادي.
        <br>وتكمن خطورته في أنه لا يؤثر فقط علي صحة المدمن الجسدية والنفسية,
        <br>وإنما يمتد أثره الي الأسرة والمجتمع ككل,
        <br>مما يؤدي الي ارتفاع معدلات الجريمة وتفكك العلاقات الأسرية,
        <br>وانخفاض الإنتاجية في مؤسسات العمل.
        <br>وتشير العديد من الدراسات الي أن نسبة كبيرة من الشباب هم الأكثر عرضة للوقوع في براثن الإدمان
        نتيجة الضغوط الاجتماعية والنفسية وضعف الوعي بمخاطره 
    </p>
</div>
            
<?php
    include "includes/footer.php";

    ob_end_flush();
?>