<nav class="navbar navbar-expand-md header_title mt-3 mb-3">
        <div class="container">
            <button
             class="navbar-toggler" 
             type="button" 
             data-bs-toggle="collapse" 
             data-bs-target="#mainmune">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainmune">
                <ul class="navbar-nav">
                    <li class="nav-item ms-3">
                        <a href="index.php" class="nav-link <?=$current_page =='index.php' ?
                        'active' : '' ?>">الرئيسية</a></li>
                    <li class="nav-item ms-3">
                        <a href="help.php" class="nav-link <?=$current_page =='help.php' ?
                        'active' : '' ?>">الشكاوي والمقترحات</a></li>
                    <li class="nav-item ms-3">
                        <a href="info.php" class="nav-link <?=$current_page =='info.php' ?
                        'active' : '' ?>">عن الإدارة</a></li>
                    <li class="nav-item ms-3">
                        <a href="#contact" class="nav-link <?=$current_page =='contact.php' ?
                        'active' : '' ?>">اتصل بنا</a></li>
                </ul>
            </div>
            <button class="btnFollow"><a href="follow.php">متابعة الشكوي</a></button>
        </div>
    </nav>
    

        