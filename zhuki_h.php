<?php
  session_start();
  function dihlofos3000($kamney, $zhukov){
    $svobodno = $kamney-1;
   
    $zhuki['zhuk1']=1;
    $zhuki['sleva1']=floor($svobodno/2);
    $zhuki['sprava1']=ceil($svobodno/2);   
    $zhuki['razdelitel1']="=============================";

    for($i=2;$i<=$zhukov;$i++){
      $zhuki['zhuk'.$i]=1;

      if($i==2) $svobodno = $zhuki['sprava1']-1;
      elseif($i%2==0) $svobodno = $zhuki['sprava'.($i-2)]-1;
      else $svobodno = $zhuki['sleva'.($i-2)]-1;

      $zhuki['sleva'.$i] = floor($svobodno/2);
      if($zhuki['sleva'.$i]<0 || $zhuki['sleva'.$i]==-0) $zhuki['sleva'.$i] = 0;
      $zhuki['sprava'.$i] = ceil($svobodno/2);
      if($zhuki['sprava'.$i]<0 || $zhuki['sprava'.$i]==-0) $zhuki['sprava'.$i] = 0;
      $zhuki['razdelitel'.$i]="=============================";
    }
    // echo "<pre>"; print_r($zhuki); exit;

    $skolko['sleva']=$zhuki['sleva'.$zhukov];
    $skolko['sprava']=$zhuki['sprava'.$zhukov];

    return $skolko;
  }
  // $otvet = dihlofos3000(8, 3);
  $otvet = dihlofos3000($_POST['kamney'], $_POST['zhukov']);
  $_SESSION['otvet'] = $otvet;
  $_SESSION['zhuki']['kamney'] = $_POST['kamney'];
  $_SESSION['zhuki']['zhukov'] = $_POST['zhukov'];

  // echo "<pre>"; print_r($_SESSION['otvet']); exit;
  header("location: zhuki.php");
?>