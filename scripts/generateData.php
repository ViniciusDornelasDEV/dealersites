<?php 
  $conn = mysqli_connect('localhost', 'root', '', 'bd_dealer_sites');
  if($conn->connect_error) {
    die("Connection failed: " . $this->conexao->connect_error);
  }

  //require fake data
  require_once '../vendor/fzaninotto/faker/src/autoload.php';
  $faker = Faker\Factory::create();
  
  //insert users
  for ($i=1; $i <= 7000; $i++) { 
    $active = 1;
    if($i > 6500){
      $active = 0;
    }
    $sql = 'INSERT INTO users (name, email, active) VALUES ("'.$faker->name.'", "'.$faker->email.'", '.$active.');';
    if(mysqli_query($conn, $sql) == false){
      echo 'Erro ao cadastrar usuario '.$i."\n";
      die($sql);
    }
    echo $i.' - Usuario inserido!'."\n";
  }

  //generate random date and insert acess
  $firstDate = strtotime(date("2010-m-d H:m:s"));
  $lastDate = strtotime(date("Y-m-d H:m:s"));
  for ($i=1; $i <= 20000; $i++) { 
    $date = date("Y-m-d H:i:s",mt_rand($firstDate,$lastDate));
    $sql = 'INSERT INTO users_acess (last_login, users_id) VALUES ("'.$date.'", '.mt_rand(1, 7000).');';
    if(mysqli_query($conn, $sql) == false){
      echo 'Erro ao cadastrar acesso '.$i."\n";
      die($sql);
    }
    echo $i.' - Acesso inserido!'."\n";
  }


  die('FIM DO SCRIPT!');
?>