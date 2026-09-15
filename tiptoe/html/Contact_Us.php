<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us - TipToe Soles</title>

    <!-- Bootstrap CSS -->
    <link href="/tiptoe/bootstrap-5.3.5-dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
        /* Base Layout */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: sans-serif;
        }

        /* Header */
        .logo {
            max-width: 200px;
            height: auto;
        }

        /* Content Layout */
        .container-fluid {
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-right: 1px solid #ddd;
            height: 100%;
        }

        /* Navigation */
        .nav-link {
            color: #333;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            border-radius: 4px;
        }

        .nav-link:hover {
            background-color: #e9ecef;
        }

        .nav-link.active {
            color: #007bff !important;
            background-color: #e9ecef;
            font-weight: 500;
        }

        /* Contact Form */
        .contact-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-label {
            font-weight: 500;
        }

        /* Contact Info Box */
        .contact-info {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid #dee2e6;
        }

        /* Footer */
        footer {
            background-color: #f8f9fa;
            padding: 1.5rem;
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
            margin-top: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                border-right: none;
                border-bottom: 1px solid #ddd;
                margin-bottom: 1rem;
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
            <aside class="col-md-3 sidebar">
                <nav>
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item"><a class="nav-link" href="#">Menu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tiptoe/html/shoeshop.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="/tiptoe/html/about_us.php">About Us</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Products</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Comfort Shoes</a></li>
                                <li><a class="dropdown-item" href="#">Accessories</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Wishlist</a></li>
                        <li class="nav-item"><a class="nav-link active" href="/tiptoe/html/Contact_Us.php">Contact Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                    </ul>
                </nav>

                <div class="contact-info">
                    <h4>Contact Information</h4>
                    <address class="mt-3">
                        <strong>Email:</strong><br>
                        <a href="mailto:support@tiptoesoles.com">support@tiptoesoles.com</a><br><br>
                        <strong>Phone:</strong><br>
                        <a href="tel:+61123456789">+61 123 456 789</a><br><br>
                        <strong>Address:</strong><br>
                        123 Comfort Lane<br>
                        Sydney, Australia
                    </address>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-md-9 py-4">
                <div class="contact-form">
                    <h1>Contact Us</h1>
                    <p class="lead mb-4">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>

                    <form id="contactForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone">
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control" id="subject" required>
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">Send Message</button>
                    </form>
                </div>
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
            <img src="/tiptoe/logo/social-media-logo.jpg" alt="Social Media Logos">
        </div>

        <div class="copyright">
            © 2025 TipToe Soles. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="/tiptoe/bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>