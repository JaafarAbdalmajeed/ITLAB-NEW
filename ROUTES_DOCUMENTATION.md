# توثيق المسارات والاتصالات - ITLAB

## ✅ نعم، كل شيء مرتبط من خلال Routes

هذا الملف يوضح جميع الاتصالات والروابط في المشروع.

---

## 📋 1. Routes الأساسية (routes/web.php)

### الصفحة الرئيسية
- ✅ `GET /` → `HomeController@index` → `home.index`

### صفحات المحتوى (PagesController)
- ✅ `GET /html` → `PagesController@html`
- ✅ `GET /css` → `PagesController@css`
- ✅ `GET /js` → `PagesController@js`
- ✅ `GET /cyber-network` → `CyberController@network`
- ✅ `GET /cyber-web` → `CyberController@web`
- ✅ جميع الصفحات الثابتة (about, contact, blog, etc.)

### المسارات التعليمية (Resource Routes)
- ✅ `GET /tracks` → `TrackController@index`
- ✅ `POST /tracks` → `TrackController@store`
- ✅ `GET /tracks/{track}` → `TrackController@show`
- ✅ `PUT /tracks/{track}` → `TrackController@update`
- ✅ `DELETE /tracks/{track}` → `TrackController@destroy`

### الدروس (Nested Resource)
- ✅ `GET /tracks/{track}/lessons` → `LessonController@index`
- ✅ `POST /tracks/{track}/lessons` → `LessonController@store`
- ✅ `GET /tracks/{track}/lessons/{lesson}` → `LessonController@show`
- ✅ `PUT /tracks/{track}/lessons/{lesson}` → `LessonController@update`
- ✅ `DELETE /tracks/{track}/lessons/{lesson}` → `LessonController@destroy`

### الاختبارات (Nested Resource)
- ✅ `GET /tracks/{track}/quizzes` → `QuizController@index`
- ✅ `POST /tracks/{track}/quizzes` → `QuizController@store`
- ✅ `GET /tracks/{track}/quizzes/{quiz}` → `QuizController@show`
- ✅ `PUT /tracks/{track}/quizzes/{quiz}` → `QuizController@update`
- ✅ `DELETE /tracks/{track}/quizzes/{quiz}` → `QuizController@destroy`

### المختبرات (Nested Resource)
- ✅ `GET /tracks/{track}/labs` → `LabController@index`
- ✅ `POST /tracks/{track}/labs` → `LabController@store`
- ✅ `GET /tracks/{track}/labs/{lab}` → `LabController@show`
- ✅ `PUT /tracks/{track}/labs/{lab}` → `LabController@update`
- ✅ `DELETE /tracks/{track}/labs/{lab}` → `LabController@destroy`

### نتائج الاختبارات (مع Rate Limiting)
- ✅ `POST /tracks/{track}/quizzes/{quiz}/results` → `QuizResultController@store`
  - ✅ يستخدم `StoreQuizResultRequest` للتحقق
  - ✅ يستخدم `QuizService` للمنطق
  - ✅ يطلق `QuizSubmitted` Event
- ✅ `GET /tracks/{track}/quizzes/{quiz}/results` → `QuizResultController@index`

### تقدم المستخدم (مع Rate Limiting)
- ✅ `POST /tracks/{track}/progress` → `UserProgressController@update`
  - ✅ يستخدم `UpdateUserProgressRequest` للتحقق
  - ✅ يستخدم `ProgressService` للمنطق
- ✅ `GET /tracks/{track}/progress` → `UserProgressController@show`
- ✅ `GET /progress/overall` → `UserProgressController@overall`

### المصادقة (Authentication)
- ✅ `GET /login` → `AuthController@showLogin`
- ✅ `POST /login` → `AuthController@login`
- ✅ `GET /register` → `AuthController@showRegister`
- ✅ `POST /register` → `AuthController@register`
- ✅ `POST /logout` → `AuthController@logout`

---

## 🔐 2. Routes الإدمن (routes/web.php - Admin Section)

