// ملف script.js - وظائف الواجهة الأمامية لمتجر إيلوفان

document.addEventListener('DOMContentLoaded', function() {
    // معالجة النقر على زر "أضف للسلة"
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-product-id');
            
            // إرسال طلب POST إلى cart_action.php لإضافة المنتج
            fetch('cart_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&product_id=${productId}&quantity=1`
            })
            .then(response => {
                // لتبسيط المشروع، سنعيد تحميل الصفحة أو تحديث عداد السلة
                // في مشروع حقيقي، يجب استخدام JSON للرد وتحديث الواجهة بدون إعادة تحميل
                alert('تمت إضافة المنتج إلى السلة!');
                window.location.reload(); 
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                alert('حدث خطأ أثناء إضافة المنتج إلى السلة.');
            });
        });
    });

    // يمكن إضافة المزيد من وظائف JavaScript هنا، مثل:
    // - التحقق من صحة النماذج (Form Validation)
    // - تأثيرات التكبير على صور المنتجات
    // - وظيفة التصفية والترتيب المتقدمة (إذا لم يتم تنفيذها بالكامل في PHP)
});
