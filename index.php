<?php

session_start();
require_once('./component.php');
require_once('./creatdb.php');
require_once('./recommendation.php');

 

// create instance of Createdb class
$database = new Creatdb("Productdb", "Producttb","root","","localhost");
$t=0;
?>

<?php 

/*
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Electro - Bedri</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>
		<script src ='js/countdown.js'>

		</script>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	<style>
		/* ==========================
		FINAL FIX – Priority Scaling + Safe Spacing
		========================== */
		#recommended-products .slick-track {
		display: flex !important;
		align-items: flex-end;
		gap: 30px; /* card গুলার মাঝে proper space */
		padding: 15px 0;
		}
		#recommended-products .slick-slide {
		display: flex !important;
		justify-content: center;
		align-items: flex-end;
		transition: transform 0.3s ease;
		}
		/* High Priority — বড় */
		#recommended-products .product.high-priority {
		transform: scale(1.25);
		z-index: 3;
		margin: 0 25px; /* দুইপাশে জায়গা */
		}
		/* Medium Priority — মাঝারি */
		#recommended-products .product.medium-priority {
		transform: scale(1.1);
		z-index: 2;
		margin: 0 20px;
		}
		/* Low Priority — ছোট */
		#recommended-products .product.low-priority {
		transform: scale(0.95);
		z-index: 1;
		opacity: 0.9;
		margin: 0 15px;
		}
		/* বাকি spacing ঠিক রাখা */
		#recommended-products .product-wrapper.high-priority { 
			transform: scale(1.25); 
			margin-bottom: 60px;
		}
		#recommended-products .product-wrapper.medium-priority { transform: scale(1.05); 
			margin-bottom: 50px;
		}
		#recommended-products .product-wrapper.low-priority { transform: scale(0.9); opacity: 0.9; 
			margin-bottom: 40px;
		}
		#recommended-products .product {
		transition: transform 0.4s ease, box-shadow 0.3s ease;
		transform-origin: center bottom;
		margin: 0 10px;
		}

		
		/* ==========================
   		✅ Responsive Fix for Recommended Section
   		========================== */

		/* Mobile (max-width: 576px) */
		@media (max-width: 576px) {
		#recommended-products .slick-track {
			gap: 10px;
			padding: 10px 0;
		}

		#recommended-products .product-wrapper.high-priority {
			transform: scale(1.05);
			margin-bottom: 25px;
		}
		#recommended-products .product-wrapper.medium-priority {
			transform: scale(0.95);
			margin-bottom: 20px;
		}
		#recommended-products .product-wrapper.low-priority {
			transform: scale(0.9);
			margin-bottom: 15px;
		}

		#recommended-products .product {
			margin: 0 5px;
		}

		/* নাম ছোট স্ক্রিনে কেটে না যায় */
		#recommended-products .product .product-name {
			font-size: 12px;
			-webkit-line-clamp: 2;
		}
		}

		/* Tablet (max-width: 768px) */
		@media (max-width: 768px) {
		#recommended-products .slick-track {
			gap: 15px;
		}

		#recommended-products .product-wrapper.high-priority {
			transform: scale(1.15);
			margin-bottom: 35px;
		}
		#recommended-products .product-wrapper.medium-priority {
			transform: scale(1.0);
			margin-bottom: 30px;
		}
		#recommended-products .product-wrapper.low-priority {
			transform: scale(0.9);
			margin-bottom: 25px;
		}

		#recommended-products .product .product-name {
			font-size: 13px;
		}
		}

		/* Laptop (max-width: 1024px) */
		@media (max-width: 1024px) {
		#recommended-products .product-wrapper.high-priority {
			transform: scale(1.2);
			margin-bottom: 45px;
		}
		#recommended-products .product-wrapper.medium-priority {
			transform: scale(1.05);
			margin-bottom: 35px;
		}
		#recommended-products .product-wrapper.low-priority {
			transform: scale(0.95);
			margin-bottom: 30px;
		}
		}

	</style>


