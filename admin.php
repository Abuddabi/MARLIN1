<?php 
  require_once("conf.php");
  require_once("online_counter.php");
  if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] != '1'){
    header("location: /"); exit;
  } 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Admin</title>

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
                <h3 class="float-left">Управление комментариями</h3>
                <a href="users.php" class="float-right btn btn-success"><button class="unset">Пользователи</button></a>
              </div>
              <?php 
                // var_dump($_SESSION); 
              ?>

              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Аватар</th>
                      <th>ID</th>
                      <th>Имя</th>
                      <th>Дата</th>
                      <th>Комментарий</th>
                      <th>Действия</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php 
                      require_once("db2.php"); 
                      //Достаем комментарии из БД
                      $qr = "SELECT comments.id, comments.date, comments.comm, comments.status, users_marlin1.name, users_marlin1.ava
                      FROM comments
                      LEFT JOIN users_marlin1
                      ON comments.user_id = users_marlin1.id
                      ORDER BY comments.id DESC";
                      $stmt = $pdo->query($qr);
                      $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($comments as $comm) :
                    ?>
                    <tr>
                      <td>
                        <img src="<?php if(!empty($comm['ava'])) echo $comm['ava']; else echo "img/no-user.jpg"; ?>" alt="" class="img-fluid" width="64" height="64">
                      </td>
                      <td><?php echo $comm['id'];?></td>
                      <td><?php echo $comm['name'];?></td>
                      <td><?php echo $comm['date'];?></td>
                      <td><?php echo $comm['comm'];?></td>
                      <td>
                        <form class="mw-mc" action="admin_h.php" method="post">
                          <?php if($comm['status']=='0'): ?>
                            <a href="" class="mb-2 minw-100 btn btn-success"><button name="allow" value="<?php echo $comm['id']; ?>" class="unset">Разрешить</button></a>
                          <?php endif; if($comm['status']=='1'):?>
                            <a href="" class="mb-2 minw-100 btn btn-warning"><button name="forbid" value="<?php echo $comm['id']; ?>" class="unset">Запретить</button></a>
                          <?php endif; ?>
                            <a href="" onclick="return confirm('Are you sure?')" class="minw-100 btn btn-danger"><button name="delete" value="<?php echo $comm['id']; ?>" class="unset" >Удалить</button></a>
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