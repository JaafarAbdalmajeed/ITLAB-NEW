@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* حاوية المربعات الـ 12 */
    .examples-grid-container {
        display: flex;
        flex-direction: column;
        gap: 35px;
        margin-bottom: 60px;
    }

    /* تصميم المربع الكبير */
    .mega-example-card {
        background: #1a1a1a;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #333;
        width: 100%;
    }

    .card-header-main {
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.03);
    }

    .card-header-main h3 { margin: 0; font-size: 1.5rem; font-weight: bold; }

    /* تنسيق الأمثلة الثلاثة داخل المربع */
    .sub-examples-list {
        display: flex;
        flex-direction: column;
    }

    .single-example-row {
        display: flex;
        border-top: 1px solid #222;
        min-height: 100px;
    }

    .code-part {
        flex: 1;
        background: #000;
        padding: 20px;
        direction: ltr;
        text-align: left;
        display: flex;
        align-items: center;
        position: relative;
    }

    .info-part {
        width: 350px;
        padding: 20px;
        background: #1e1e1e;
        border-right: 1px solid #222;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: right;
    }

    .info-part h6 { color: #fff; margin-bottom: 5px; font-weight: bold; }
    .info-part p { color: #888; margin: 0; font-size: 0.9rem; }

    code { font-family: 'Consolas', monospace; color: #00ffaa; font-size: 1rem; }
    
    .copy-row-btn {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #333;
        color: #ddd;
        border: none;
        padding: 3px 10px;
        border-radius: 5px;
        font-size: 10px;
        cursor: pointer;
    }

    .copy-row-btn:hover { background: #444; color: #fff; }
</style>
@endpush

<main class="main-content">
    @if($track->slug == 'html')
    <h1 class="text-center mb-5" style="color: #444;"> example of HTML on the ITLAB platform</h1>

    <div class="examples-grid-container" dir="rtl">
        @php
            $colors = ['#00ffaa', '#0f404eff', '#ff5252', '#ffeb3b', '#e040fb', '#ff9100', '#4db6ac', '#81c784', '#d4e157', '#ffd54f', '#ff8a65', '#a1887f'];
            
            $allCards = [
                ['t' => '1. أساسيات الهيكل والصفحة', 'exs' => [
                    ['n' => 'تعريف الصفحة', 'd' => 'يخبر المتصفح أن هذا ملف HTML5.', 'c' => '<!DOCTYPE html>'],
                    ['n' => 'وسم الجذر', 'd' => 'الحاوية الأساسية لكل كود الصفحة.', 'c' => '<html> ... </html>'],
                    ['n' => 'رأس الصفحة', 'd' => 'يحتوي على العنوان والبيانات الوصفية.', 'c' => '<head> ... </head>']
                ]],
                ['t' => '2. العناوين والنصوص الرئيسية', 'exs' => [
                    ['n' => 'العنوان الأكبر', 'd' => 'يستخدم لعنوان الموضوع الرئيسي.', 'c' => '<h1>عنوان رئيسي</h1>'],
                    ['n' => 'العنوان المتوسط', 'd' => 'يستخدم لعناوين الأقسام.', 'c' => '<h3>عنوان قسم</h3>'],
                    ['n' => 'العنوان الأصغر', 'd' => 'يستخدم للعناوين الجانبية.', 'c' => '<h6>عنوان جانبي</h6>']
                ]],
                ['t' => '3. الفقرات وتنسيق المحتوى', 'exs' => [
                    ['n' => 'الفقرة النصية', 'd' => 'لكتابة النصوص والقطع الكتابية.', 'c' => '<p>هذا نص فقرة</p>'],
                    ['n' => 'نص عريض', 'd' => 'لإبراز الكلمات الهامة جداً.', 'c' => '<strong>نص مهم</strong>'],
                    ['n' => 'تمييز نص', 'd' => 'لتلوين خلفية نص محدد.', 'c' => '<mark>نص محدد</mark>']
                ]],
                ['t' => '4. الروابط التفاعلية', 'exs' => [
                    ['n' => 'رابط خارجي', 'd' => 'ينقل المستخدم لموقع آخر.', 'c' => '<a href="https://google.com">جوجل</a>'],
                    ['n' => 'فتح في نافذة جديدة', 'd' => 'لإبقاء موقعك مفتوحاً.', 'c' => '<a href="#" target="_blank">رابط</a>'],
                    ['n' => 'رابط بريد', 'd' => 'للمراسلة الفورية.', 'c' => '<a href="mailto:a@it.com">بريدنا</a>']
                ]],
                ['t' => '5. الصور والرسومات', 'exs' => [
                    ['n' => 'إدراج صورة', 'd' => 'عرض صورة من مسار محدد.', 'c' => '<img src="pic.jpg" alt="Logo">'],
                    ['n' => 'صورة قابلة للضغط', 'd' => 'استخدام الصورة كرابط.', 'c' => '<a href="#"><img src="btn.png"></a>'],
                    ['n' => 'أبعاد الصورة', 'd' => 'تحديد الطول والعرض يدوياً.', 'c' => '<img src="i.jpg" width="100" height="100">']
                ]],
                ['t' => '6. القوائم المنظمة', 'exs' => [
                    ['n' => 'قائمة منقطة', 'd' => 'عرض عناصر بدون ترتيب.', 'c' => '<ul><li>عنصر</li></ul>'],
                    ['n' => 'قائمة مرقمة', 'd' => 'عرض عناصر مرقمة تلقائياً.', 'c' => '<ol><li>الأول</li></ol>'],
                    ['n' => 'قائمة متداخلة', 'd' => 'قائمة داخل قائمة أخرى.', 'c' => '<ul><li>1<ul><li>2</li></ul></li></ul>']
                ]],
                ['t' => '7. الجداول والبيانات', 'exs' => [
                    ['n' => 'جدول بسيط', 'd' => 'عرض بيانات في صفوف.', 'c' => '<table><tr><td>داتا</td></tr></table>'],
                    ['n' => 'عنوان الجدول', 'd' => 'وضع وصف أعلى الجدول.', 'c' => '<caption>جدول المبيعات</caption>'],
                    ['n' => 'رأس العمود', 'd' => 'تمييز العناوين داخل الجدول.', 'c' => '<th>الاسم</th>']
                ]],
                ['t' => '8. حقول الإدخال الأساسية', 'exs' => [
                    ['n' => 'حقل نصي', 'd' => 'لإدخال الاسم أو النصوص.', 'c' => '<input type="text" placeholder="الاسم">'],
                    ['n' => 'حقل كلمة السر', 'd' => 'يخفي الحروف عند الكتابة.', 'c' => '<input type="password">'],
                    ['n' => 'حقل البريد', 'd' => 'يتحقق من صيغة الإيميل.', 'c' => '<input type="email">']
                ]],
                ['t' => '9. أدوات الاختيار', 'exs' => [
                    ['n' => 'مربع اختيار', 'd' => 'لاختيار عدة خيارات.', 'c' => '<input type="checkbox">'],
                    ['n' => 'زر الراديو', 'd' => 'لاختيار خيار واحد فقط.', 'c' => '<input type="radio" name="g">'],
                    ['n' => 'قائمة منسدلة', 'd' => 'لاختيار من مجموعة خيارات.', 'c' => '<select><option>خيار</option></select>']
                ]],
                ['t' => '10. الأزرار والتفاعل', 'exs' => [
                    ['n' => 'زر إرسال', 'd' => 'لإرسال بيانات النموذج.', 'c' => '<button type="submit">إرسال</button>'],
                    ['n' => 'زر إعادة تعيين', 'd' => 'لمسح كل الحقول.', 'c' => '<input type="reset" value="مسح">'],
                    ['n' => 'زر مخصص', 'd' => 'لتنفيذ أكواد JavaScript.', 'c' => '<button type="button">اضغط</button>']
                ]],
                ['t' => '11. حاويات التقسيم (CSS Preparation)', 'exs' => [
                    ['n' => 'الحاوية الكبرى', 'd' => 'لتقسيم الصفحة لمربعات.', 'c' => '<div class="box">محتوى</div>'],
                    ['n' => 'حاوية نصية', 'd' => 'لتنسيق جزء من النص.', 'c' => '<span>نص ملون</span>'],
                    ['n' => 'شريط التنقل', 'd' => 'يحتوي على روابط القائمة.', 'c' => '<nav> روابط </nav>']
                ]],
                ['t' => '12. الوسائط المتقدمة', 'exs' => [
                    ['n' => 'مشغل الفيديو', 'd' => 'تشغيل فيديوهات MP4.', 'c' => '<video controls src="v.mp4"></video>'],
                    ['n' => 'مشغل الصوت', 'd' => 'تشغيل ملفات MP3.', 'c' => '<audio controls src="a.mp3"></audio>'],
                    ['n' => 'تضمين خارجي', 'd' => 'عرض صفحة أخرى داخل صفحتك.', 'c' => '<iframe src="page.html"></iframe>']
                ]]
            ];
        @endphp

        @foreach($allCards as $index => $card)
        <div class="mega-example-card shadow-lg" style="border-right: 15px solid {{ $colors[$index] }};">
            <div class="card-header-main">
                <h3 style="color: {{ $colors[$index] }};">{{ $card['t'] }}</h3>
                <span style="color: #666; font-size: 12px;">مربع تعليمي #{{ $index + 1 }}</span>
            </div>
            <div class="sub-examples-list">
                @foreach($card['exs'] as $ex)
                <div class="single-example-row">
                    {{-- الكود --}}
                    <div class="code-part">
                        <button class="copy-row-btn" onclick="copySnippet(this)">نسخ</button>
                        <code>{{ $ex['c'] }}</code>
                    </div>
                    {{-- الشرح --}}
                    <div class="info-part">
                        <h6>{{ $ex['n'] }}</h6>
                        <p>{{ $ex['d'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</main>



@push('scripts')
<script>
    function copySnippet(btn) {
        const code = btn.nextElementSibling.innerText;
        navigator.clipboard.writeText(code);
        btn.innerText = '✅';
        setTimeout(() => btn.innerText = 'نسخ', 1500);
    }
</script>
@endpush
@endsection