جميع Routes الإدمن محمية بـ `admin` middleware

### لوحة التحكم
- ✅ `GET /admin/dashboard` → `AdminController@dashboard`
  - ✅ يستخدم Caching للإحصائيات

### إدارة المسارات (Admin)
- ✅ `GET /admin/tracks` → `Admin\TrackController@index`
- ✅ `GET /admin/tracks/create` → `Admin\TrackController@create`
- ✅ `POST /admin/tracks` → `Admin\TrackController@store`
- ✅ `GET /admin/tracks/{track}/edit` → `Admin\TrackController@edit`
- ✅ `PUT /admin/tracks/{track}` → `Admin\TrackController@update`
- ✅ `DELETE /admin/tracks/{track}` → `Admin\TrackController@destroy`

### إدارة الدروس (Admin)
- ✅ `GET /admin/tracks/{track}/lessons` → `Admin\LessonController@index`
- ✅ `GET /admin/tracks/{track}/lessons/create` → `Admin\LessonController@create`
- ✅ `POST /admin/tracks/{track}/lessons` → `Admin\LessonController@store`
- ✅ `GET /admin/tracks/{track}/lessons/{lesson}/edit` → `Admin\LessonController@edit`
- ✅ `PUT /admin/tracks/{track}/lessons/{lesson}` → `Admin\LessonController@update`
- ✅ `DELETE /admin/tracks/{track}/lessons/{lesson}` → `Admin\LessonController@destroy`

### إدارة الاختبارات (Admin)
- ✅ `GET /admin/tracks/{track}/quizzes` → `Admin\QuizController@index`
- ✅ `GET /admin/tracks/{track}/quizzes/create` → `Admin\QuizController@create`
- ✅ `POST /admin/tracks/{track}/quizzes` → `Admin\QuizController@store`
- ✅ `GET /admin/tracks/{track}/quizzes/{quiz}` → `Admin\QuizController@show`
- ✅ `GET /admin/tracks/{track}/quizzes/{quiz}/edit` → `Admin\QuizController@edit`
- ✅ `PUT /admin/tracks/{track}/quizzes/{quiz}` → `Admin\QuizController@update`
- ✅ `DELETE /admin/tracks/{track}/quizzes/{quiz}` → `Admin\QuizController@destroy`

### إدارة أسئلة الاختبارات (Admin)
- ✅ `GET /admin/tracks/{track}/quizzes/{quiz}/questions/create` → `Admin\QuizController@createQuestion`
- ✅ `POST /admin/tracks/{track}/quizzes/{quiz}/questions` → `Admin\QuizController@storeQuestion`
- ✅ `GET /admin/tracks/{track}/quizzes/{quiz}/questions/{question}/edit` → `Admin\QuizController@editQuestion`
- ✅ `PUT /admin/tracks/{track}/quizzes/{quiz}/questions/{question}` → `Admin\QuizController@updateQuestion`
- ✅ `DELETE /admin/tracks/{track}/quizzes/{quiz}/questions/{question}` → `Admin\QuizController@destroyQuestion`

### إدارة المختبرات (Admin)
- ✅ `GET /admin/tracks/{track}/labs` → `Admin\LabController@index`
- ✅ `GET /admin/tracks/{track}/labs/create` → `Admin\LabController@create`
- ✅ `POST /admin/tracks/{track}/labs` → `Admin\LabController@store`
- ✅ `GET /admin/tracks/{track}/labs/{lab}/edit` → `Admin\LabController@edit`
- ✅ `PUT /admin/tracks/{track}/labs/{lab}` → `Admin\LabController@update`
- ✅ `DELETE /admin/tracks/{track}/labs/{lab}` → `Admin\LabController@destroy`

