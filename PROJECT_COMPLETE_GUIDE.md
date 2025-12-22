# دليل المشروع الكامل - ITLAB

## 📖 نظرة عامة

**ITLAB** هو منصة تعليمية متكاملة مبنيّة على Laravel 12 لتعلّم البرمجة والأمن السيبراني. المشروع يوفر نظام تعليمي ديناميكي مع لوحة تحكم كاملة للإدمن لإدارة جميع المحتويات.

---

## 🎯 الهدف من المشروع

منصة تعليمية تسمح للمستخدمين بتعلّم:
- **البرمجة**: HTML, CSS, JavaScript
- **الأمن السيبراني**: Network Security, Web Application Security

مع إمكانية:
- متابعة الدروس
- حل الاختبارات
- تنفيذ المختبرات العملية
- تتبع التقدم

---

## 🏗️ البنية المعمارية (Architecture)

### 1. **MVC Pattern**
المشروع يتبع نمط MVC (Model-View-Controller):

```
app/
├── Models/          # النماذج (Database Models)
├── Views/           # الواجهات (Blade Templates)
└── Http/
    └── Controllers/ # المتحكمات (Business Logic)
```

### 2. **Layered Architecture**
- **Controllers**: معالجة الطلبات
- **Services**: منطق العمل (Business Logic)
- **Repositories**: الوصول للبيانات (Models)
- **Form Requests**: التحقق من البيانات
- **Resources**: تحويل البيانات للـ API

---

## 📁 هيكل المشروع

```
ITLAB/
├── app/
│   ├── Events/              # الأحداث (QuizSubmitted, TrackCompleted)
│   ├── Exceptions/          # معالجة الأخطاء
│   ├── Http/
│   │   ├── Controllers/     # المتحكمات
│   │   │   ├── Admin/       # متحكمات الإدمن
│   │   │   └── ...         # متحكمات المستخدمين
│   │   ├── Middleware/      # Middleware (AdminMiddleware)
│   │   ├── Requests/        # Form Requests (التحقق)
│   │   └── Resources/       # API Resources
│   ├── Listeners/           # المستمعين للأحداث
│   ├── Models/              # النماذج
│   ├── Policies/            # الصلاحيات
│   ├── Providers/           # Service Providers
│   └── Services/            # Services (Business Logic)
├── bootstrap/
│   └── app.php             # إعدادات Laravel
├── config/                  # ملفات الإعدادات
├── database/
│   ├── migrations/         # Migrations
│   ├── seeders/           # Seeders
│   └── factories/         # Factories
├── public/                 # الملفات العامة
├── resources/
│   └── views/              # Blade Templates
│       ├── admin/          # واجهات الإدمن
│       ├── auth/           # واجهات المصادقة
│       ├── layouts/        # Layouts
│       └── ...             # واجهات المستخدمين
├── routes/
│   ├── web.php            # Routes الويب
│   └── api.php            # Routes API
└── storage/               # التخزين
```

---

## 🗄️ قاعدة البيانات (Database Structure)

### الجداول الرئيسية:

#### 1. **users**
```sql
- id
- name
- email
- password
- is_admin (boolean)  # للتحقق من صلاحيات الإدمن
- email_verified_at
- remember_token
- timestamps
```

#### 2. **tracks** (المسارات التعليمية)
```sql
- id
- slug (unique)        # html, css, js, cyber-network, etc.
- title
- description
- timestamps
```

#### 3. **lessons** (الدروس)
```sql
- id
- track_id (foreign)
- title
- content (longText)
- order (integer)     # ترتيب الدرس
- timestamps
```

#### 4. **quizzes** (الاختبارات)
```sql
- id
- track_id (foreign)
- title
- timestamps
```

#### 5. **quiz_questions** (أسئلة الاختبارات)
```sql
- id
- quiz_id (foreign)
- question
- option_a
- option_b
- option_c
- correct_answer (char: a, b, c)
- timestamps
```

#### 6. **quiz_results** (نتائج الاختبارات)
```sql
- id
- user_id (foreign)
- quiz_id (foreign)
- score (integer)     # النسبة المئوية
- timestamps
```

