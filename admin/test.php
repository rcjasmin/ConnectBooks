<?php
//echo "Reginald";
//print_r($json); 

//echo "Reginald";
/*session_start();
if ($_POST) {
    $data = $_POST['data'];
    echo $data;
    $obj = json_decode($data);
    setcookie("beconnect", $data);
    // $_COOKIE['beconnect'] = $obj->USERNAME ;
    echo $_SESSION[$obj->USERNAME];
} else {

    echo $_COOKIE['beconnect'];
}
*/

/*
 * $db = Database::getInstance();
 *
 * $rs = $db->select("SELECT * FROM innov_boule_tirees");
 *
 * while ($record = $rs->fetchObject()) {
 * echo '<br/>' . $record->LOTO3 . " " . $record->LO2 . " " . $record->LO3;
 * }
 * $rs->closeCursor();
 */

?>
<!DOCTYPE html>
<html>
<head>


</head>
  <body>
    <div id="test">
       <p><font size="3" color="red">This is p one</font></p>
       <p id="test1"><font size="10" color="green">More Text to be printed on PDF</font></p>
  
    </div>
    
<a href="javascript:generatePDF()">Dowload PDF</a>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
<script type="text/javascript">
function generatePDF() {
	 var doc = new jsPDF();  //create jsPDF object
	  doc.fromHTML(document.getElementById("test1"), // page element which you want to print as PDF
	  15,
	  15, 
	  {
	    'width': 170  //set width
	  },
	  function(a) 
	   {
	    doc.save("HTML2PDF.pdf"); // save file name as HTML2PDF.pdf
	  });
	}
</script>
  </body>
</html>