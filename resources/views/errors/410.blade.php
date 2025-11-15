<x-website.layout title="410 | Page Gone">
    <section class="py-5" style="min-height:60vh; display:flex; align-items:center;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div style="font-size:90px; line-height:1; font-weight:700; color:#dc3545;">410</div>
                    <h1 class="mt-3">هذه الصفحة غير متاحة</h1>
                    <p class="text-muted mb-4">الصفحة التي تحاول الوصول إليها تم إزالتها نهائياً أو لم تعد متاحة.</p>

                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ url('/') }}" class="btn btn-primary">
                            الرجوع للصفحة الرئيسية
                        </a>
                        <a href="{{ route('website.contact-us') }}" class="btn btn-outline-secondary">
                            تواصل معنا
                        </a>
                    </div>

                    <div class="mt-4 small text-muted">
                        إذا وصلت إلى هذه الصفحة عبر رابط قديم، فقد تم نقل المحتوى إلى مكان آخر.
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-website.layout>