<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">Navigation Bar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Home Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="homeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Home
          </a>
          <ul class="dropdown-menu" aria-labelledby="homeDropdown">
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'home.php') echo 'active'; ?>" href="/anthonyfastfood/part2/home.php">Home</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'create.php') echo 'active'; ?>" href="/anthonyfastfood/part2/create.php">Create</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'edit.php') echo 'active'; ?>" href="/anthonyfastfood/part2/edit.php">Edit</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'delete.php') echo 'active'; ?>" href="/anthonyfastfood/part2/delete.php">Delete</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'availability.php') echo 'active'; ?>" href="/anthonyfastfood/part2/availability.php">Availability</a></li>
          </ul>
        </li>
        <!-- Manage Staff Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="manageStaffDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Manage Staff
          </a>
          <ul class="dropdown-menu" aria-labelledby="manageStaffDropdown">
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'staff_create.php') echo 'active'; ?>" href="/anthonyfastfood/part2/staff_create.php">Create</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'staff_update.php') echo 'active'; ?>" href="/anthonyfastfood/part2/staff_update.php">Update</a></li>
            <li><a class="dropdown-item <?php if(basename($_SERVER['PHP_SELF']) == 'staff_delete.php') echo 'active'; ?>" href="/anthonyfastfood/part2/staff_delete.php">Delete</a></li>
          </ul>
        </li>
        <!-- Availability Link -->
        <li class="nav-item">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF']) == 'availability.php') echo 'active'; ?>" href="/anthonyfastfood/part2/availability.php">Availability</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="btn btn-outline-dark ms-2" href="/anthonyfastfood/logout.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
