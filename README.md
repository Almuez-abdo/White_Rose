# White Rose — منصة طبية (أطباء ومرضى)

منصة PHP + MySQL (تسجيل أطباء ومرضى، استشارات، تقارير، لوحة إدارة) — بدون مكتبات خارجية.

## المتطلبات
- PHP 8.x + MySQL/MariaDB (XAMPP) — لا يحتاج Composer

## التشغيل
1. انسخ المشروع إلى `htdocs/White_Rose`
2. أنشئ قاعدة بيانات `white_rose` واستورد ملف `white_rose.sql` (هيكل الجداول فقط، بدون بيانات):
   - phpMyAdmin ← استيراد ← `white_rose.sql`
3. أنشئ حسابات تجريبية:
   ```sql
   INSERT INTO `boss` (`Boss_Name`, `Boss_Pass`, `Boss_Email`)
   VALUES ('admin', SHA1('admin123'), 'admin@example.com');

   INSERT INTO `doctor` (`Doctor_Name`, `Doctor_Pass`, `Doctor_Avatar`, `Doctor_Email`, `Doctor_Phone`, `Doctor_Age`, `Doctor_State`, `Date`)
   VALUES ('Demo Doctor', SHA1('admin123'), '', 'doc@example.com', '249900000000', 30, 1, CURDATE());

   INSERT INTO `user` (`Patient_Name`, `Patient_Pass`, `Patient_Avatar`, `Patient_Email`, `Patient_Phone`, `Patient_Age`, `Patient_Message`, `Patient_State`, `Date`)
   VALUES ('Demo Patient', SHA1('admin123'), '', 'patient@example.com', '249911111111', 25, 'Demo', 0, CURDATE());
   ```
4. إعداد الاتصال في `conect.php` (الوضع الافتراضي: `root` بدون كلمة سر)
5. افتح: `http://localhost/White_Rose/index.php`
