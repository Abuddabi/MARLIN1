<?php 
  require_once("conf.php");
  require_once("online_counter.php");
  if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1){
    header("location: /"); exit;
  }
  elseif(!isset($_SESSION['online_id'])){  //|| empty($_SESSION['online_id'])
    setcookie('check_online','', time()-1, '/');
    // unset($_COOKIE['check_online']);
    $self = $_SERVER['PHP_SELF'];
    header("location:$self"); exit;
  } 

  //Фильтруем массив $_SESSION['online_id']. Оставляем только авторизованных
  foreach($_SESSION['online_id'] as $k => $v){
    if($v>0) $online_login[$k] = $v;
  }
  unset($_SESSION['online_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Users</title>

  <?php require_once("blocks/links.php"); //Ссылки на подключаемы в HEAD файлы ?> 
</head>

<body class="d-flex flex-column min-vh-100">
  <div id="app" class="page-content">
    <?php require_once("blocks/header.php"); ?>
    <main class="py-4">
      <div class="container admin">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="float-left">Управление пользователями</h3>
                <a href="admin.php" class="float-right btn btn-success"><button class="unset">Комментарии</button></a>
              </div>
              <?php 
              // echo "<pre>";
              // var_dump($_COOKIE);
              // var_dump($_SESSION);
              // var_dump($_SESSION['online_id']);
              // var_dump($online_login);
              // echo "</pre>";
              ?>

              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Аватар</th>
                      <th>ID</th>
                      <th>Статус</th>
                      <th>Имя</th>
                      <th>E-mail</th>
                      <th>Действия</th>
                    </tr>
                  </thead> 

                  <tbody>
                    <?php 
                    require_once("db2.php"); 
                    //Достаем Пользователей из БД
                    $qr = "SELECT ava, id, name, email, block FROM users_marlin1 ORDER BY id DESC";
                    $stmt = $pdo->query($qr);
                    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //var_dump($users);
                    foreach ($users as $user): ?>
                    <tr>
                      <td>
                        <img src="<?php if(!empty($user['ava'])) echo $user['ava']; else echo "img/no-user.jpg"; ?>" alt="" class="img-fluid" width="64" height="64">
                      </td>
                      <td><?php echo $user['id'];?></td>
                      <td><?php 
                        if(isset($online_login) && array_search($user['id'], $online_login)): ?>
                        <p class="online">online</p>
                        <?php else: ?><p class="offline">offline</p>
                        <?php endif ?>
                      </td>
                      <td><?= $user['name'];?></td>
                      <td><?= $user['email'];?></td>
                      <td>
                        <form class="mw-mc" action="users_h.php" method="post">
                          <?php if($user['block'] == '1'): ?>
                            <a href="" class="mb-2 minw-100 btn btn-success"><button name="unblock" value="<?= $user['id']; ?>" class="unset">Разблокировать</button></a>
                          <?php endif; if($user['block'] == '0'):?>
                            <a href="" class="mb-2 minw-100 btn btn-warning"><button name="block" value="<?= $user['id']; ?>" class="unset">Заблокировать</button></a>
                          <?php endif; ?>
                            <a href="" onclick="return confirm('Are you sure?')" class="minw-100 btn btn-danger"><button name="delete" value="<?php echo $user['id']; ?>" class="unset" >Удалить</button></a>
                        </form>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
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