### إدارة الصفحات (Admin)
- ✅ `GET /admin/pages` → `Admin\PageController@index`
- ✅ `GET /admin/pages/create` → `Admin\PageController@create`
- ✅ `POST /admin/pages` → `Admin\PageController@store`
- ✅ `GET /admin/pages/{page}/edit` → `Admin\PageController@edit`
- ✅ `PUT /admin/pages/{page}` → `Admin\PageController@update`
- ✅ `DELETE /admin/pages/{page}` → `Admin\PageController@destroy`

---

## 🌐 3. API Routes (routes/api.php)

جميع Routes محمية بـ `throttle:api` middleware

### Routes عامة (Public)
- ✅ `GET /api/tracks` → Closure (يعيد TrackResource collection)
- ✅ `GET /api/tracks/{track}` → Closure (يعيد TrackResource)

### Routes محمية (Protected - auth:sanctum)
- ✅ `GET /api/user` → Closure (يعيد المستخدم الحالي)
- ✅ `GET /api/tracks/{track}/quizzes/{quiz}/results` → `QuizResultController@index`
- ✅ `POST /api/tracks/{track}/quizzes/{quiz}/results` → `QuizResultController@store`
- ✅ `GET /api/tracks/{track}/progress` → `UserProgressController@show`
- ✅ `POST /api/tracks/{track}/progress` → `UserProgressController@update`
- ✅ `GET /api/progress/overall` → `UserProgressController@overall`

---

## 🔗 4. الاتصالات والاعتمادات (Dependencies)

### Controllers → Services
- ✅ `QuizResultController` → `QuizService`
- ✅ `UserProgressController` → `ProgressService`

### Controllers → Form Requests
- ✅ `QuizResultController@store` → `StoreQuizResultRequest`
- ✅ `UserProgressController@update` → `UpdateUserProgressRequest`

### Services → Events
- ✅ `QuizService@submitQuiz` → يطلق `QuizSubmitted` Event
- ✅ `ProgressService@markTrackCompleted` → يطلق `TrackCompleted` Event

### Events → Listeners
- ✅ `QuizSubmitted` → `SendQuizCompletionNotification`
- ✅ `TrackCompleted` → `SendTrackCompletionNotification`
- ✅ مسجلة في `AppServiceProvider`

### Controllers → Policies
- ✅ `TrackPolicy` مسجل في `AppServiceProvider`
- ✅ `QuizPolicy` مسجل في `AppServiceProvider`

### Controllers → Resources (API)
- ✅ API Routes تستخدم `TrackResource`, `QuizResource`, etc.

---

## 🛡️ 5. Middleware والتحقق

### Middleware المستخدمة
- ✅ `admin` → `AdminMiddleware` (لصفحات الإدمن)
- ✅ `throttle:quiz-submissions` → Rate Limiting للاختبارات
- ✅ `throttle:progress-updates` → Rate Limiting للتقدم
- ✅ `throttle:api` → Rate Limiting للـ API
- ✅ `auth:sanctum` → للمصادقة في API

### Rate Limiters (في AppServiceProvider)
- ✅ `quiz-submissions`: 5 محاولات/دقيقة
- ✅ `progress-updates`: 10 تحديثات/دقيقة
- ✅ `api`: 60 طلب/دقيقة

---

## 📊 6. Caching

- ✅ `AdminController@dashboard` → يستخدم Cache للإحصائيات (5 دقائق)

---

## ✅ الخلاصة

**نعم، كل شيء مرتبط بشكل كامل:**

1. ✅ جميع Controllers مرتبطة في Routes
2. ✅ جميع Services مرتبطة في Controllers
3. ✅ جميع Events مرتبطة في Services
4. ✅ جميع Listeners مرتبطة في AppServiceProvider
5. ✅ جميع Policies مسجلة في AppServiceProvider
6. ✅ جميع Form Requests مستخدمة في Controllers
7. ✅ جميع API Resources مستخدمة في API Routes
8. ✅ جميع Middleware مسجلة في bootstrap/app.php
9. ✅ Rate Limiters مسجلة في AppServiceProvider
10. ✅ Caching مستخدم في AdminController

**المشروع متكامل 100% من ناحية Routes والاتصالات!** 🎉

