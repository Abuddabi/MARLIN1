<?php 
require_once("conf.php");
require_once("online_counter.php");
function var_pre($var_d)
{
  echo "<pre>";
  var_dump($var_d);
  echo "</pre>";
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Register</title>

  <?php require_once("blocks/links.php"); //Ссылки на подключаемы в HEAD файлы ?> 
</head>

<body class="d-flex flex-column min-vh-100">
  <div id="app" class="page-content">
  <?php require_once("blocks/header.php"); ?>
    <main class="py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">Register</div>
              <div class="card-body">
                <form method="POST" action="register_h.php">

                  <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                    <div class="col-md-6">
                      <input id="email" type="email" class="form-control" name="email" required autofocus>
                      <?php if(isset($_SESSION['reg_fs1'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['reg_fs1']; ?></strong>
                        </span>
                      <?php unset($_SESSION['reg_fs1']); endif; ?>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                    <div class="col-md-6">
                      <input id="name" type="text" class="form-control" name="name">
                      <?php if(isset($_SESSION['reg_fs2'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['reg_fs2']; ?></strong>
                        </span>
                      <?php unset($_SESSION['reg_fs2']); endif; ?>
                    </div>
                  </div> 

                  <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                    <div class="col-md-6">
                      <input id="password" type="password" class="form-control " name="password" autocomplete="new-password">
                      <?php if(isset($_SESSION['reg_fs3'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['reg_fs3']; ?></strong>
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                    <div class="col-md-6">
                      <input id="password-confirm" type="password" class="form-control" name="password_conf" autocomplete="new-password">
                      <?php if(isset($_SESSION['reg_fs3'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['reg_fs3']; ?></strong>
                        </span>
                      <?php unset($_SESSION['reg_fs3']); endif; ?>
                    </div>
                  </div>

                  <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                      <button type="submit" name="submit" value="press" class="btn btn-primary">
                        Register
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <?php require("blocks/footer.php"); ?>
</body>

</html>