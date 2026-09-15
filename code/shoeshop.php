<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tip Toe Soles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: sans-serif;
        }
        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            padding: 20px 0;
            width: 200px;
            position: sticky;
            top: 0;
        }
        .sidebar .navbar-nav {
            padding-left: 20px;
        }
        .nav-link {
            color: #333;
            padding: .75rem 1rem;
            margin-bottom: 10px;
        }
        .dropdown-menu {
            position: relative;
            display: none;
            background-color: #f8f9fa;
            min-width: 100%;
            box-shadow: none;
            border: none;
            margin: 0;
            padding: 0;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-menu li {
            padding: 8px 12px;
        }
        .main-content {
            padding: 20px;
            margin-left: 200px;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <header class="bg-light text-center py-3">
        <img src="http://localhost/logo/TipToe_Soles_Logo_colour.png" alt="Tip Toe Soles Logo" style="max-width: 150px;">
    </header>

    <div class="row">
        <nav class="col-md-3 sidebar">
            <ul class="navbar-nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="http://localhost/shoeshop.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/about_us.php">About Us</a>
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
                    <a class="nav-link" href="#">Log in</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Wishlist</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/Contact_Us.php">Contact Us</a>
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
                    // Define product data
                    $products = [
                        ["title" => "Clancy Blue", "description" => "Elegant blue shoes for your office look.", "image" => "image/Clancy_Blue.jpg"],
                        ["title" => "Gary Black", "description" => "Stylish black shoes for your daily comfort.", "image" => "image/Gary_Black.jpg"],
                        ["title" => "Gary Tan", "description" => "Perfectly crafted tan shoes for every step.", "image" => "image/Gary_Tan.jpg"],
                        ["title" => "Sally Black", "description" => "Luxury black shoes for special occasions.", "image" => "image/Sally_Black.jpg"],
                        ["title" => "Sally Tan", "description" => "Casual tan shoes, great for all-day wear.", "image" => "image/Sally_Tan.jpg"],
                        ["title" => "Work and Walk", "description" => "Comfortable walking shoes for busy days.", "image" => "image/Work_and_Walk_Chesnut.jpg"]
                    ];

                    // Select only 3 products
                    $selectedProducts = array_slice($products, 0, 3);

                    // Display the selected products
                    foreach ($selectedProducts as $product) {
                        echo '<div class="col-lg-4 col-md-6 mb-4">';
                        echo '<div class="card shadow border-light">';
                        echo '<img src="' . htmlspecialchars($product["image"], ENT_QUOTES) . '" class="card-img-top" alt="' . htmlspecialchars($product["title"], ENT_QUOTES) . '">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($product["title"], ENT_QUOTES) . '</h5>';
                        echo '<p class="card-text">' . htmlspecialchars($product["description"], ENT_QUOTES) . '</p>';
                        echo '</div></div></div>';
                    }
                    ?>
                </div>

                <div class="row mt-4">
                    <div class="col d-flex justify-content-around">
                        <a href="#" class="btn btn-link">Return Policy</a>
                        <a href="#" class="btn btn-link">Exchange Policy</a>
                        <a href="#" class="btn btn-link">Shipping Policy</a>
                        <a href="#" class="btn btn-link">Privacy Policy</a>
                        <a href="#" class="btn btn-link">Terms of Service</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2025 Tip Toe Soles. All rights reserved.</p>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>