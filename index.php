<?php 
  require_once("conf.php");
  require_once("online_counter.php");
  //ПАГИНАЦИЯ
  $qr = "SELECT COUNT(*) FROM comments WHERE comments.status = 1";
  $stmt = $pdo->query($qr);
  $all_notes = $stmt->fetchColumn(); //Количество всех записей из БД
  $notes_to_page=3; //Количество записей на 1 странице
  $numb_of_pages = ceil($all_notes/$notes_to_page); //Количество страниц
  if(isset($_GET['page'])){
    if($_GET['page']>$numb_of_pages || $_GET['page']<1 || !is_numeric($_GET['page'])) $_GET['page']=1;
    $page=$_GET['page'];
  }
  else $page=1;
  $from=($page-1)*$notes_to_page; //Отсчёт для SQL
  // var_dump($_SESSION);
  // echo "<br>";
  // var_dump($_COOKIE);
function var_D($var_d){
  echo "<pre>";
  var_dump($var_d);
  echo "</pre>";
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="yandex-verification" content="b3df8e221b86855f" />
  <title>Project</title>

  <?php require_once("blocks/links.php"); //Ссылки на подключаемы в HEAD файлы ?> 
</head>

<body class="d-flex flex-column min-vh-100">
  <div id="app" class="page-content">
    <?php 
      require_once("blocks/header.php");
    ?>
    <main class="py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3>Комментарии</h3>
              </div>
              <div class="card-body">
                <?php
                // var_D($_SESSION);
                // var_D($_COOKIE);
                //КОММЕНТАРИИ
                $qr="SELECT comments.comm, comments.date, users_marlin1.name, users_marlin1.ava
                FROM comments
                LEFT JOIN users_marlin1
                ON comments.user_id = users_marlin1.id
                WHERE comments.status = 1
                ORDER BY comments.id DESC
                LIMIT :from, :numb";
                $stmt = $pdo->prepare($qr);
                $stmt->bindParam(':from',$from, PDO::PARAM_INT);
                $stmt->bindParam(':numb',$notes_to_page, PDO::PARAM_INT);
                $stmt->execute();
                if ($stmt->rowCount()<1): ?>
                <div class="alert alert-secondary mt-2" role="alert">
                  <span>Комментариев пока что нет. Вы можете быть первым.</span>
                </div>
                <?php endif;
                $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                // var_dump($comments); exit;
                foreach($comments as $comm): ?>
                <?php if (isset($_SESSION['comm_sent'])) : 
                  // Флешка об успешной отправке сообщения ?>
                  <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['comm_sent']; ?>
                  </div>
                  <?php unset($_SESSION['comm_sent']);
                    endif; ?>
                  <div class="media">
                    <img src="<?php if(!empty($comm['ava'])) echo $comm['ava']."?".time(); else echo "img/no-user.jpg"; ?>" class="mr-3" alt="..." width="64" height="64">
                    <div class="media-body">
                      <h5 class="mt-0"><?= $comm['name'];?></h5>
                      <span><small><?= $comm['date']; ?></small></span>
                      <p><?= $comm['comm']; ?></p>
                    </div>
                  </div>
                  <?php endforeach; ?>
              </div>
              <?php  //КНОПКИ ПАГИНАЦИИ  
              if ($stmt->rowCount()>0) : //Пагинация только, если есть записи ?>
                <nav aria-label="...">
                  <ul class="ml-3 pagination">
                  <?php //СТРЕЛКА ВЛЕВО ?>
                    <li class="page-item">
                      <a class="page-link" href="?page=<?php if($page>1)echo($page-1); else echo 1;?>"><<</a>
                    </li><?php
                    //КНОПКИ
                    $numb_of_butt = 3; //Количество кнопок
                    if($page==1){
                      $i=$page;
                      if($numb_of_pages<$numb_of_butt) $pag=$numb_of_pages-1;
                      else $pag=2;
                    }
                    elseif($page==$numb_of_pages){
                      if($numb_of_pages<$numb_of_butt) $i=$page-1;
                      else $i=$page-2;
                      $pag=0;
                    }
                    else{
                      $i=$page-1;
                      $pag=1;
                    }
                    for($i;$i<=$page+$pag;$i++): ?>
                    <li class="page-item<?php if($i==$page)echo " active"; ?>">
                      <a class="page-link" href="?page=<?=$i;?>"><?=$i;?></a>
                    </li>
                    <?php endfor;
                    //СТРЕЛКА ВПРАВО ?>
                    <li class="page-item">
                      <a class="page-link" href="?page=<?php if($page<$numb_of_pages)echo($page+1); else echo $numb_of_pages;?>">>></a>
                    </li>
                  </ul>
                </nav>
              <?php endif; ?>
            <div>
          </div>

          <div class="col-md-12" style="margin-top: 20px;">
            <div class="mb-3 card">
              <div class="card-header">
                <h3>Оставить комментарий</h3>
              </div>

              <div class="card-body">
                <form action="index_h.php" method="post">
                  <?php if (!isset($_SESSION['name'])) : ?>
                    <div class="alert alert-primary mt-2" role="alert">
                      <span>Чтобы оставить комментарий, <a class="font-weight-bold" href="login.php">авторизуйтесь</a>.</span>
                    </div>
                  <?php else: ?>
                  <div class="form-group">
                    <label for="exampleFormControlTextarea1">Сообщение</label>
                    <textarea name="text-comm" class="form-control" id="exampleFormControlTextarea1" required rows="3"></textarea>
                    <?php if (isset($_SESSION['fsmsg2'])) : ?>
                      <div class="alert alert-danger mt-2" role="alert">
                        <?php echo $_SESSION['fsmsg2']; ?>
                      </div> 
                    <?php unset($_SESSION['fsmsg2']); endif; ?>
                  </div>
                  <button type="submit" name="submit" value="press" class="btn btn-success">Отправить</button>
                </form>
                <?php endif; ?>
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