</head>
	<body>
		
		<!-- HEADER -->
		<header>
			<!-- TOP HEADER -->
			<div id="top-header">
				<div class="container">
					<ul class="header-links pull-left">						
						<li><a href="#"><i class="fa fa-envelope-o"></i> admin@example.com</a></li>
						<li><a href="#"><i class="fa fa-map-marker"></i> Daffodil Smart City</a></li>
						<?php
						if (isset($_SESSION['username'])) {
							echo ' <li style ="color:white"><span style="padding-left:50px;"></span>  Welcome<span style="padding-left:8px;"></span> <a style ="color :white ;font-size:16px;text-shadow: 2px 2px 8px #D81717;">  '. $_SESSION['username'] .'   </a>    </li> ' ;
					 
						}
						?>			 
						</ul>
					<ul class="header-links pull-right">
						<!-- <li><a style = "font-size : 15px" href="#"><i class="fa fa-dollar"></i> USD</a></li> -->
						<?php
						if (isset($_SESSION['username'])) {
						echo '<li><a style = "font-size : 12px" href="logout.php"><i style = "font-size : 17px" class="fa fa-user-o"></i> Logout </a></li>';
						}
						else {
							echo '<li><a style = "font-size : 15px" href="login.php"><i style = "font-size : 20px" class="fa fa-user-o"></i> sign up </a></li>';
						}
				      ?>
						</ul>
				</div>
			</div>
			<!-- /TOP HEADER -->

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/logo.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

						<!-- SEARCH BAR -->
						<div class="col-md-6">
							<div class="header-search">
							<form action="search.php" method="post">
									<select name="search-content-category" class="input-select">
										<option value="none">All Categories</option>
										<option value="smartphone"> Smartphones </option>
										<option value="camera"> Camera </option>
										<option value="laptop"> Laptops </option>
										<option value="accessoire"> Accessories </option>
									</select>
									<form action="search.php" method="post">
									<input class="input" placeholder="Search here" name = 'search-content'>
									<button class="search-btn" name ='search'>Search</button>    
								</form>
							</div>
						</div>
						<!-- /SEARCH BAR -->

						<!-- ACCOUNT -->
						<div class="col-md-3 clearfix">
							<div class="header-ctn">
								<!-- Wishlist
								<div>
									<a href="#">
										<i class="fa fa-heart-o"></i>
										<span>Your Wishlist</span>
										<div class="qty">7</div>
									</a>
								</div>
								  /Wishlist -->  
								<!-- cart -->
								<div>
									<a href="cart.php">
										<i style = "font-size:30px" class="fa fa-shopping-cart"></i>
										<strong>Your Cart</strong>
									    <?php

                                    if (isset($_SESSION['cart'])){
	                                    $count = count($_SESSION['cart']);
                                    	echo "<div class='qty'> <span id=\"cart_count\">$count</span></div>";
                                    }else{
                                    	echo "<div class='qty'> <span id=\"cart_count\" >0</span></div>";
                                    }

                                    ?>
									</a>
								</div>
								<!-- Menu Toogle -->
								<div class="menu-toggle">
									<a href="#">
										<i class="fa fa-bars"></i>
										<span>Menu</span>
									</a>
								</div>
								<!-- /Menu Toogle -->
							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<form action="category.php" method = "post"></form>
					<ul class="main-nav nav navbar-nav">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="#hot-deal">Hot Deals</a></li>
						<li><a href="category.php?category_name=laptop">Laptops</a></li>
						<li><a href="category.php?category_name=smartphone">Smartphones</a></li>
						<li><a href="category.php?category_name=camera">Camera</a></li>
						<li><a href="category.php?category_name=accessories">Accessories</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop01.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Laptop<br>Collection</h3>
								<a href="category.php?category_name=laptop" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop03.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Accessories<br>Collection</h3>
								<a href="category.php?category_name=accessories" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->

					<!-- shop -->
					<div class="col-md-4 col-xs-6">
						<div class="shop">
							<div class="shop-img">
								<img src="./img/shop02.png" alt="">
							</div>
							<div class="shop-body">
								<h3>Cameras<br>Collection</h3>
								<a href="category.php?category_name=camera" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
							</div>
						</div>
					</div>
					<!-- /shop -->
				 
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">New Products</h3>
							<!-- <div class="section-nav">
								<ul class="section-tab-nav tab-nav">
									<li class="active"><a data-toggle="tab" href="#tab1">Laptops</a></li>
									<li><a data-toggle="tab" href="#tab1">Smartphones</a></li>
									<li><a data-toggle="tab" href="#tab1">Cameras</a></li>
									<li><a data-toggle="tab" href="#tab1">Accessories</a></li>
								</ul>
							</div> -->
						</div>					
					</div>
					<!-- /section title -->
				

					<!-- Products tab & slick -->
					<div class="col-md-12">
						<div class="row">
							<div class="products-tabs">
								<!-- tab -->
								<div id="tab1" class="tab-pane active">
									<div class="products-slick" data-nav="#slick-nav-1">
										<!-- product -->
										<?php
										$curPageName = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
										$result = $database->getData();
										while ($row = mysqli_fetch_assoc($result)){

											component($row['productid'],$row['product_name'], $row['productOldPrice'],$row['productNewPrice'], $row['product_image'],$row['category_name'] , $row['product_rate'], $curPageName, "New");
										
										}
										?>
										<!-- /product -->
									</div>
									<div id="slick-nav-1" class="products-slick-nav"></div>
								</div>
								<!-- /tab -->
							</div>
						</div>
					</div>
					<!-- Products tab & slick -->
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
<br><br>
		<!-- HOT DEAL SECTION -->
		<div id="hot-deal" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="hot-deal">
							<ul class="hot-deal-countdown">
								<li>
									<div>
										<h3 class="days" ></h3>
										<span >Days</span>
									</div>
								</li>
								<li>
									<div>
										<h3   class="hours"></h3>
										<span >Hours</span>
									</div>
								</li>
								<li>
									<div>
										<h3   class="minutes" ></h3>
										<span >Mins</span>
									</div>
								</li>
								<li>
									<div>
										<h3 class="seconds"></h3>
										<span>Secs</span>
									</div>
								</li>
							</ul>
							<h2 class="text-uppercase">hot deal this Month ! </h2>
							<p>New Collection Up to 50% OFF</p>
							<a class="primary-btn cta-btn" href="hotdeal.php">Shop now</a>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /HOT DEAL SECTION -->