#### 7. **labs** (المختبرات العملية)
```sql
- id
- track_id (foreign)
- title
- scenario (longText)  # السيناريو العملي
- timestamps
```

#### 8. **user_progress** (تقدم المستخدم)
```sql
- id
- user_id (foreign)
- track_id (foreign)
- progress_percent (integer: 0-100)
- timestamps
- unique(user_id, track_id)
```

#### 9. **pages** (الصفحات الثابتة)
```sql
- id
- slug (unique)
- title
- meta_description
- content (longText)
- published (boolean)
- timestamps
```

---

## 🔐 نظام المصادقة والصلاحيات

### 1. **Authentication**
- تسجيل الدخول (`/login`)
- التسجيل (`/register`)
- تسجيل الخروج (`/logout`)
- استخدام Laravel Session

### 2. **Authorization**
- **AdminMiddleware**: للتحقق من صلاحيات الإدمن
- **Policies**: 
  - `TrackPolicy`: صلاحيات المسارات
  - `QuizPolicy`: صلاحيات الاختبارات

### 3. **User Roles**
- **Admin** (`is_admin = true`): وصول كامل
- **User** (`is_admin = false`): وصول محدود

---

## 🎨 الواجهات (Views)

### 1. **Frontend (للمستخدمين)**
- `layouts/app.blade.php`: Layout الرئيسي
- `home/index.blade.php`: الصفحة الرئيسية
- `tracks/*`: صفحات المسارات
- `lessons/*`: صفحات الدروس
- `quizzes/*`: صفحات الاختبارات
- `labs/*`: صفحات المختبرات
- `pages/*`: الصفحات الثابتة

### 2. **Admin Panel (للإدمن)**
- `admin/layout.blade.php`: Layout الإدمن
- `admin/dashboard.blade.php`: لوحة التحكم
- `admin/tracks/*`: إدارة المسارات
- `admin/lessons/*`: إدارة الدروس
- `admin/quizzes/*`: إدارة الاختبارات
- `admin/labs/*`: إدارة المختبرات
- `admin/pages/*`: إدارة الصفحات

### 3. **Authentication**
- `auth/login.blade.php`: تسجيل الدخول

---

## 🛣️ المسارات (Routes)

### 1. **Web Routes** (`routes/web.php`)

#### الصفحة الرئيسية
- `GET /` → Home

#### صفحات المحتوى
- `GET /html`, `/css`, `/js` → صفحات المسارات
- `GET /cyber-network`, `/cyber-web` → صفحات الأمن السيبراني

#### Resource Routes
- `GET /tracks` → عرض جميع المسارات
- `GET /tracks/{track}` → عرض مسار معين
- `GET /tracks/{track}/lessons/{lesson}` → عرض درس
- `GET /tracks/{track}/quizzes/{quiz}` → عرض اختبار

#### Quiz & Progress
- `POST /tracks/{track}/quizzes/{quiz}/results` → تقديم اختبار
- `POST /tracks/{track}/progress` → تحديث التقدم

#### Authentication
- `GET /login` → صفحة تسجيل الدخول
- `POST /login` → معالجة تسجيل الدخول
- `POST /logout` → تسجيل الخروج

#### Admin Routes (محمية)
- `GET /admin/dashboard` → لوحة التحكم
- `GET /admin/tracks` → إدارة المسارات
- `GET /admin/tracks/create` → إضافة مسار
- `PUT /admin/tracks/{track}` → تحديث مسار
- `DELETE /admin/tracks/{track}` → حذف مسار
- ... (جميع عمليات CRUD)

### 2. **API Routes** (`routes/api.php`)

#### Public Routes
- `GET /api/tracks` → جميع المسارات (JSON)
- `GET /api/tracks/{track}` → مسار معين (JSON)

#### Protected Routes (auth:sanctum)
- `GET /api/user` → المستخدم الحالي
- `GET /api/tracks/{track}/quizzes/{quiz}/results` → نتائج الاختبار
- `POST /api/tracks/{track}/quizzes/{quiz}/results` → تقديم اختبار
- `GET /api/tracks/{track}/progress` → تقدم المستخدم
- `POST /api/tracks/{track}/progress` → تحديث التقدم

