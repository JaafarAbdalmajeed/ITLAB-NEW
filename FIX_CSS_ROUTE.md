# إصلاح مشكلة Route CSS

## المشكلة
صفحة `/css` تعطي "Not Found" أو 404.

## الحلول الممكنة

### 1. امسح Route Cache
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 2. تحقق من Routes
```bash
php artisan route:list | grep css
```

يجب أن ترى:
```
GET|HEAD  css ................ pages.css › PagesController@css
```

### 3. تحقق من قاعدة البيانات
افتح `tinker`:
```bash
php artisan tinker
```

ثم:
```php
\App\Models\Track::where('slug', 'css')->first();
```

إذا كان `null`، Track غير موجود وسيتم إنشاؤه تلقائياً.

### 4. تحقق من View
تأكد من وجود الملف:
```
resources/views/pages/track-main.blade.php
```

### 5. تحقق من Logs
```bash
tail -f storage/logs/laravel.log
```

ثم افتح `/css` في المتصفح وراقب الأخطاء.

### 6. إعادة تشغيل Laravel
إذا كنت تستخدم `php artisan serve`:
- أوقف السيرفر (Ctrl+C)
- أعد تشغيله: `php artisan serve`

### 7. إنشاء Track يدوياً
إذا استمرت المشكلة:

1. اذهب إلى `/admin/tracks`
2. اضغط "إضافة مسار جديد"
3. املأ:
   - Slug: `css`
   - Title: `CSS`
   - Description: `Learn CSS for styling web pages`
4. احفظ

## الحل السريع

```bash
# امسح جميع الـ Cache
php artisan optimize:clear

# تأكد من Migrations
php artisan migrate

# أعد تشغيل السيرفر
php artisan serve
```

ثم افتح `http://127.0.0.1:8000/css` في المتصفح.

---

**إذا استمرت المشكلة، راجع ملف `storage/logs/laravel.log` للأخطاء التفصيلية.**

