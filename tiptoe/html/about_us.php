<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>About Us - TipToe Soles</title>

    <!-- Bootstrap CSS -->
    <link href="/tiptoe/bootstrap-5.3.5-dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Base layout */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .logo {
            max-width: 200px;
            height: auto;
        }

        /* Navigation sidebar */
        .sidebar {
            background-color: #f8f9fa;
            padding: 1rem;
            min-height: 100vh;
            border-right: 1px solid #ddd;
        }

        /* Navigation links */
        .navbar-nav .nav-link {
            color: #333;
            padding: 10px 15px;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: #e9ecef;
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
            color: #007bff !important;
            background-color: #e9ecef;
        }

        /* Contact details */
        .contact-details {
            margin-top: auto;
            padding-top: 2rem;
        }

        .contact-details h4 {
            margin-bottom: 1rem;
        }

        /* Main content */
        .main-content {
            padding: 2rem;
            flex: 1;
        }

        /* Footer */
        footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #ddd;
            margin-top: auto;
        }

        .footer-links a {
            color: #007bff;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .social-logo img {
            width: 150px;
            height: auto;
            margin-top: 0.5rem;
        }

        .copyright {
            font-size: 14px;
            color: #666;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="text-center py-4 border-bottom">
        <a href="/tiptoe/html/shoeshop.php">
            <img src="/tiptoe/logo/TipToe_Soles_Logo_colour.png" alt="TipToe Soles Logo" class="logo" />
        </a>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-md-3 sidebar d-flex flex-column">
                <nav>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tiptoe/html/shoeshop.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/tiptoe/html/about_us.php">About Us</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Products</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Comfort Shoes</a></li>
                                <li><a class="dropdown-item" href="#">Accessories</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Wishlist</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tiptoe/html/Contact_Us.php">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                    </ul>
                </nav>

                <div class="contact-details">
                    <h4>Contact Details</h4>
                    <address>
                        322 Avondale Road<br />
                        Enfield NSW 2133<br /><br />
                        <strong>Customer Service:</strong><br />
                        Tel: <a href="tel:0292105000">02 9210 5000</a><br />
                        Email: <a href="mailto:TipToeShoes@gmail.com">TipToeShoes@gmail.com</a>
                    </address>
                </div>
            </aside>

            <!-- Main content -->
            <main class="col-md-9 main-content">
                <article>
                    <h1>About Us</h1>
                    <p class="lead">
                        TipToe Soles is an Australian owned and operated company. We aim to provide comfortable footwear at affordable prices to customers within Australia and around the world.
                    </p>

                    <section class="mt-5">
                        <h2>Product Information</h2>
                        <p>
                            We offer a wide range of comfortable footwear for men and women. For detailed product information, please visit our <a href="#">Product page</a>.
                        </p>
                    </section>
                </article>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-links mb-3">
            <a href="#">Return Policy</a> |
            <a href="#">Exchange Policy</a> |
            <a href="#">Shipping Policy</a> |
            <a href="#">Privacy Policy</a> |
            <a href="#">Terms of Service</a> |
            <a href="#">Help</a>
        </div>

        <div class="social-logo mb-3">
            <p class="mb-1">Follow us on social media for the latest updates!</p>
            <img src="/tiptoe/logo/social-media-logo.jpg" alt="Social Media Logos" />
        </div>

        <div class="copyright">
            © 2025 TipToe Soles. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="/tiptoe/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>