<!-- SECTION: Recommended Products -->
<?php if (isset($_SESSION["username"])) { ?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">Recommended for You</h3>
                </div>
            </div>
            <div class="col-md-12">
                <div class="products-slick" id="recommended-products" data-nav="#slick-nav-category">

                    <?php
                        $curPageName = basename($_SERVER["SCRIPT_NAME"]);
                        // ডাটাবেস থেকে হাইব্রিড রিকমেন্ডেশন নিয়ে আসা
                        $result = $database->getHybridRecommendations($_SESSION["username"]);
                        
                        $recom_list = [];
                        while ($row = mysqli_fetch_assoc($result)) {
                            $recom_list[] = $row;
                        }

                        $rank = 0;

                        if (count($recom_list) > 0) {
                            foreach ($recom_list as $row) {
                                $viewTime = (int)$row['view_duration'];
                                // creatdb.php থেকে আসা personal_rating চেক করা
                                $personalRating = isset($row['personal_rating']) ? (int)$row['personal_rating'] : null;

                                /**
                                 * 🛡️ প্রো-লেভেল হাইব্রিড লজিক:
                                 * ১. যদি ইউজার নিজে ৩ বা তার কম রেটিং দেয় -> Low Priority (রমজান ফিক্স)
                                 * ২. যদি ভিউ টাইম ৫ সেকেন্ডের কম হয় -> Low Priority
                                 * ৩. রেটিং ভালো থাকলে এবং ভিউ টাইম থাকলে -> র‍্যাঙ্ক অনুযায়ী High/Medium হবে
                                 */
                                if ($personalRating !== null && $personalRating <= 3) {
                                    $priorityClass = "low-priority";
                                } elseif ($viewTime < 5) {
                                    $priorityClass = "low-priority";
                                } else {
                                    $rank++; // ভালো রেটিং বা নতুন ভিউ থাকলে র‍্যাঙ্ক বাড়বে
                                    if ($rank <= 2) {
                                        $priorityClass = "high-priority";
                                    } elseif ($rank <= 5) {
                                        $priorityClass = "medium-priority";
                                    } else {
                                        $priorityClass = "low-priority";
                                    }
                                }

                                // জাভাস্ক্রিপ্টের জন্য data attributes পাঠানো হচ্ছে
                                echo "<div class='product-wrapper $priorityClass' data-priority='$priorityClass' data-viewtime='{$viewTime}'>";

                                component(
                                    $row['productid'],
                                    $row['product_name'],
                                    $row['productOldPrice'],
                                    $row['productNewPrice'],
                                    $row['product_image'],
                                    $row['category_name'],
                                    $row['product_rate'],
                                    $curPageName,
                                    'Recommended'
                                );

                                echo "</div>";
                            }
                        } else {
                            echo "<p>No recommendations yet. Start browsing!</p>";
                        }
                    ?>

                </div>
                <div id="slick-nav-category" class="products-slick-nav"></div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- /SECTION: Recommended Products -->

	<!-- SECTION: Best Selling Products -->
	<div class="section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title">
						<h3 class="title">Best Selling</h3>
					</div>
				</div>
				<div class="col-md-12">
					<div class="products-slick" data-nav="#slick-nav-bestselling">
						<?php
						$curPageName = basename($_SERVER["SCRIPT_NAME"]);
						$result = $database->getbestselling();
						while ($row = mysqli_fetch_assoc($result)) {
							component($row['productid'], $row['product_name'], $row['productOldPrice'], $row['productNewPrice'], $row['product_image'], $row['category_name'], $row['product_rate'], $curPageName, "Best Seller");
						}
						?>
					</div>
					<div id="slick-nav-bestselling" class="products-slick-nav"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- /SECTION: Best Selling Products -->
	 
		<!-- NEWSLETTER -->
		<div id="newsletter" class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">
					<div class="col-md-12">
						<div class="newsletter">
							<p>Sign Up for the <strong>NEWSLETTER</strong></p>
							<form>
								<input class="input" type="email" placeholder="Enter Your Email">
								<button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
							</form>
							<ul class="newsletter-follow">
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-twitter"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-instagram"></i></a>
								</li>
								<li>
									<a href="#"><i class="fa fa-pinterest"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /NEWSLETTER -->
	 
		<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>Our site cares about the wonderful customer experience as we offer you a range of products you are looking for in addition to we will bring your product to your door</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>Daffodil Smart City </a></li>
									<li><a href="#"><i class="fa fa-phone"></i>0648592636.</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>admin@example.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="#">Hot deals</a></li>
									<li><a href="#">Laptops</a></li>
									<li><a href="#">Smartphones</a></li>
									<li><a href="#">Cameras</a></li>
									<li><a href="#">Accessories</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
									<li><a href="#">About Us</a></li>
									<li><a href="#">Contact Us</a></li>
									<li><a href="#">Privacy Policy</a></li>
									<li><a href="#">Orders and Returns</a></li>
									<li><a href="#">Terms & Conditions</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Service</h3>
								<ul class="footer-links">
									 
									<li><a href="#">View Cart</a></li>
									 
									<li><a href="#">Track My Order</a></li>
									<li><a href="#">Help</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i style="color: white;" class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i style="color: white;" class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i style="color: white;" class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i style="color: white;" class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i style="color: white;" class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i style="color: white;" class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This Web-site is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <strong href="https://electro.com" target="_blank">Us</strong>
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function () {
			const products = document.querySelectorAll("#recommended-products .product");


			products.forEach((productCard) => {
				const viewTime = parseInt(productCard.getAttribute("data-viewtime")) || 0;
				let scaleValue, marginValue;

				if (viewTime >= 30) {
				scaleValue = 1.25;
				marginValue = "10px 20px 0 20px"; // নিচে কম margin
				} else if (viewTime >= 15) {
				scaleValue = 1.1;
				marginValue = "15px 20px 5px 20px";
				} else {
				scaleValue = 0.95;
				marginValue = "25px 20px 15px 20px";
				}

				productCard.style.transform = `scale(${scaleValue})`;
				productCard.style.margin = marginValue;
				productCard.style.zIndex = Math.round(scaleValue * 100);
				});
				});
		</script>

	</body>
</html>
