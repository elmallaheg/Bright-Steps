-- Bright Steps Nursery - Database Schema
-- استوردها من phpMyAdmin على Hostinger قبل ربط config.php

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(60) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(120) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- محتوى الصفحات: كل حقل قابل للتعديل من الداشبورد (نص أو صورة)
CREATE TABLE IF NOT EXISTS content_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(60) NOT NULL,      -- home, about, contact ...
    field_key VARCHAR(80) NOT NULL,     -- hero_title, hero_subtitle ...
    field_label VARCHAR(160) NOT NULL,  -- الاسم اللي يظهر في الداشبورد
    field_type ENUM('text','textarea','richtext','image') NOT NULL DEFAULT 'text',
    field_value TEXT,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_page_field (page_key, field_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- إعدادات عامة للموقع (تليفون، واتساب، عنوان، سوشيال ميديا)
CREATE TABLE IF NOT EXISTS site_settings (
    setting_key VARCHAR(80) PRIMARY KEY,
    setting_value TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- البرامج التعليمية / الفئات العمرية
CREATE TABLE IF NOT EXISTS programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(160) NOT NULL,
    age_range VARCHAR(100) DEFAULT NULL,
    description TEXT,
    image VARCHAR(255) DEFAULT NULL,
    sort_order INT DEFAULT 0,
    is_published TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- المدونة
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(220) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    excerpt VARCHAR(400) DEFAULT NULL,
    content LONGTEXT,
    cover_image VARCHAR(255) DEFAULT NULL,
    status ENUM('draft','published') DEFAULT 'draft',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- معرض الصور
CREATE TABLE IF NOT EXISTS gallery_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    sort_order INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT DEFAULT NULL,
    caption VARCHAR(220) DEFAULT NULL,
    filename VARCHAR(255) NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES gallery_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- رسائل التواصل من نموذج "تواصل معنا"
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parent_name VARCHAR(160),
    phone VARCHAR(40),
    child_age VARCHAR(60),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================== Seed Data (بيانات مبدئية قابلة للتعديل كاملة من الداشبورد) ==================

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'Bright Steps Child Nursery'),
('phone', 'يتم إضافته من لوحة التحكم'),
('whatsapp', 'يتم إضافته من لوحة التحكم'),
('email', 'يتم إضافته من لوحة التحكم'),
('address', 'يتم إضافته من لوحة التحكم'),
('facebook', ''),
('instagram', ''),
('tiktok', ''),
('map_embed', '')
ON DUPLICATE KEY UPDATE setting_key = setting_key;

INSERT INTO content_blocks (page_key, field_key, field_label, field_type, field_value) VALUES
('home','hero_title','عنوان الصفحة الرئيسية الكبير','textarea','في Bright Steps، طفلك بيتعلم يفكر مش بس يحفظ الإجابة'),
('home','hero_subtitle','الجملة اللي تحت العنوان','textarea','بيئة آمنة عاطفيًا بتسيب الطفل يستكشف ويجرب ويسأل، وده اللي بيبني عنده حب التعلم من الأول.'),
('home','pillars_title','عنوان قسم "ليه مختلفين"','text','إيه اللي بيفرق فعلاً في Bright Steps'),
('home','pillar1_title','عنوان الميزة الأولى','text','الأمان العاطفي أولاً'),
('home','pillar1_body','شرح الميزة الأولى','textarea','[يحتاج تأكيد من الإدارة] الطفل ميتعلمش وهو خايف أو مضغوط. لما يحس بالأمان مع فريقه، بيقدر يجرب ويغلط ويتعلم من غلطه بدل ما يخاف يجرب من الأساس.'),
('home','pillar2_title','عنوان الميزة الثانية','text','تعلّم من خلال اللعب والتجربة'),
('home','pillar2_body','شرح الميزة الثانية','textarea','[يحتاج تأكيد من الإدارة] المعلومة اللي الطفل يوصلها بنفسه من خلال التجربة بتفضل معاه أكتر من المعلومة اللي حفظها بس. عندنا الأنشطة مصممة عشان الطفل يوصل للفكرة، مش يستقبلها جاهزة.'),
('home','pillar3_title','عنوان الميزة الثالثة','text','بناء الاستقلالية وحل المشاكل'),
('home','pillar3_body','شرح الميزة الثالثة','textarea','[يحتاج تأكيد من الإدارة] بنسيب مساحة للطفل عشان يحاول يحل المشكلة لوحده الأول قبل ما نتدخل، عشان يكبر عنده الثقة إنه يقدر.'),
('home','questions_title','عنوان قسم أسئلة الأهل','text','الأسئلة اللي كل أب وأم بيسألها'),
('home','cta_title','عنوان الدعوة للتواصل','text','عايز تشوف بيئة Bright Steps بنفسك؟'),
('home','cta_body','نص الدعوة للتواصل','textarea','احجز زيارة وشوف الفصول والأنشطة على الطبيعة قبل ما تقرر.'),

('about','philosophy_title','عنوان فلسفة الحضانة','text','إحنا بنؤمن إن كل طفل ليه طريقته في الفهم'),
('about','philosophy_body','نص الفلسفة','richtext','[يحتاج تأكيد من الإدارة] نص تفصيلي عن فلسفة Bright Steps التربوية، ليه بنعمل اللي بنعمله، ودور المعلمة الحقيقي جوه الفصل. يتم كتابته بناءً على معلومات مؤكدة من الإدارة.'),
('about','teachers_title','عنوان قسم المعلمين','text','فريقنا'),
('about','teachers_body','نص عن المعلمين','richtext','[يحتاج تأكيد من الإدارة] معلومات عن خبرة وتأهيل فريق التدريس — لا يُكتب أي مؤهل أو شهادة إلا بعد تأكيدها من الإدارة.'),

('contact','intro_title','عنوان صفحة التواصل','text','يسعدنا نسمع منك'),
('contact','intro_body','نص تحت العنوان','textarea','احجز زيارة، أو اسألنا أي سؤال عن ابنك/بنتك وإحنا هنرد بسرعة.')
ON DUPLICATE KEY UPDATE field_value = field_value;

INSERT INTO programs (title, age_range, description, sort_order, is_published) VALUES
('[يحتاج تعديل من الداشبورد] اسم البرنامج الأول', '[العمر]', 'اكتب هنا وصف حقيقي للبرنامج من لوحة التحكم قبل النشر للزوار.', 1, 0),
('[يحتاج تعديل من الداشبورد] اسم البرنامج الثاني', '[العمر]', 'اكتب هنا وصف حقيقي للبرنامج من لوحة التحكم قبل النشر للزوار.', 2, 0);

INSERT INTO gallery_categories (name, sort_order) VALUES
('أنشطة داخل الفصل', 1),
('اللعب والاستكشاف', 2),
('فعاليات ومناسبات', 3);

-- حساب مشرف افتراضي: username = admin / password = BrightSteps@2026
-- غيّر كلمة المرور فورًا من قاعدة البيانات أو أضف حساب جديد وامسح هذا الحساب.
INSERT INTO admin_users (username, password_hash, display_name) VALUES
('admin', '$2y$10$yziLPymjy.LFogFVH/ogiOYE8O5VWs1tQuD3Tmr.aP9FkM9A867Ei', 'Bright Steps Admin');
