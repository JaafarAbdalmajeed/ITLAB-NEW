# لوحة تحكم الإدمن - ITLAB

## نظرة عامة

تم إنشاء لوحة تحكم كاملة للإدمن تسمح بإدارة جميع محتويات الموقع بشكل ديناميكي.

## الميزات

### 1. نظام المصادقة
- تسجيل دخول للإدمن
- Middleware للتحقق من صلاحيات الإدمن
- حماية جميع صفحات الإدمن

### 2. إدارة المسارات (Tracks)
- عرض جميع المسارات
- إضافة مسار جديد
- تعديل مسار موجود
- حذف مسار
- عرض عدد الدروس والاختبارات والمختبرات لكل مسار

### 3. إدارة الدروس (Lessons)
- عرض جميع دروس المسار
- إضافة درس جديد
- تعديل درس موجود
- حذف درس
- ترتيب الدروس

### 4. إدارة الاختبارات (Quizzes)
- عرض جميع اختبارات المسار
- إضافة اختبار جديد
- تعديل اختبار موجود
- حذف اختبار
- إدارة الأسئلة داخل كل اختبار

### 5. إدارة أسئلة الاختبارات
- عرض جميع أسئلة الاختبار
- إضافة سؤال جديد (3 خيارات)
- تعديل سؤال موجود
- حذف سؤال
- تحديد الإجابة الصحيحة

### 6. إدارة المختبرات (Labs)
- عرض جميع مختبرات المسار
- إضافة مختبر جديد
- تعديل مختبر موجود
- حذف مختبر

### 7. إدارة الصفحات (Pages)
- عرض جميع الصفحات الثابتة
- إضافة صفحة جديدة
- تعديل صفحة موجودة
- حذف صفحة
- نشر/إلغاء نشر الصفحات

## التثبيت والإعداد

### 1. تشغيل Migration
```bash
php artisan migrate
```

### 2. تشغيل Seeders
```bash
php artisan db:seed
```

سيتم إنشاء مستخدم إدمن تلقائياً:
- **البريد الإلكتروني**: admin@itlab.com
- **كلمة المرور**: admin123

### 3. الوصول للوحة التحكم
1. اذهب إلى: `http://your-domain/login`
2. سجل دخول باستخدام بيانات الإدمن أعلاه
3. سيتم توجيهك تلقائياً إلى لوحة التحكم

## المسارات (Routes)

### المصادقة
- `GET /login` - صفحة تسجيل الدخول
- `POST /login` - معالجة تسجيل الدخول
- `POST /logout` - تسجيل الخروج

### لوحة التحكم
- `GET /admin/dashboard` - لوحة التحكم الرئيسية

### إدارة المسارات
- `GET /admin/tracks` - عرض جميع المسارات
- `GET /admin/tracks/create` - إضافة مسار جديد
- `POST /admin/tracks` - حفظ مسار جديد
- `GET /admin/tracks/{track}/edit` - تعديل مسار
- `PUT /admin/tracks/{track}` - تحديث مسار
- `DELETE /admin/tracks/{track}` - حذف مسار

### إدارة الدروس
- `GET /admin/tracks/{track}/lessons` - عرض دروس المسار
- `GET /admin/tracks/{track}/lessons/create` - إضافة درس جديد
- `POST /admin/tracks/{track}/lessons` - حفظ درس جديد
- `GET /admin/tracks/{track}/lessons/{lesson}/edit` - تعديل درس
- `PUT /admin/tracks/{track}/lessons/{lesson}` - تحديث درس
- `DELETE /admin/tracks/{track}/lessons/{lesson}` - حذف درس

### إدارة الاختبارات
- `GET /admin/tracks/{track}/quizzes` - عرض اختبارات المسار
- `GET /admin/tracks/{track}/quizzes/create` - إضافة اختبار جديد
- `POST /admin/tracks/{track}/quizzes` - حفظ اختبار جديد
- `GET /admin/tracks/{track}/quizzes/{quiz}` - عرض أسئلة الاختبار
- `GET /admin/tracks/{track}/quizzes/{quiz}/edit` - تعديل اختبار
- `PUT /admin/tracks/{track}/quizzes/{quiz}` - تحديث اختبار
- `DELETE /admin/tracks/{track}/quizzes/{quiz}` - حذف اختبار

