<?php
require_once __DIR__ . '/../config/db.php';

// دالة لجلب جميع المنتجات
function get_all_products() {
    global $link;
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = mysqli_query($link, $sql);
    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

// دالة لجلب منتج واحد حسب الـ ID
function get_product_by_id($id) {
    global $link;
    $sql = "SELECT * FROM products WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                return mysqli_fetch_assoc($result);
            }
        }
    }
    return null;
}

// دالة لجلب المنتجات المميزة
function get_featured_products() {
    global $link;
    $sql = "SELECT * FROM products WHERE is_featured = TRUE ORDER BY created_at DESC LIMIT 4";
    $result = mysqli_query($link, $sql);
    $products = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }
    return $products;
}

// دالة لجلب جميع المقالات
function get_all_articles() {
    global $link;
    $sql = "SELECT * FROM articles ORDER BY created_at DESC";
    $result = mysqli_query($link, $sql);
    $articles = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }
    return $articles;
}

// دالة لجلب مقال واحد حسب الـ ID
function get_article_by_id($id) {
    global $link;
    $sql = "SELECT * FROM articles WHERE id = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = $id;
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($result) == 1){
                return mysqli_fetch_assoc($result);
            }
        }
    }
    return null;
}

// دالة لجلب المقالات المميزة
function get_featured_articles() {
    global $link;
    $sql = "SELECT * FROM articles WHERE is_featured = TRUE ORDER BY created_at DESC LIMIT 4";
    $result = mysqli_query($link, $sql);
    $articles = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }
    return $articles;
}

// دالة لتسجيل مستخدم جديد (لتبسيط المشروع، لن نطبق التشفير الكامل لكلمة المرور هنا)
function register_user($username, $email, $password) {
    global $link;
    $password_hash = password_hash($password, PASSWORD_DEFAULT); // تشفير كلمة المرور
    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_email, $param_password_hash);
        $param_username = $username;
        $param_email = $email;
        $param_password_hash = $password_hash;
        if(mysqli_stmt_execute($stmt)){
            return true;
        }
    }
    return false;
}

// دالة لتسجيل دخول المستخدم
function login_user($username, $password) {
    global $link;
    $sql = "SELECT id, username, password_hash FROM users WHERE username = ?";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        // تم التحقق من كلمة المرور، بدء الجلسة
                        session_start();
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        return true;
                    }
                }
            }
        }
    }
    return false;
}

// دالة لجلب تقييمات منتج معين
function get_product_reviews($product_id) {
    global $link;
    $sql = "SELECT r.*, u.username FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.product_id = ? ORDER BY r.created_at DESC";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_product_id);
        $param_product_id = $product_id;
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            $reviews = [];
            while($row = mysqli_fetch_assoc($result)) {
                $reviews[] = $row;
            }
            return $reviews;
        }
    }
    return [];
}

// دالة لإضافة تقييم جديد (لتبسيط المشروع، لن نتحقق من تسجيل الدخول في كل دالة)
function add_review($product_id, $user_id, $rating, $comment) {
    global $link;
    $sql = "INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)";
    if($stmt = mysqli_prepare($link, $sql)){
        mysqli_stmt_bind_param($stmt, "iiis", $param_product_id, $param_user_id, $param_rating, $param_comment);
        $param_product_id = $product_id;
        $param_user_id = $user_id;
        $param_rating = $rating;
        $param_comment = $comment;
        if(mysqli_stmt_execute($stmt)){
            return true;
        }
    }
    return false;
}

// دالة لإضافة منتج إلى السلة (باستخدام جلسات PHP)
function add_to_cart($product_id, $quantity = 1) {
    session_start();
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $product = get_product_by_id($product_id);
        if ($product) {
            $_SESSION['cart'][$product_id] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => $quantity
            ];
        }
    }
}

// دالة لجلب محتويات السلة
function get_cart_items() {
    session_start();
    return $_SESSION['cart'] ?? [];
}

// دالة لحساب إجمالي السلة
function get_cart_total() {
    $total = 0;
    $cart_items = get_cart_items();
    foreach ($cart_items as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// دالة لتحديث كمية منتج في السلة
function update_cart_item($product_id, $quantity) {
    session_start();
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// دالة لحذف منتج من السلة
function remove_from_cart($product_id) {
    session_start();
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// دالة لإنشاء طلب جديد (Checkout)
function create_order($user_id, $total_amount, $shipping_address, $payment_method, $cart_items) {
    global $link;
    
    // 1. إدراج الطلب في جدول الطلبات (orders)
    $sql_order = "INSERT INTO orders (user_id, total_amount, shipping_address, payment_method) VALUES (?, ?, ?, ?)";
    if($stmt_order = mysqli_prepare($link, $sql_order)){
        mysqli_stmt_bind_param($stmt_order, "idss", $param_user_id, $param_total_amount, $param_shipping_address, $param_payment_method);
        $param_user_id = $user_id;
        $param_total_amount = $total_amount;
        $param_shipping_address = $shipping_address;
        $param_payment_method = $payment_method;
        
        if(mysqli_stmt_execute($stmt_order)){
            $order_id = mysqli_insert_id($link);
            
            // 2. إدراج تفاصيل الطلب في جدول order_items
            $sql_item = "INSERT INTO order_items (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)";
            if($stmt_item = mysqli_prepare($link, $sql_item)){
                foreach ($cart_items as $item) {
                    mysqli_stmt_bind_param($stmt_item, "iiid", $param_order_id, $param_product_id, $param_quantity, $param_price);
                    $param_order_id = $order_id;
                    $param_product_id = $item['id'];
                    $param_quantity = $item['quantity'];
                    $param_price = $item['price'];
                    mysqli_stmt_execute($stmt_item);
                }
                
                // 3. مسح السلة بعد إتمام الطلب
                session_start();
                unset($_SESSION['cart']);
                
                return $order_id;
            }
        }
    }
    return false;
}

// دالة لتسجيل الخروج
function logout_user() {
    session_start();
    $_SESSION = array();
    session_destroy();
}

// دالة للبحث في المنتجات والمقالات (لتبسيط المشروع)
function search_all($query) {
    global $link;
    $safe_query = "%" . mysqli_real_escape_string($link, $query) . "%";
    
    // البحث في المنتجات
    $sql_products = "SELECT id, name, 'product' as type FROM products WHERE name LIKE ? OR description LIKE ?";
    $stmt_products = mysqli_prepare($link, $sql_products);
    mysqli_stmt_bind_param($stmt_products, "ss", $safe_query, $safe_query);
    mysqli_stmt_execute($stmt_products);
    $result_products = mysqli_stmt_get_result($stmt_products);
    $results = [];
    while($row = mysqli_fetch_assoc($result_products)) {
        $results[] = $row;
    }

    // البحث في المقالات
    $sql_articles = "SELECT id, title as name, 'article' as type FROM articles WHERE title LIKE ? OR content LIKE ?";
    $stmt_articles = mysqli_prepare($link, $sql_articles);
    mysqli_stmt_bind_param($stmt_articles, "ss", $safe_query, $safe_query);
    mysqli_stmt_execute($stmt_articles);
    $result_articles = mysqli_stmt_get_result($stmt_articles);
    while($row = mysqli_fetch_assoc($result_articles)) {
        $results[] = $row;
    }

    return $results;
}

?>
