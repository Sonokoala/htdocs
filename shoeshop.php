<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tip Toe Soles</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .top-center {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
            padding: 20px 0;
        }

        .sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            padding: 20px 0;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
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
  position: fixed; /* 画面に固定 */
  top: 0;          /* 画面の上端に配置 */
  left: 0;
  width: 100%;     /* 横幅いっぱい */
  background-color: white; /* 背景色はお好みで */
  z-index: 1000;   /* 他の要素より前面に表示 */
}

.top-center {
  text-align: center;
  padding: 20px 0; /* 上下の余白 */
}

        footer {
            margin-left: 200px;
            padding: 20px;
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
            .main-content {
  position: fixed; /* 画面に固定 */
  top: 0;          /* 画面の上端に配置 */
  left: 0;
  width: 100%;     /* 横幅いっぱい */
  background-color: white; /* 背景色はお好みで */
  z-index: 1000;   /* 他の要素より前面に表示 */
}

.top-center {
  text-align: center;
  padding: 20px 0; /* 上下の余白 */
}
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="navbar navbar-light flex-column">
            <span class="sidebar-title">Navigation</span>
            <ul class="navbar-nav flex-column pl-3">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        Home
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Create</a></li>
                        <li><a class="dropdown-item" href="#">Edit</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                        <li><a class="dropdown-item" href="#">Availability</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Staff
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Create</a></li>
                        <li><a class="dropdown-item" href="#">Update</a></li>
                        <li><a class="dropdown-item" href="#">Delete</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Availability</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Logout</a></li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="top-center">
            <h1>Tip Toe Soles</h1>
        </div>
        <!-- Add your main content here -->
    </main>

    <!-- Footer -->
    <footer class="bg-light py-3">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 Tip Toe Soles. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>