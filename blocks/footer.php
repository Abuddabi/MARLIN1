<footer class="footer py-3 mt-4 bg-white">
  <div class="container">
    <small>Copyright &copy; 2020</small>
    <div>
      <small class="d-block">Пользователей онлайн: 
      <?php 
        // unset($_SESSION['total_online']);
        if(!isset($_SESSION['total_online'])): 
        ?><a id="count" href="<?=$_SERVER['PHP_SELF']?>">
            <img id="reload" width="12px" src="img/reload.png">
          </a><?php
        else:
          echo $_SESSION['total_online']; 
        endif; ?>
      </small>
    </div>
  </div>
</footer>