---

## 🧩 المكونات الرئيسية

### 1. **Controllers**

#### Controllers للمستخدمين:
- `HomeController`: الصفحة الرئيسية
- `TrackController`: إدارة المسارات
- `LessonController`: إدارة الدروس
- `QuizController`: إدارة الاختبارات
- `LabController`: إدارة المختبرات
- `QuizResultController`: نتائج الاختبارات
- `UserProgressController`: تقدم المستخدم
- `PagesController`: الصفحات الثابتة
- `CyberController`: صفحات الأمن السيبراني

#### Controllers للإدمن:
- `AdminController`: لوحة التحكم
- `Admin\TrackController`: إدارة المسارات
- `Admin\LessonController`: إدارة الدروس
- `Admin\QuizController`: إدارة الاختبارات والأسئلة
- `Admin\LabController`: إدارة المختبرات
- `Admin\PageController`: إدارة الصفحات

### 2. **Services** (Business Logic)

#### `QuizService`
```php
- submitQuiz(): تقديم اختبار وحساب النقاط
- getUserBestScore(): أفضل نتيجة للمستخدم
- getQuizStatistics(): إحصائيات الاختبار
```

#### `ProgressService`
```php
- updateProgress(): تحديث تقدم المستخدم
- calculateProgress(): حساب التقدم تلقائياً
- getOverallProgress(): التقدم الإجمالي
- markTrackCompleted(): إكمال مسار
```

### 3. **Form Requests** (التحقق من البيانات)

- `StoreTrackRequest`: التحقق من بيانات المسار
- `UpdateTrackRequest`: التحقق من تحديث المسار
- `StoreQuizResultRequest`: التحقق من نتائج الاختبار
- `UpdateUserProgressRequest`: التحقق من تحديث التقدم

### 4. **Events & Listeners**

#### Events:
- `QuizSubmitted`: عند تقديم اختبار
- `TrackCompleted`: عند إكمال مسار

#### Listeners:
- `SendQuizCompletionNotification`: إشعار إكمال اختبار
- `SendTrackCompletionNotification`: إشعار إكمال مسار

### 5. **Policies** (الصلاحيات)

- `TrackPolicy`: صلاحيات المسارات
- `QuizPolicy`: صلاحيات الاختبارات

### 6. **API Resources**

- `TrackResource`: تحويل Track لـ JSON
- `LessonResource`: تحويل Lesson لـ JSON
- `QuizResource`: تحويل Quiz لـ JSON
- `QuizQuestionResource`: تحويل Question لـ JSON
- `LabResource`: تحويل Lab لـ JSON
- `QuizResultResource`: تحويل Result لـ JSON
- `UserResource`: تحويل User لـ JSON

---

## 🔒 الأمان (Security)

### 1. **Rate Limiting**
- **Quiz Submissions**: 5 محاولات/دقيقة
- **Progress Updates**: 10 تحديثات/دقيقة
- **API**: 60 طلب/دقيقة

### 2. **Middleware**
- `AdminMiddleware`: للتحقق من صلاحيات الإدمن
- `throttle`: لتحديد المعدل

### 3. **Validation**
- Form Requests للتحقق من جميع البيانات
- رسائل خطأ بالعربية

### 4. **Authorization**
- Policies للتحقق من الصلاحيات
- Gate للتحكم في الوصول

---

## ⚡ الأداء (Performance)

### 1. **Caching**
- Cache للإحصائيات في Admin Dashboard (5 دقائق)
- Cache للبيانات المتكررة

### 2. **Eager Loading**
- استخدام `with()` لتحميل العلاقات
- تقليل عدد الاستعلامات

### 3. **Database Indexing**
- Indexes على Foreign Keys
- Unique constraints

---

## 📊 الميزات الرئيسية

### 1. **للمستخدمين**
- ✅ تصفح المسارات التعليمية
- ✅ قراءة الدروس
- ✅ حل الاختبارات
- ✅ تنفيذ المختبرات العملية
- ✅ تتبع التقدم
- ✅ عرض النتائج

