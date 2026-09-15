<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tip Toe Soles</title>
    <!-- Bootstrap CSS local -->
    <link href="/tiptoe/bootstrap-5.3.5-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="/tiptoe/css/style.css" />
</head>
<body>
<div class="container-fluid">
        <header class="bg-light py-3 px-4 d-flex align-items-center justify-content-between">
            <img src="http://localhost/tiptoe/logo/TipToe_Soles_Logo_colour.png" alt="Tip Toe Soles Logo" style="max-width: 150px;" />
            <button class="btn btn-outline-primary login-button">Log in</button>
        </header>       

    <div class="row">
        <nav class="col-md-3 sidebar">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/tiptoe/html/shoeshop.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/tiptoe/html/about_us.php">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Comfort Shoes</a></li>
                        <li><a class="dropdown-item" href="#">Accessories</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Wishlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/tiptoe/html/Contact_Us.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQ</a>
                </li>
            </ul>
        </nav>

        <main class="col-md-9 main-content">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1>Tip Toe Soles</h1>
                        <h2>Stylish Comfort for Every Step</h2>
                        <p>Discover your next favorite pair of shoes that blend style and comfort effortlessly.</p>
                        <a href="#" class="btn btn-primary mb-3">Shop Now</a>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <?php
                    $products = [
                        ["title" => "Clancy Blue", "description" => "Elegant blue shoes for your office look.", "image" => "/tiptoe/image/Clancy_Blue.jpg"],
                        ["title" => "Gary Black", "description" => "Stylish black shoes for your daily comfort.", "image" => "/tiptoe/image/Gary_Black.jpg"],
                        ["title" => "Gary Tan", "description" => "Perfectly crafted tan shoes for every step.", "image" => "/tiptoe/image/Gary_Tan.jpg"],
                        ["title" => "Sally Black", "description" => "Luxury black shoes for special occasions.", "image" => "/tiptoe/image/Sally_Black.jpg"],
                        ["title" => "Sally Tan", "description" => "Casual tan shoes, great for all-day wear.", "image" => "/tiptoe/image/Sally_Tan.jpg"],
                        ["title" => "Work and Walk", "description" => "Comfortable walking shoes for busy days.", "image" => "/tiptoe/image/Work_and_Walk_Chestnut.jpg"]
                    ];
                    $selectedProducts = array_slice($products, 0, 3);
                    foreach ($selectedProducts as $product) {
                        echo '<div class="col-lg-4 col-md-6 mb-4">';
                        echo '<div class="card shadow border-light">';
                        echo '<img src="' . htmlspecialchars($product["image"], ENT_QUOTES, "UTF-8") . '" class="card-img-top" alt="' . htmlspecialchars($product["title"], ENT_QUOTES, "UTF-8") . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($product["title"], ENT_QUOTES, "UTF-8") . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($product["description"], ENT_QUOTES, "UTF-8") . '</p>';
                        echo '</div></div></div>';
                    }
                    ?>
                </div>

                
            </div>
        </main>
    </div>

  <footer style="padding: 20px; background: #f8f9fa; text-align: center;">

    <div class="links" style="margin-bottom: 10px;">
      <a href="#">Return Policy</a>
      <a href="#">Exchange Policy</a>
      <a href="#">Shipping Policy</a>
      <a href="#">Privacy Policy</a> |
      <a href="#">Terms of Service</a> |
      <a href="#">Help</a>
    </div>

    <div class="social-logo" style="margin-bottom: 15px;">
    <p class="mb-0" style="margin-right: 0.6ch;">Follow us on social media for the latest updates!</p><br>
    
      <img src="/tiptoe/logo/social-media-logo.jpg" alt="Social Media Logos" style="width: 150px; height: auto;">
    </div>

    <div class="copyright" style="font-size: 14px; color: #666;">
      © 2025 TipToe Soles. All rights reserved.
    </div>

  </footer>
</div>

<!-- Bootstrap JS local -->
<script src="/tiptoe/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>