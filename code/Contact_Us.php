<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - TipToe Soles</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        /* Maintain the original styles */
        .logo {
            max-width: 200px; /* Set maximum width */
            height: auto;     /* Height adjusts automatically */
            display: block;   /* Make the logo a block element */
            margin: 0 auto;  /* Center align the logo */
        }

        .sidebar {
            height: 100vh; /* Fixed height for the sidebar */
            width: 250px;  /* Fixed width */
            background-color: #fff;
            position: fixed; /* Keep it fixed on the screen */
            border-right: 1px solid #ddd;
        }

        .sidebar-title {
            font-size: 20px;
            font-weight: bold;
            padding: 15px;
        }

        .nav-link {
            font-size: 16px;
            padding: 10px;
            text-decoration: none;
            color: #333;
            display: block; /* Make links block elements */
        }

        .nav-link:hover {
            background-color: #f8f9fa; /* Highlight on hover */
        }

        .nav-link.active {
            font-weight: bold; /* Highlight active link */
            color: #007bff;    /* Color for active link */
        }

        .container {
            margin-left: 260px; /* Adjust margin for the sidebar width */
            padding-bottom: 100px; /* Space for footer */
        }

        footer {
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
        }

        /* Styles for the contact form */
        .contact-form {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-control:focus {
            border-color: #007bff; /* Highlight on focus */
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
        }
    </style>
</head>

<body>
<!-- Logo displayed in header, centered -->
<header class="text-center py-4">
    <img src="http://localhost/logo/TipToe_Soles_Logo_colour.png" alt="TipToe Soles Logo" class="img-fluid logo">
</header>

<!-- Sidebar navigation -->
<div class="sidebar">
    <nav class="navbar navbar-light flex-column">
        <span class="sidebar-title">Menu</span>
        <ul class="navbar-nav flex-column pl-3">
            <li class="nav-item"><a class="nav-link" href="http://localhost/shoeshop.php">Home</a></li> <!-- Link to Home -->
            <li class="nav-item"><a class="nav-link" href="http://localhost/about_us.php">About Us</a></li> <!-- Link to About Us -->
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
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" class="form-control" id="subject" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea class="form-control" id="message" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
        
        <!-- Right sidebar for contact information -->
        <div class="col-md-4">
            <div class="contact-info mt-4">
                <h3>Our Contact Information</h3>
                <p>
                    <strong>Email:</strong><br>
                    support@tiptoesoles.com
                </p>
                
                <p>
                    <strong>Phone:</strong><br>
                    +61 123 456 789
                </p>
                
                <p>
                    <strong>Address:</strong><br>
                    123 Comfort Lane<br>
                    Sydney, Australia
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light py-3 text-center">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <a href="#">Return Policy</a> |
                <a href="#">Exchange Policy</a> |
                <a href="#">Shipping Policy</a> |
                <a href="#">Privacy Policy</a> |
                <a href="#">Terms Of Service</a>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-12">
                <p>&copy; 2025 TipToe Soles. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>