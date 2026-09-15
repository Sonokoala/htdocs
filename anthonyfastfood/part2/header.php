<?php
require_once __DIR__ . '/debug.php';

// Define debug mode (true for development, false for production)
define('DEBUG_MODE', true);

// Only start session if one hasn't been started already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout check (2 hours)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 7200)) {
    session_unset();
    session_destroy();
    header("Location: login.php?message=session_expired");
    exit;
}
$_SESSION['last_activity'] = time();

require_once 'db.php';

// Function to safely output text
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Verify user is still valid in database
if (isset($_SESSION['email'])) {
    $stmt = $connection->prepare("SELECT staffID FROM staff WHERE email = ? AND staffID = ?");
    if ($stmt) {
        $stmt->bind_param("si", $_SESSION['email'], $_SESSION['staffID']);
        $stmt->execute();
        if (!$stmt->get_result()->fetch_assoc()) {
            // User no longer exists or has been modified
            session_unset();
            session_destroy();
            header("Location: login.php?message=invalid");
            exit;
        }
        $stmt->close();
    }
}

// Get current page name for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' https://cdn.jsdelivr.net; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net;">
    <title>Anthony's Fast Food - Staff Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script>
    console.log('jQuery version:', $.fn.jquery);
    console.log('Bootstrap version:', typeof bootstrap !== 'undefined' ? bootstrap.Tooltip.VERSION : 'Not loaded');
    
    // Global dropdown initialization for Bootstrap 4
    $(document).ready(function() {
        // Initialize dropdowns
        $('.dropdown-toggle').dropdown();
        
        // Add click handlers to all dropdown toggles
        $('.dropdown-toggle').on('click', function(e) {
            console.log('Dropdown clicked:', this.id);
        });
        
        // Fix for Bootstrap 4 dropdowns
        $(document).on('click', '.dropdown-toggle', function(e) {
            var $dropdown = $(this).parent('.dropdown');
            $('.dropdown').not($dropdown).removeClass('show');
            $('.dropdown-menu').not($dropdown.find('.dropdown-menu')).removeClass('show');
            $dropdown.toggleClass('show');
            $dropdown.find('.dropdown-menu').toggleClass('show');
            e.stopPropagation();
        });
        
        // Close dropdowns when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown').removeClass('show');
                $('.dropdown-menu').removeClass('show');
            }
        });
        
        console.log('Global dropdown handlers initialized');
    });
    </script>
</head>
<body>
    <?php 
    if ($current_page !== 'login.php') {
        error_log("========== NAVBAR LOADING ==========");
        error_log("Session data: " . print_r($_SESSION, true));
        error_log("Current page: $current_page");
        error_log("Request URI: " . $_SERVER['REQUEST_URI']);
        
        // Verify session and role before loading navbar
        if (isset($_SESSION['email'], $_SESSION['roleID'])) {
            error_log("User roleID: " . $_SESSION['roleID']);
            error_log("User email: " . $_SESSION['email']);
            
            if ($_SESSION['roleID'] == 1 || $_SESSION['roleID'] == 2) {
                error_log("Loading ADMIN navbar");
                require_once 'navbar_admin.php';
                error_log("Admin navbar loaded successfully");
            } else {
                error_log("Loading USER navbar");
                require_once 'navbar_user.php';
                error_log("User navbar loaded successfully");
            }
        } else {
            error_log("WARNING: No valid session found");
            error_log("Loading DEFAULT navbar");
            require_once 'navbar.php';
            error_log("Default navbar loaded");
        }
    }
    ?>
    <div class="container">
        <?php
        // Display timeout message if redirected from session timeout
        if (isset($_GET['message'])) {
            $message = '';
            switch ($_GET['message']) {
                case 'session_expired':
                    $message = 'Your session has expired. Please log in again.';
                    break;
                case 'invalid':
                    $message = 'Your session is no longer valid. Please log in again.';
                    break;
                case 'login_required':
                    $message = 'Please log in to access this page.';
                    break;
            }
            if ($message) {
                echo '<div class="alert alert-warning">' . h($message) . '</div>';
            }
        }
        ?>
    </div>
</body>
</html>
