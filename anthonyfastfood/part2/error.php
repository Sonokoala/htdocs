<?php
require_once 'header.php';

$errorCode = $_GET['code'] ?? '404';
$errorMessage = '';
$errorDescription = '';

switch ($errorCode) {
    case '403':
        $errorMessage = 'Access Denied';
        $errorDescription = 'You do not have permission to access this page.';
        break;
    case '500':
        $errorMessage = 'Internal Server Error';
        $errorDescription = 'An unexpected error occurred. Please try again later.';
        break;
    default:
        $errorMessage = 'Page Not Found';
        $errorDescription = 'The page you are looking for does not exist. Please check the URL and try again.';
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body text-center">
                <h1 class="display-1 text-muted"><?= $errorCode ?></h1>
                <h2 class="card-title mb-4"><?= htmlspecialchars($errorMessage) ?></h2>
                <p class="card-text"><?= htmlspecialchars($errorDescription) ?></p>
                <div class="mt-4">
                    <a href="home.php" class="btn btn-primary">Return to Home</a>
                    <?php if (!isset($_SESSION['staffID'])): ?>
                        <a href="login.php" class="btn btn-outline-primary ms-2">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?> 