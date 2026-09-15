<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | TipToe Soles</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        /* Logo size settings */
        .logo {
            max-width: 200px; /* Set maximum width to 200px */
            height: auto;     /* Height adjusts automatically based on image ratio */
            display: block;   /* Make the logo a block element */
            margin: 0 auto;   /* Center-align horizontally */
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;     /* Set sidebar width */
            height: 100vh;    /* Fixed height matching the viewport */
            position: fixed;  /* Fix the sidebar */
            background-color: #f8f9fa; /* Background color */
            border-right: 1px solid #ddd; /* Border line */
            padding-top: 1rem; /* Adjust top padding */
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
        }

        .nav-link {
            font-size: 16px;
            padding: 10px;
            color: #333;
            text-decoration: none;
            display: block;
        }

        .nav-link.active {
            font-weight: bold;
            color: #007bff; /* Color for active link */
            background-color: #e9ecef; /* Indicator for the current page */
        }

        .nav-link:hover {
            background-color: #e9ecef; /* Highlight on hover */
        }

        /* Content area settings */
        .container {
            margin-left: 260px; /* Margin based on sidebar width */
            padding-bottom: 100px; /* Adjust bottom padding */
        }

        /* Footer styling */
        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 1rem;
        }
    </style>
</head>

<body>
<!-- Header section -->
<header class="text-center py-4">
    <!-- Display logo image -->
    <img src="http://localhost/logo/TipToe_Soles_Logo_colour.png" alt="TipToe Soles Logo" class="img-fluid logo">
</header>

<!-- Sidebar -->
<div class="sidebar">
    <nav class="navbar navbar-light">
        <ul class="navbar-nav flex-column">
            <li class="nav-item sidebar-title">Menu</li> <!-- Display "Menu" at the top -->
            <li class="nav-item"><a class="nav-link" href="http://localhost/shoeshop.php">Home</a></li> <!-- Link to Home -->
            <li class="nav-item"><a class="nav-link active" href="http://localhost/about_us.php">About Us</a></li> <!-- Active link for About Us -->
            <li class="nav-item"><a class="nav-link" href="#" onclick="showProduct()">Product</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="showServices()">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="showLogin()">Log in</a></li>
            <li class="nav-item"><a class="nav-link" href="#" onclick="showWishlist()">Wishlist</a></li>
            <li class="nav-item"><a class="nav-link" href="http://localhost/Contact_Us.php">Contact Us</a></li> <!-- Link to Contact Us -->
            <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
        </ul>
    </nav>
</div>

<!-- About Us Header -->
<header class="text-center py-4">
    <h1>About Us</h1>
</header>

<!-- Main content -->
<div class="container">
    <!-- About Us Section -->
    <div>
        <h2>Who We Are</h2>
        <p>Tip Toe Shoes is a brand that embodies the perfect blend of style and comfort. We are a subsidiary of Gelos Enterprises, a renowned IT organisation with expertise in web development and cyber security. We aim to revolutionize the footwear industry with innovative and high-quality products.</p>
    </div>

    <div class="mt-5">
        <h2>Our Partnership</h2>
        <p>Headquartered in Sydney, Australia, Gelos Enterprises has partnered with Tip Toe Soles, a leading footwear manufacturer, to create shoes that match modern style with exceptional comfort. We are committed to serving everyone: from multinational corporations to individuals with unique style preferences.</p>
    </div>

    <div class="mt-5">
        <h2>Our Vision</h2>
        <p>At Tip Toe Shoes, we believe that true quality speaks for itself. Our mission is to redefine the footwear landscape by offering affordable yet luxurious product lines for men, women, and children.</p>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light py-3 text-center">
    <div class="container">
        <!-- Add policy links -->
        <div class="row">
            <div class="col-12">
                <a href="#" onclick="showReturnPolicy()">Return Policy</a> |
                <a href="#" onclick="showExchangePolicy()">Exchange Policy</a> |
                <a href="#" onclick="showShippingPolicy()">Shipping Policy</a> |
                <a href="#" onclick="showPrivacyPolicy()">Privacy Policy</a> |
                <a href="#" onclick="showTermsOfService()">Terms Of Service</a>
            </div>
        </div>
        
        <!-- Copyright section -->
        <div class="row mt-3">
            <div class="col-12">
                <p>&copy; 2025 Tip Toe Shoes. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
    // JavaScript functions to handle policy display
    function showReturnPolicy() {
        alert("Return Policy details go here.");
    }

    function showExchangePolicy() {
        alert("Exchange Policy details go here.");
    }

    function showShippingPolicy() {
        alert("Shipping Policy details go here.");
    }

    function showPrivacyPolicy() {
        alert("Privacy Policy details go here.");
    }

    function showTermsOfService() {
        alert("Terms Of Service details go here.");
    }
</script>
<script>
    // JavaScript functions to update the main content area
    function showHome() {
        window.location.href = "http://localhost/shoeshop.php"; // Navigate to Home
    }
    function showAbout() {
        // Already on About Us page, no action needed
    }
    function showProduct() {
        alert("Product content goes here");
    }
    function showServices() {
        alert("Services content goes here");
    }
    function showLogin() {
        alert("Login content goes here");
    }
    function showWishlist() {
        alert("Wishlist content goes here");
    }
    function showContact() {
        window.location.href = "http://localhost/Contact_Us.php"; // Navigate to Contact Us
    }
    function showFAQ() {
        alert("FAQ content goes here");
    }
</script>

</body>
</html>