### إدارة أسئلة الاختبارات
- `GET /admin/tracks/{track}/quizzes/{quiz}/questions/create` - إضافة سؤال جديد
- `POST /admin/tracks/{track}/quizzes/{quiz}/questions` - حفظ سؤال جديد
- `GET /admin/tracks/{track}/quizzes/{quiz}/questions/{question}/edit` - تعديل سؤال
- `PUT /admin/tracks/{track}/quizzes/{quiz}/questions/{question}` - تحديث سؤال
- `DELETE /admin/tracks/{track}/quizzes/{quiz}/questions/{question}` - حذف سؤال

### إدارة المختبرات
- `GET /admin/tracks/{track}/labs` - عرض مختبرات المسار
- `GET /admin/tracks/{track}/labs/create` - إضافة مختبر جديد
- `POST /admin/tracks/{track}/labs` - حفظ مختبر جديد
- `GET /admin/tracks/{track}/labs/{lab}/edit` - تعديل مختبر
- `PUT /admin/tracks/{track}/labs/{lab}` - تحديث مختبر
- `DELETE /admin/tracks/{track}/labs/{lab}` - حذف مختبر

### إدارة الصفحات
- `GET /admin/pages` - عرض جميع الصفحات
- `GET /admin/pages/create` - إضافة صفحة جديدة
- `POST /admin/pages` - حفظ صفحة جديدة
- `GET /admin/pages/{page}/edit` - تعديل صفحة
- `PUT /admin/pages/{page}` - تحديث صفحة
- `DELETE /admin/pages/{page}` - حذف صفحة

## الملفات المهمة

### Controllers
- `app/Http/Controllers/AuthController.php` - المصادقة
- `app/Http/Controllers/AdminController.php` - لوحة التحكم الرئيسية
- `app/Http/Controllers/Admin/TrackController.php` - إدارة المسارات
- `app/Http/Controllers/Admin/LessonController.php` - إدارة الدروس
- `app/Http/Controllers/Admin/QuizController.php` - إدارة الاختبارات والأسئلة
- `app/Http/Controllers/Admin/LabController.php` - إدارة المختبرات
- `app/Http/Controllers/Admin/PageController.php` - إدارة الصفحات

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - التحقق من صلاحيات الإدمن

### Views
- `resources/views/admin/layout.blade.php` - Layout الرئيسي للوحة التحكم
- `resources/views/admin/dashboard.blade.php` - لوحة التحكم الرئيسية
- `resources/views/admin/tracks/*` - صفحات إدارة المسارات
- `resources/views/admin/lessons/*` - صفحات إدارة الدروس
- `resources/views/admin/quizzes/*` - صفحات إدارة الاختبارات والأسئلة
- `resources/views/admin/labs/*` - صفحات إدارة المختبرات
- `resources/views/admin/pages/*` - صفحات إدارة الصفحات
- `resources/views/auth/login.blade.php` - صفحة تسجيل الدخول

### Migrations
- `database/migrations/2025_01_20_000000_add_is_admin_to_users_table.php` - إضافة حقل is_admin

### Seeders
- `database/seeders/AdminUserSeeder.php` - إنشاء مستخدم إدمن

## الأمان

- جميع صفحات الإدمن محمية بـ `AdminMiddleware`
- فقط المستخدمون الذين لديهم `is_admin = true` يمكنهم الوصول
- جلسات آمنة مع Laravel Session

## ملاحظات

- جميع الواجهات باللغة العربية (RTL)
- تصميم متجاوب وحديث
- رسائل نجاح/خطأ واضحة
- تأكيد قبل الحذف

## الخطوات التالية (اقتراحات)

1. إضافة نظام الصلاحيات المتقدمة (Roles & Permissions)
2. إضافة سجل للأنشطة (Activity Log)
3. إضافة إحصائيات متقدمة
4. إضافة تصدير البيانات
5. إضافة محرر WYSIWYG للمحتوى
6. إضافة رفع الملفات والصور

