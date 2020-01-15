<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="img/logo.jpg" width="40px" alt="logo"> 
      Abudabi
    </a>

    <!--**********МОБИЛЬНОЕ МЕНЮ**********-->
      <a class="unset main-item mmenu" href="javascript:void(0);">
            <span class="mmenu navbar-toggler-icon"></span>
      </a>
      <div class="sub-mmenu">
      <?php if (isset($_SESSION['name'])) : ?>	
        <a class="dropdown-item" href="profile.php">Профиль</a>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] ==1) : ?>
        <a class="dropdown-item" href="admin.php">Админ панель</a><?php endif; ?>
        <a class="dropdown-item" href="logout_h.php">Выход</a>
      <?php else : ?>
       <a class="dropdown-item" href="login.php">Login</a>
       <a class="dropdown-item" href="register.php">Register</a>
      <?php endif; ?>   
      </div>

    

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto"> </ul>

      <!--**********ОСНОВНОЕ МЕНЮ**********-->
      <?php if (isset($_SESSION['name'])) : ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item position-relative">
            <a class="h5 nav-link dropdown-toggle main-item" id="navbarDropdownMenuLink" href="javascript:void(0);" tabindex="1"><b><?php echo $_SESSION['name']; ?></b></a>
            <div class="dropdown-menu sub-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="profile.php">Профиль</a>
              <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] ==1) : ?>
              <a class="dropdown-item" href="admin.php">Админ панель</a><?php endif; ?>
              <a class="dropdown-item" href="logout_h.php">Выход</a>
            </div>
          </li>
        </ul>
      <?php elseif (!isset($_SESSION['name']) && empty($_COOKIE['email']) && empty($_COOKIE['pass'])) : ?>
        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
          </li>
        </ul>
      <?php endif ?>
    </div>
  </div>
</nav>