### 2. **للإدمن**
- ✅ لوحة تحكم شاملة
- ✅ إدارة المسارات (CRUD)
- ✅ إدارة الدروس (CRUD)
- ✅ إدارة الاختبارات والأسئلة (CRUD)
- ✅ إدارة المختبرات (CRUD)
- ✅ إدارة الصفحات (CRUD)
- ✅ إحصائيات شاملة
- ✅ عرض المستخدمين

---

## 🚀 التثبيت والإعداد

### 1. **متطلبات النظام**
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (أو MySQL/PostgreSQL)

### 2. **خطوات التثبيت**

```bash
# 1. تثبيت Dependencies
composer install
npm install

# 2. إعداد البيئة
cp .env.example .env
php artisan key:generate

# 3. إعداد قاعدة البيانات
php artisan migrate

# 4. تشغيل Seeders
php artisan db:seed

# 5. بناء Assets
npm run build

# 6. تشغيل السيرفر
php artisan serve
```

### 3. **بيانات الدخول للإدمن**
بعد تشغيل Seeders:
- **البريد**: `admin@itlab.com`
- **كلمة المرور**: `admin123`

---

## 📝 الاستخدام

### 1. **للمستخدمين العاديين**
1. زيارة الموقع: `http://localhost:8000`
2. تصفح المسارات
3. قراءة الدروس
4. حل الاختبارات
5. متابعة التقدم

### 2. **للإدمن**
1. تسجيل الدخول: `http://localhost:8000/login`
2. الوصول للوحة التحكم: `http://localhost:8000/admin/dashboard`
3. إدارة المحتويات من القائمة الجانبية

### 3. **للمطورين**
- استخدام API: `http://localhost:8000/api/...`
- المصادقة: استخدام Sanctum tokens
- الوثائق: راجع `ROUTES_DOCUMENTATION.md`

---

## 🔧 التطوير والتوسع

### 1. **إضافة مسار جديد**
```php
// في Admin Panel
1. اذهب إلى /admin/tracks/create
2. أدخل البيانات
3. احفظ
```

### 2. **إضافة درس جديد**
```php
// في Admin Panel
1. اذهب إلى /admin/tracks/{track}/lessons/create
2. أدخل البيانات
3. احفظ
```

### 3. **إضافة اختبار جديد**
```php
// في Admin Panel
1. اذهب إلى /admin/tracks/{track}/quizzes/create
2. أنشئ الاختبار
3. أضف الأسئلة
```

---

## 📚 الملفات التوثيقية

- `README.md`: نظرة عامة
- `ROUTES_DOCUMENTATION.md`: توثيق المسارات
- `ADMIN_DASHBOARD.md`: دليل لوحة التحكم
- `SERVER_SIDE_COMPLETE.md`: دليل السيرفر
- `PROJECT_COMPLETE_GUIDE.md`: هذا الملف

---

## 🎯 الخطوات التالية (اقتراحات)

### تحسينات مستقبلية:
1. ✅ إضافة نظام الإشعارات (Notifications)
2. ✅ إضافة نظام الشهادات (Certificates)
3. ✅ إضافة نظام التعليقات (Comments)
4. ✅ إضافة نظام التقييمات (Ratings)
5. ✅ إضافة نظام الإنجازات (Achievements)
6. ✅ إضافة Real-time updates (WebSockets)
7. ✅ إضافة نظام البحث (Search)
8. ✅ إضافة Export (PDF, Excel)
9. ✅ إضافة Multi-language support
10. ✅ إضافة Mobile App (API)

---

## ✅ الخلاصة

**ITLAB** هو مشروع متكامل وجاهز للإنتاج مع:
- ✅ بنية معمارية محسّنة
- ✅ أمان شامل
- ✅ أداء محسّن
- ✅ واجهة مستخدم جذابة
- ✅ لوحة تحكم كاملة
- ✅ API جاهز
- ✅ توثيق شامل

**المشروع مكتمل 100% وجاهز للاستخدام!** 🎉

---

## 📞 الدعم

للمساعدة أو الاستفسارات:
- راجع الملفات التوثيقية
- راجع الكود المصدري
- راجع Laravel Documentation

---

**تم إنشاء هذا المشروع بـ ❤️ باستخدام Laravel 12**

