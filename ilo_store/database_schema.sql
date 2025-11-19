ilo_store-- مخطط قاعدة بيانات متجر إيلوفان (Ilovan) للعطور

-- 1. جدول المنتجات (Products)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category ENUM('رجالي', 'نسائي', 'للجنسين') NOT NULL,
    scent_type VARCHAR(100), -- نوع الرائحة (مثل: خشبي، زهري، شرقي)
    brand VARCHAR(100),
    size VARCHAR(50), -- حجم العبوة (مثل: 50ml, 100ml)
    stock_quantity INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE, -- منتج مميز للعرض في الصفحة الرئيسية
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. جدول المقالات (Articles/Blog)
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    category ENUM('نصائح', 'مراجعات', 'تاريخ العطور', 'أخبار عالمية') NOT NULL,
    author VARCHAR(100),
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE, -- مقال مختار للعرض في الصفحة الرئيسية
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. جدول المستخدمين (Users)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL, -- لتخزين كلمة المرور مشفرة
    full_name VARCHAR(100),
    phone_number VARCHAR(20),
    address TEXT,
    is_admin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. جدول الطلبات (Orders)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    status ENUM('قيد الانتظار', 'قيد التجهيز', 'تم الشحن', 'تم التوصيل', 'ملغاة') NOT NULL DEFAULT 'قيد الانتظار',
    shipping_address TEXT NOT NULL,
    payment_method ENUM('بطاقة', 'باي بال', 'دفع عند الاستلام') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 5. جدول تفاصيل الطلب (Order_Items)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price_at_purchase DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 6. جدول التقييمات والتعليقات (Reviews)
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    user_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 7. جدول سلة التسوق (Cart - لتخزين سلة المستخدمين غير المسجلين أو كآلية مؤقتة)
-- في هذا المشروع، سنستخدم جلسات PHP (Sessions) للسلة، ولكن هذا الجدول يمكن أن يكون مفيداً للمستخدمين المسجلين.
-- لتبسيط المشروع، سنعتمد على جلسات PHP للواجهة الأمامية.

-- بيانات تجريبية (اختياري، ولكن مفيد للاختبار)

INSERT INTO products (name, description, price, category, scent_type, brand, size, stock_quantity, image_url, is_featured) VALUES
('عطر إيلوفان الذهبي', 'عطر فاخر برائحة شرقية خشبية، مثالي للمناسبات المسائية.', 450.00, 'رجالي', 'شرقي', 'إيلوفان', '100ml', 50, 'images/p1.jpg', TRUE),
('عطر الورد الأبيض', 'عطر نسائي رقيق برائحة الورد والياسمين، منعش للاستخدام اليومي.', 320.00, 'نسائي', 'زهري', 'فلورا', '50ml', 75, 'images/p2.jpg', TRUE),
('عطر المسك النقي', 'عطر للجنسين برائحة المسك النظيفة والهادئة.', 280.00, 'للجنسين', 'مسك', 'سنتس', '75ml', 60, 'images/p3.jpg', FALSE);

INSERT INTO articles (title, content, category, author, image_url, is_featured) VALUES
('أفضل العطور الصيفية لعام 2024', 'مراجعة لأحدث العطور التي تناسب الأجواء الحارة والرطبة...', 'مراجعات', 'أحمد', 'images/a1.jpg', TRUE),
('كيف تختار عطرك المثالي؟', 'نصائح عملية لمساعدتك في اختيار العطر الذي يعكس شخصيتك...', 'نصائح', 'فاطمة', 'images/a2.jpg', TRUE);
