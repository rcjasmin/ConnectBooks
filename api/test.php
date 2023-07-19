<?php 
$dbh = new PDO('sqlite:mydb.sdb');
echo "test";
//date_default_timezone_set('America/New_York');
/*$date = new DateTimeImmutable();
//$milli = (int)$date->format('Uv'); // Timestamp in milliseconds
//$micro = (int)$date->format('Uu'); // Timestamp in microseconds

//echo $milli, "\n", $micro, "\n";
*/
//$date = date('d-m-Y h:i:s A') ;

//echo $current_time = date("H:i:s");;

//$numeroTrx =generateNDigitRandomNumber(9);
//echo $numeroTrx ;

  //   function generateNDigitRandomNumber($length){
   //	return mt_rand(pow(10,($length-1)),pow(10,$length)-1);
    // }


//phpinfo();

//$ver = SQLite3::version();

//echo $ver['versionString'] . "\n";
//echo $ver['versionNumber'] . "\n";

//var_dump($ver);

//unlink('mysqlitedb.db');
/*$db = new SQLite3('mysqlitedb.db');

/*$db->exec('CREATE TABLE foo (id INTEGER, bar STRING)');
$db->exec("INSERT INTO foo (id, bar) VALUES (2, 'This is a test')");
$db->exec("INSERT INTO foo (id, bar) VALUES (3, 'This is a test')");
*/

//$stmt = $db->prepare('SELECT bar FROM foo');
//$stmt->bindValue(':id', 1, SQLITE3_INTEGER);

//$result = $stmt->execute();
//var_dump($result->fetchArray());


/*if($stmt = $db->prepare("SELECT * FROM foo"))
 {
         $result = $stmt->execute();
         $names=array();

         while($arr=$result->fetchArray(SQLITE3_ASSOC))
         {
          //$names[$arr['id']]=$arr['student_name'];
          echo $arr['bar'];
         }
}*/

?>
