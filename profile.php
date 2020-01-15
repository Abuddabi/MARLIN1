<?php 
  require_once("conf.php");
  require_once("online_counter.php");
  // var_dump($_SESSION);
  if(!isset($_SESSION['name']) && empty($_COOKIE['email']) && empty($_COOKIE['pass'])) {
    header('location: /'); exit;
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Profile</title>

  <?php require_once("blocks/links.php"); //Ссылки на подключаемы в HEAD файлы ?> 
</head>

<body class="d-flex flex-column min-vh-100">
  <div id="app" class="page-content">
    <?php require_once("blocks/header.php"); ?>

    <main class="py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3>Профиль пользователя</h3>
              </div>
              <?php
                // var_dump($_SESSION);
              ?>

              <div class="card-body">
                <?php if (isset($_SESSION['update'])) : ?>
                  <div class="alert alert-success" role="alert">
                    Профиль успешно обновлен
                  </div>
                <?php unset($_SESSION['update']);
                endif; ?>

                <form action="profile_h.php" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Name</label>
                        <input type="text" class="form-control" name="name" value="<?php if (isset($_SESSION['name'])) echo $_SESSION['name']; ?>">
                        <?php if (isset($_SESSION['prof_fs1'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['prof_fs1']; ?>
                          </span>
                        <?php unset($_SESSION['prof_fs1']); endif; ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">Email</label>
                        <input type="email" class="form-control" name="email" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
                        <?php if (isset($_SESSION['prof_fs2'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['prof_fs2']; ?>
                          </span>
                        <?php endif; unset($_SESSION['prof_fs2']); ?>
                      </div>

                      <div class="form-group">
                        <p>Аватар</p>
                        <!-- <label class="custom-file-upload">
                          <input name="image" type="file"/>
                          <i class="fa fa-cloud-upload"></i> Выбрать файл
                        </label> -->
                        
                        <div class="custom-file" style="overflow: hidden;">
                          <input type="file" class="custom-file-input" name="image" id="exampleFormControlInputfile">
                          <label class="custom-file-label" id="exampleFormControlInputfile">Выберите изображение</label>
                        </div>

                        <!-- <input type="file" class="form-control" name="image"> -->
                        <?php if (isset($_SESSION['prof_fs3'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['prof_fs3']; ?>
                          </span>
                        <?php unset($_SESSION['prof_fs3']); endif; ?>
                      </div>
                    </div>
                    <div class="mt-4 col-md-4">
                      <img src="<?php if(isset($_SESSION['ava'])) echo $_SESSION['ava']."?".time(); else echo "img/no-user.jpg"; ?>" alt="" class="img-fluid">
                    </div> 

                    <div class="col-md-12">
                      <button type="submit" name="submit" value="press" class="btn btn-warning">Edit profile</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-12" style="margin-top: 20px;">
            <div class="card">
              <div class="card-header">
                <h3 id="pass">Безопасность</h3>
              </div>

              <div class="card-body">
                <?php if(isset($_SESSION['update_pass'])): ?>
                  <div class="alert alert-success" role="alert">
                    Пароль успешно обновлен
                  </div>
                <?php unset($_SESSION['update_pass']); endif; ?>

                <form action="profile_h2.php" method="post">
                  <div class="row">
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="exampleFormControlInput1">Current password</label>
                        <input type="password" name="current" class="form-control" required>
                        <?php if (isset($_SESSION['pass_fs1'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['pass_fs1']; ?>
                          </span>
                        <?php unset($_SESSION['pass_fs1']); endif; ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">New password</label>
                        <input type="password" name="password" class="form-control" required>
                        <?php if (isset($_SESSION['pass_fs2'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['pass_fs2']; ?>
                          </span>
                        <?php unset($_SESSION['pass_fs2']); endif; ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlInput1">Password confirmation</label>
                        <input type="password" name="password_conf" class="form-control" required>
                        <?php if (isset($_SESSION['pass_fs3'])) : ?>
                          <span class="text text-danger">
                            <?php echo $_SESSION['pass_fs3']; ?>
                          </span>
                        <?php unset($_SESSION['pass_fs3']); endif; ?>
                      </div>

                      <button name="submit" value="press" class="btn btn-success">Submit</button>
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