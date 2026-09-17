# Bright Steps Child Nursery — الموقع + لوحة التحكم

موقع تسويقي كامل لحضانة Bright Steps، مبني بـ **PHP + MySQL** (بدون WordPress) عشان يكون خفيف وسهل النشر على Hostinger عن طريق GitHub.

فيه:
- موقع عام: الرئيسية، عن الحضانة، البرامج، معرض الصور، المدونة، تواصل معنا.
- **لوحة تحكم** (`/admin`) تدخل منها تعدل: نصوص الصفحات، البرامج، المدونة، معرض الصور (رفع مباشر للسيرفر)، إعدادات الموقع (تليفون/عنوان/سوشيال ميديا)، ورسائل التواصل اللي بتوصل من الفورم.
- كل الصور اللي بترفعها من الداشبورد (المعرض أو صور المقالات/البرامج) بتُحفظ فعليًا على السيرفر جوه `public/uploads/` وبتظهر فورًا في الموقع.

---

## 1) قبل الرفع على GitHub

الملف ده مهم جدًا:

- `config.php` **متعمول له .gitignore بالفعل** ومش هيترفع على GitHub (فيه باسورد قاعدة البيانات). هتعمله بنفسك على السيرفر مباشرة (خطوة 3).
- استخدم `config.php.example` كمرجع بس.

```bash
cd brightsteps-site
git init
git add .
git commit -m "Bright Steps - النسخة الأولى"
git branch -M main
git remote add origin https://github.com/USERNAME/REPO-NAME.git
git push -u origin main
```

> ملحوظة: احنا رفعنا بس الكود (theme/plugin منطقي هنا = الموقع نفسه)، مفيش داعي نرفع أي WordPress core لأننا مش مستخدمين WordPress في النسخة دي — ده بيخلي الـ repo خفيف وسهل التحديث.

---

## 2) ربط GitHub بـ Hostinger

Hostinger فيه ميزة **Git** جوه hPanel (Advanced → Git)، بتسمحلك تربط الموقع مباشرة بـ repo على GitHub وتعمل Pull بزرار واحد كل ما تعدّل:

1. من hPanel: **Advanced → Git**.
2. حط رابط الـ repository (لو private، Hostinger بيطلب منك SSH key تضيفها في GitHub → Settings → Deploy keys).
3. في خانة **Directory to install**، اكتب المسار اللي عايز الموقع ينزل فيه (لازم يبقى هو نفسه Document Root بتاع الدومين).
4. دوس **Deploy/Pull**.

**مهم:** الدومين لازم يشاور على مجلد `public/` من المشروع (ده اللي فيه `index.php` و`admin/`)، مش على جذر المشروع. من hPanel → **Websites → Manage → Document Root**، غيّره لـ:
```
/home/USERNAME/repo-folder-name/public
```

---

## 3) إعداد قاعدة البيانات

1. من hPanel: **Databases → MySQL Databases** → اعمل قاعدة بيانات جديدة + مستخدم جديد وحدد له صلاحيات كاملة على القاعدة.
2. من **phpMyAdmin**، افتح القاعدة الجديدة → **Import** → رفّع ملف `database/schema.sql` الموجود في المشروع.
3. على السيرفر (عن طريق File Manager أو SSH)، انسخ `config.php.example` وسمّيه `config.php`، وحدّث فيه:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'اسم_القاعدة_من_hPanel');
   define('DB_USER', 'اسم_المستخدم_من_hPanel');
   define('DB_PASS', 'الباسورد');
   define('SITE_URL', 'https://your-domain.com');
   define('APP_SECRET', 'نص عشوائي طويل غيّره');
   ```
4. تأكد إن مجلد `public/uploads/` وكل ما فيه Permissions تسمح بالكتابة (755 أو 775 حسب إعداد السيرفر) عشان رفع الصور يشتغل.

---

## 4) الدخول على لوحة التحكم

الرابط: `https://your-domain.com/admin/login.php`

بيانات الدخول الافتراضية (موجودة في `database/schema.sql`):
- **Username:** `admin`
- **Password:** `BrightSteps@2026`

**غيّر الباسورد فورًا** بعد أول تسجيل دخول (من phpMyAdmin: عدّل عمود `password_hash` بقيمة جديدة، أو ابعتلي تحب نضيف صفحة "تغيير كلمة المرور" جوه الداشبورد نفسها لاحقًا).

---

## 5) خطوات لازم تتعمل قبل ما الموقع يفتح للجمهور

كل ده محدد بوضوح جوه الداشبورد بعلامة "يحتاج تأكيد" أو "Placeholder":

- [ ] استبدال كل النصوص المكتوب فيها `[يحتاج تأكيد من الإدارة]` في **محتوى الصفحات** (فلسفة الحضانة، المعلمين، إلخ) بمحتوى حقيقي ومؤكد.
- [ ] إضافة **البرامج** الحقيقية (الاسم، الفئة العمرية، الوصف) وتفعيل "نشر" لكل واحد.
- [ ] تحديث **إعدادات الموقع**: التليفون، الواتساب، العنوان، لينكات السوشيال ميديا، وكود خريطة جوجل (لو عايز).
- [ ] رفع صور حقيقية في **معرض الصور**.
- [ ] كتابة أول مقال في **المدونة**.

المشروع مصمم عشان أي حاجة فاضية أو Placeholder **متبانش للزوار العاديين** (البرامج مثلاً بتفضل "غير منشورة" لغاية ما تراجعها وتنشرها بنفسك) — عشان محدش يشوف معلومة مش مؤكدة.

---

## هيكل الملفات

```
brightsteps-site/
├── config.php.example      ← نسخة منه باسم config.php على السيرفر
├── .gitignore
├── database/schema.sql      ← يترفع مرة واحدة على phpMyAdmin
├── includes/                ← اتصال قاعدة البيانات + دوال + هيدر/فوتر الموقع العام
└── public/                  ← ده الـ Document Root على السيرفر
    ├── index.php / about.php / programs.php / gallery.php / blog.php / blog-post.php / contact.php
    ├── assets/css, assets/js, assets/img (فيه الشعار الحقيقي)
    ├── uploads/              ← هنا بتُحفظ كل الصور المرفوعة من الداشبورد (محمي بـ .htaccess)
    └── admin/                ← لوحة التحكم الكاملة
        ├── login.php / dashboard.php / content.php / programs.php
        ├── blog.php / blog-edit.php / gallery.php / settings.php / messages.php
        └── includes/ (auth.php + layout مشترك)
```

---

## ملاحظات مهمة

- الموقع باللغة العربية بالكامل (RTL) وبألوان هوية Bright Steps الحقيقية (من الشعار المرفوع).
- مفيش أي معلومة مُلفّقة عن برامج، شهادات، أسعار، أو نتائج — كل حاجة من النوع ده سايبها فاضية أو Placeholder واضح لحد ما تدخلها إنت بنفسك من الداشبورد.
- لو محتاج نضيف لاحقًا: نظام حجز زيارات بمواعيد، تسجيل أونلاين، دعم لغة إنجليزية، أو ربط الفورم بواتساب مباشرة — دي إضافات سهلة على نفس الأساس ده.
