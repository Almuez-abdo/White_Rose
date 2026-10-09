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


<div class="hero-clinic">
    <div class="container">
        <h2>مستشفى الوردة البيضاء لعلاج الإدمان</h2>
        <p>نحن هنا لمساعدتك على بداية حياة جديدة خالية من الإدمان — بسرية تامة ورعاية متخصصة</p>
    </div>
</div>

<div class="container">
    <div class="login-grid">
        <div class="login-card">
            <div class="login-card-img">
                <img src="layout/images/fever.png" alt="دخول المرضى">
            </div>
            <div class="login-card-body">
                <h3>تسجيل دخول المرضى</h3>
                <p>تابع حالتك العلاجية وتواصل مع طبيبك المعالج</p>
                <div class="button"><a href="log_patient.php">تسجيل الدخول</a></div>
            </div>
        </div>

        <div class="login-card">
            <div class="login-card-img">
                <img src="layout/images/doctor.png" alt="دخول الأطباء">
            </div>
            <div class="login-card-body">
                <h3>تسجيل دخول الاطباء</h3>
                <p>تابع مرضاك وارفع التقارير الطبية الخاصة بهم</p>
                <div class="button"><a href="log_doctor.php">تسجيل الدخول</a></div>
            </div>
        </div>

        <div class="login-card">
            <div class="login-card-img">
                <img src="layout/images/ad.png" alt="دخول المسؤول">
            </div>
            <div class="login-card-body">
                <h3>تسجيل دخول المسؤول</h3>
                <p>إدارة الأطباء والمرضى والاستشارات الطبية</p>
                <div class="button"><a href="admin/log.php">تسجيل الدخول</a></div>
            </div>
        </div>
    </div>
</div>

<div class="info">
    <div class="container">
        <h3>عن الإدمان ومخاطره</h3>
        <p>
            الإدمان يعد من أخطر المشكلات الصحية والاجتماعية التي تواجه المجتمعات المعاصرة,
            حيث لم يعد مقصورا علي فئة معينة من الأفراد,
            بل اصبح ظاهرة عالمية تتزايد بشكل ملحوظ مع التطور التكنولوجي والانفتاح الثقافي والاقتصادي.
            وتكمن خطورته في أنه لا يؤثر فقط علي صحة المدمن الجسدية والنفسية,
            وإنما يمتد أثره الي الأسرة والمجتمع ككل,
            مما يؤدي الي ارتفاع معدلات الجريمة وتفكك العلاقات الأسرية,
            وانخفاض الإنتاجية في مؤسسات العمل.
            وتشير العديد من الدراسات الي أن نسبة كبيرة من الشباب هم الأكثر عرضة للوقوع في براثن الإدمان
            نتيجة الضغوط الاجتماعية والنفسية وضعف الوعي بمخاطره 
        </p>
    </div>
</div>
            
<?php
    include "includes/footer.php";

    ob_end_flush();
?>
