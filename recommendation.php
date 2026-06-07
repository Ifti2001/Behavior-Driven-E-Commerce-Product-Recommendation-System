<?php
$cnx = mysqli_connect("localhost","root","","productdb");

// ১. একটি সিঙ্গেল জয়েন কুয়েরি দিয়ে ম্যাট্রিক্স তৈরি (Efficiency)
$q = "SELECT u.username, p.product_name, r.rate 
      FROM review r
      JOIN users u ON r.user_id = u.id_user
      JOIN producttb p ON r.prod_id = p.productid";

$r = mysqli_query($cnx, $q);
$matrix = array();

while($row = mysqli_fetch_assoc($r)) {
    $matrix[$row['username']][$row['product_name']] = (int)$row['rate'];
}
$j=0;


function recom_items($username){

    $matrix=$GLOBALS['matrix'];
    if(array_key_exists($username,$matrix)){
        if(count(getRecommendations($matrix, $username))>0  ){
           return getRecommendations($matrix, $username);}

        else{
        return 0;
            }}
    else{
        return 0;
        }


 }
//print_r(getRecommendations($matrix, "elma")) . "<br>";


// ২. আপনার ইউক্লিডিয়ান ফাংশনগুলো
function euclideanDistance($U_matrix, $item1, $item2) {
    $similar = array();
    $sum = 0;
    foreach($U_matrix[$item1] as $key=>$value) {
        if(array_key_exists($key, $U_matrix[$item2])) $similar[$key] = 1;
    }
    if(count($similar) == 0) return 0;
    foreach($U_matrix[$item1] as $key=>$value) {
        if(array_key_exists($key, $U_matrix[$item2]))
            $sum = $sum + pow($value - $U_matrix[$item2][$key], 2);
    }
    return 1/(1 + sqrt($sum));
}

function getRecommendations($U_matrix, $user) {
    $total = array();
    $simSums = array();
    $ranks = array();
    foreach($U_matrix as $otheruser=>$values) {
        if($otheruser != $user) {
            $sim = euclideanDistance($U_matrix, $user, $otheruser);
            if($sim > 0) {
                foreach($U_matrix[$otheruser] as $key=>$value) {
                    if(!array_key_exists($key, $U_matrix[$user])) {
                        if(!array_key_exists($key, $total)) $total[$key] = 0;
                        $total[$key] += $U_matrix[$otheruser][$key] * $sim;
                        if(!array_key_exists($key, $simSums)) $simSums[$key] = 0;
                        $simSums[$key] += $sim;
                    }
                }
            }
        }
    }
    foreach($total as $key=>$value) {
        $ranks[$key] = $value / $simSums[$key];
    }
    array_multisort($ranks, SORT_DESC);
    return $ranks;
}

// হাইব্রিড লজিক
function get_hybrid_recommendations($current_user_id, $current_category_id) {
    global $cnx;
    $recommendations = array();

    // এখানে category_name জয়েন করা হয়েছে component() ফাংশনে পাঠানোর সুবিধার জন্য
    $query = "SELECT DISTINCT p.*, c.category_name FROM producttb p
              JOIN category c ON p.product_category = c.id_category
              LEFT JOIN review r ON p.productid = r.prod_id
              WHERE 
                (p.product_category = '$current_category_id' AND p.product_rate >= 4)
                OR 
                (r.rate >= 4 AND r.user_id != '$current_user_id')
              ORDER BY 
                CASE 
                    WHEN p.product_category = '$current_category_id' THEN 1 
                    ELSE 2 
                END, 
                r.review_date DESC 
              LIMIT 8";

    $result = mysqli_query($cnx, $query);
    while($row = mysqli_fetch_assoc($result)) {
        $recommendations[] = $row;
    }
    return $recommendations;
}


?>