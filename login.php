<?php 
  require_once("conf.php"); 
  require_once("online_counter.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Login</title>

  <?php require_once("blocks/links.php"); //Ссылки на подключаемы в HEAD файлы ?> 
</head>

<body class="d-flex flex-column min-vh-100">
  <div id="app" class="page-content">
    <?php require_once("blocks/header.php"); ?>
    <main class="py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <?php if(isset($_SESSION['reg_ok'])): ?>
            <div class="alert alert-success" role="alert">
              Вы успешно зарегистрированы!
            </div>
            <?php unset($_SESSION['reg_ok']); endif; ?>
            <?php if(isset($_SESSION['auth_err'])): ?>
            <div class="alert alert-danger" role="alert">
              Ошибка авторизации
            </div>
            <?php unset($_SESSION['auth_err']); endif; ?>
            <div class="card">
              <div class="card-header">Авторизация</div>
              <div class="card-body">
                <form method="POST" action="login_h.php">

                  <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail</label>

                    <div class="col-md-6">
                      <input id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>
                      <?php if(isset($_SESSION['lg_fs1'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['lg_fs1']; ?></strong>
                        </span>
                      <?php unset($_SESSION['lg_fs1']); endif; ?>
                    </div>
                  </div> 

                  <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>

                    <div class="col-md-6">
                      <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">
                      <?php if(isset($_SESSION['lg_fs2'])): ?>
                        <span class="inline invalid-feedback" role="alert">
                          <strong><?php echo $_SESSION['lg_fs2']; ?></strong>
                        </span>
                      <?php unset($_SESSION['lg_fs2']); endif; ?>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="rmbr" value="1" id="remember">

                        <label class="form-check-label" for="remember">
                          Запомнить меня
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                      <button type="submit" name="submit" value="press" class="btn btn-primary">
                        Войти
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