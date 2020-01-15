<?php
  session_start();
  
  // var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>Задачка</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="mt-3 mb-5" style="width:max-content; margin: 0 auto;">Сколько было камней и жуков</h1>
        <form action="zhuki_h.php" method="post">
          <div class="form-group row">
            <label for="kamney" class="col-md-4 col-form-label text-md-right">Камней: </label>
            <div class="col-md-6">
              <input id="kamney" name="kamney" type="number" min="1" max="4000000000" 
              <?php if(isset($_SESSION['zhuki']['kamney'])): ?>
              value="<?=$_SESSION['zhuki']['kamney'];?>"
              <?php unset($_SESSION['zhuki']['kamney']); 
                endif;
              ?> class="form-control">
            </div>  
          </div>

          <div class="form-group row">
            <label for="zhukov" class="col-md-4 col-form-label text-md-right">Жуков: </label>
            <div class="col-md-6">
              <input id="zhukov" name="zhukov" type="number" min="1" max="4000000000"
              <?php if(isset($_SESSION['zhuki']['zhukov'])): ?>
              value="<?=$_SESSION['zhuki']['zhukov'];?>"
              <?php unset($_SESSION['zhuki']['zhukov']); 
                endif;
              ?> class="form-control"></input>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-8 offset-md-4">  
              <button name="submit" value="press" class="btn btn-success" type="submit">Submit</button>
            </div>
          </div>
        </form>
        <?php if (isset($_SESSION['otvet'])) : 
        // Флешка об успешной отправке сообщения ?>
        <div class="alert alert-success" role="alert">
          <?php echo "Слева: ".$_SESSION['otvet']['sleva'].", Справа: ".$_SESSION['otvet']['sprava'] ; ?>
        </div>
        <?php unset($_SESSION['otvet']);
          endif; ?>
      </div>
    </div>
  </div>
</body>
</html>