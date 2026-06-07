<?php
class Creatdb {
   public $username;
   public $password;
   public $servername;
   public $dbname;
   public $tablename;
   public $con;
    
   function __construct($dbname, $tablename, $username, $password, $servername){
      $this->username = $username; 
      $this->password = $password; 
      $this->servername = $servername; 
      $this->dbname = $dbname; 
      $this->tablename = $tablename; 

      // Database connection
      $this->con = mysqli_connect($servername, $username, $password, $dbname);
      if (!$this->con){
          die("Connection Failed: " . mysqli_connect_error());
      }
   }

   // ✅ Get DB connection
   public function getConnection(){
        return $this->con;
   }

   // ✅ Get all products
   public function getData(){
      $sql = "SELECT productid, product_name, productOldPrice, productNewPrice, product_image, 
                     category_name, product_rate, Qte, product_description
              FROM producttb 
              JOIN category ON product_category = id_category";
      $result = mysqli_query($this->con, $sql);
      return $result;
   }

   // ✅ Get product by category
   public function getDataCategory($category){
        $sql = "SELECT productid, product_name, productOldPrice, productNewPrice, product_image, 
                       product_rate, category_name
                FROM producttb 
                JOIN category ON product_category = id_category
                WHERE category_name = '$category'";
        $result = mysqli_query($this->con, $sql);
        return $result;
   }

   // ✅ Get hot deals
   public function getDataHotDeal(){
       $sql = "SELECT * FROM productHotDeal";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get product details
   public function getProductDetail($productid){
       $sql = "SELECT productid, product_name, productOldPrice, productNewPrice, product_image, 
                      category_name, Qte, product_description, 
                      COUNT(prod_id) as nbr_review
               FROM producttb 
               JOIN category ON product_category = id_category
               LEFT JOIN review ON prod_id = productid
               WHERE productid = '$productid'";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get product reviews
   public function getProductReview($productid){
       $sql = "SELECT username, rate, commentaire, review_date
               FROM review 
               JOIN users ON user_id = id_user
               WHERE prod_id = '$productid'";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get best selling products
   public function getbestselling(){
       $sql = "SELECT p.*, c.category_name 
               FROM producttb p 
               JOIN category c ON c.id_category = p.product_category 
               WHERE p.productid IN (
                   SELECT op.product_id 
                   FROM orderProduct op 
                   JOIN orders o ON o.order_id = op.order_id 
                   GROUP BY product_id 
                   ORDER BY SUM(qte) DESC
               )";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get recommended product (by product name)
   public function get_Recommendation_Product($product_name){
       $sql = "SELECT productid, product_name, productOldPrice, productNewPrice, product_image, 
                      category_name, product_rate
               FROM producttb
               JOIN category ON product_category = id_category
               WHERE product_name = '$product_name'";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get order details
   public function getorderDetail($orderid){
       $sql = "SELECT o.order_id, u.username, u.email, u.user_tel, u.user_adr, 
                      o.order_date, o.order_total_Price, o.order_Methode
               FROM orders o 
               JOIN users u ON o.user_id = u.id_user
               WHERE o.order_id = '$orderid'";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

   // ✅ Get PayPal order details
   public function get_PAYPAL_orderDetail($paypal_orderid){
       $sql = "SELECT o.order_id, u.username, u.email, u.user_tel, u.user_adr, 
                      o.order_date, o.order_total_Price, o.order_Methode, o.Paypal_order_Id
               FROM orders o 
               JOIN users u ON o.user_id = u.id_user
               WHERE o.Paypal_order_Id = '$paypal_orderid'";
       $result = mysqli_query($this->con, $sql);
       return $result;
   }

// ✅ Get Hybrid Recommendation (Category + Global User Ratings)
public function getHybridRecommendations($username) {
    $user_query = "SELECT id_user FROM users WHERE username = '$username'";
    $user_result = mysqli_query($this->con, $user_query);
    $user_row = mysqli_fetch_assoc($user_result);
    $user_id = $user_row['id_user'];

    $sql = "
        SELECT 
            p.productid, 
            p.product_name, 
            p.productOldPrice, 
            p.productNewPrice, 
            p.product_image, 
            c.category_name, 
            p.product_rate,
            IFNULL(vt.view_duration, 0) AS view_duration,
            AVG(r_all.rate) as avg_rating -- সব ইউজারের গড় রেটিং
        FROM producttb p
        JOIN category c ON p.product_category = c.id_category
        LEFT JOIN view_time vt 
            ON vt.user_id = '$user_id' AND vt.product_id = p.productid
        LEFT JOIN review r_all 
            ON p.productid = r_all.prod_id
        WHERE 
            -- ১. লজিক: ইউজারের নিজের দেখা ক্যাটাগরির ভালো প্রোডাক্ট
            (p.product_category IN (SELECT DISTINCT category_id FROM user_activity WHERE user_id = '$user_id') AND p.product_rate >= 4)
            OR 
            -- ২. লজিক: গ্লোবাল পপুলারিটি (যাদের গড় রেটিং ৪ বা তার বেশি)
            (p.productid IN (
                SELECT prod_id FROM review 
                GROUP BY prod_id 
                HAVING AVG(rate) >= 4
            ))
        
        GROUP BY p.productid
        ORDER BY 
            vt.view_duration DESC, 
            p.product_rate DESC
        LIMIT 10
    ";

    $result = mysqli_query($this->con, $sql);
    return $result;
}

// ✅ Search product by name or category
public function getSearchData($keyword) {
    $keyword = mysqli_real_escape_string($this->con, $keyword);

    $sql = "SELECT p.productid, p.product_name, p.productOldPrice, p.productNewPrice, 
                   p.product_image, c.category_name, p.product_rate
            FROM producttb p
            JOIN category c ON p.product_category = c.id_category
            WHERE p.product_name LIKE '%$keyword%' 
               OR c.category_name LIKE '%$keyword%'";

    $result = mysqli_query($this->con, $sql);
    if (!$result) {
        die('SQL Error getSearchData: ' . mysqli_error($this->con));
    }
    return $result;
}

// ✅ Get Users 
public function get_Users($limit) {
    $sql = "SELECT id_user, username, email, user_tel, user_adr 
            FROM users 
            LIMIT $limit";
    $result = mysqli_query($this->con, $sql);
    if (!$result) {
        die("SQL Error get_Users: " . mysqli_error($this->con));
    }
    return $result;
}

// ✅ Get All Users Review
public function get_Users_Review() {
    $sql = "SELECT r.rev_id, u.username, r.prod_id, p.product_name, r.rate, 
                   r.commentaire, r.review_date
            FROM review r
            JOIN users u ON r.user_id = u.id_user
            JOIN producttb p ON r.prod_id = p.productid
            ORDER BY r.review_date DESC";
    $result = mysqli_query($this->con, $sql);
    if (!$result) {
        die("SQL Error get_Users_Review: " . mysqli_error($this->con));
    }
    return $result;
}

// ✅ Get Orders 
public function get_Orders($limit) {
    $sql = "SELECT o.order_id, u.username, o.order_products, o.order_date, 
                   o.order_total_Price, o.order_Methode, o.Paypal_order_Id
            FROM orders o
            JOIN users u ON o.user_id = u.id_user
            ORDER BY o.order_date DESC
            LIMIT $limit";
    $result = mysqli_query($this->con, $sql);
    if (!$result) {
        die("SQL Error get_Orders: " . mysqli_error($this->con));
    }
    return $result;
}


}
?>
