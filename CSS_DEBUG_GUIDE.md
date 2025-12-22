# دليل تصحيح مشكلة صفحة CSS

## المشكلة
صفحة `http://127.0.0.1:8000/css` لا تعمل.

## خطوات التصحيح

### 1. تحقق من Routes
```bash
php artisan route:list | grep css
```

يجب أن ترى:
```
GET|HEAD  css ................ pages.css › PagesController@css
```

### 2. تحقق من قاعدة البيانات
افتح `tinker`:
```bash
php artisan tinker
```

ثم:
```php
\App\Models\Track::where('slug', 'css')->first();
```

إذا كان `null`، Track غير موجود.

### 3. تحقق من Migrations
```bash
php artisan migrate:status
```

تأكد من أن جميع Migrations تم تشغيلها.

### 4. تحقق من Logs
```bash
tail -f storage/logs/laravel.log
```

ثم افتح `/css` في المتصفح وراقب الأخطاء.

### 5. امسح Cache
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 6. تحقق من View
تأكد من وجود الملف:
```
resources/views/pages/track-main.blade.php
```

### 7. إنشاء Track يدوياً
إذا استمرت المشكلة، أنشئ Track يدوياً:

1. اذهب إلى `/admin/tracks`
2. اضغط "إضافة مسار جديد"
3. املأ:
   - Slug: `css`
   - Title: `CSS`
   - Description: `Learn CSS for styling web pages`
4. احفظ

### 8. اختبار مباشر
افتح `tinker`:
```bash
php artisan tinker
```

ثم:
```php
$controller = new \App\Http\Controllers\PagesController();
$controller->css();
```

إذا كان هناك خطأ، ستراه هنا.

## الحل السريع

إذا كنت تريد حل سريع:

1. **امسح جميع الـ Cache:**
```bash
php artisan optimize:clear
```

2. **شغّل Migrations:**
```bash
php artisan migrate
```

3. **أنشئ Track يدوياً من لوحة التحكم:**
- اذهب إلى `/admin/tracks`
- أنشئ Track جديد بـ slug: `css`

4. **اختبر الصفحة:**
- افتح `http://127.0.0.1:8000/css`

---

**إذا استمرت المشكلة، راجع ملف `storage/logs/laravel.log` للأخطاء التفصيلية.**

