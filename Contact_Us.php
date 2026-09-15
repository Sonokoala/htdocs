<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us - TipToe Soles</title>

    <!-- Bootstrap CSS (local) -->
    <link rel="stylesheet" href="../bootstrap-5.3.5-dist/css/bootstrap.min.css" />

    <!-- Custom CSS with relative path -->
    <link rel="stylesheet" href="../css/contact-style.css" />
</head>

<body>
<!-- Logo displayed in header, centered -->
<header class="text-center py-4">
    <img src="../logo/TipToe_Soles_Logo_colour.png" alt="TipToe Soles Logo" class="img-fluid logo" />
</header>

<!-- Sidebar navigation -->
<div class="sidebar">
    <nav class="navbar navbar-light flex-column">
        <span class="sidebar-title">Menu</span>
        <ul class="navbar-nav flex-column ps-3">
            <li class="nav-item"><a class="nav-link" href="shoeshop.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about_us.php">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Log in</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Wishlist</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
        </ul>
    </nav>
</div>

<!-- Main content - Contact form and Contact Information -->
<div class="container my-5">
    <h1>Contact Us</h1>
    <p class="lead">Get in touch with us for any inquiries or support.</p>

    <div class="row">
        <div class="col-md-8">
            <div class="contact-form">
                <form id="contactForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="name" required />
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" required />
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" />
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject *</label>
                        <input type="text" class="form-control" id="subject" required />
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control" id="message" rows="5" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Right sidebar for contact information -->
        <div class="col-md-4 mt-4 mt-md-0">
            <div class="contact-info">
                <h3>Our Contact Information</h3>
                <p>
                    <strong>Email:</strong><br />
                    support@tiptoesoles.com
                </p>

                <p>
                    <strong>Phone:</strong><br />
                    +61 123 456 789
                </p>

                <p>
                    <strong>Address:</strong><br />
                    123 Comfort Lane<br />
                    Sydney, Australia
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light py-3 text-center">
    <div class="container">

        <!-- Social Media Follow section -->
        <div class="row mt-3">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <p class="mb-0 me-2">Follow us on social media for the latest updates!</p>
                <!-- Social media icons with relative path -->
                <img src="../2.jpg" alt="Social Media Logos" style="max-width: 100px; height: auto;" />
            </div>
        </div>

        <!-- Policy links -->
        <div class="row">
            <div class="col-12">
                <a href="#" onclick="showReturnPolicy()">Return Policy</a> |
                <a href="#" onclick="showExchangePolicy()">Exchange Policy</a> |
                <a href="#" onclick="showShippingPolicy()">Shipping Policy</a> |
                <a href="#" onclick="showPrivacyPolicy()">Privacy Policy</a> |
                <a href="#" onclick="showTermsOfService()">Terms of Service</a>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row mt-3">
            <div class="col-12">
                <p>&copy; 2025 Tip Toe Soles. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript for policy alerts -->
<script>
    function showReturnPolicy() { alert("Return Policy details go here."); }
    function showExchangePolicy() { alert("Exchange Policy details go here."); }
    function showShippingPolicy() { alert("Shipping Policy details go here."); }
    function showPrivacyPolicy() { alert("Privacy Policy details go here."); }
    function showTermsOfService() { alert("Terms Of Service details go here."); }
</script>

<!-- Bootstrap JS Bundle (local) -->
<script src="../bootstrap-5.3.5-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>