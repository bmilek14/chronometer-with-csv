<html>
<head>
<script src="lib/ObjectEventTarget.js"></script>
<script src="chronometer.js"></script>
<script src="lib/jquery-1.11.1.min.js"></script>
<script src="lib/moment.js"></script>
<script src="demo.js"></script>
<script src="lib/table2csv.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$(document).ready(function () {
  $('table').each(function () {
      var $table = $(this);

      var $button = $("<button type='button'>");
      $button.text("Export to spreadsheet");
      $button.insertAfter($table);

      $button.click(function () {
          var csv = $table.table2CSV({
              delivery: 'value'
          });
          window.location.href = 'data:text/csv;charset=UTF-8,' 
          + encodeURIComponent(csv);
      });
  });
})
</script>
</head>
<body>
  <img src="ups.png"width = "200px" height="100px">
<h1>UPS RFX & PLD Chronometr</h1>
<p>
  <input type="button" value="start" id="start" />
  <input type="button" value="pause" id="pause" />
  <input type="button" value="stop" id="stop" />
  <input type="button" value="step" id="step" />
</p>
<p>
<strong>startTime:</strong> <span id="startTime"></span>
</p>
<p>
<strong>relative:</strong> <span id="relative"></span>
</p>
<p>
<strong>stopTime:</strong> <span id="stopTime"></span>
</p>
<p>
<ul id="steps"></ul>
</p>
<p>
  <form method="post">
		<input type="text" name="rows[0][]" />
		<input type="text" name="rows[0][]" />
		<input type="text" name="rows[0][]" />
		<hr />
		<input type="text" name="rows[1][]" />
		<input type="text" name="rows[1][]" />
		<input type="text" name="rows[1][]" />
		<hr />
		<input type="submit" />
	</form>
  <?php

if (isset($_POST['rows'])) {
	
	$h = tmpfile();
	foreach ($_POST['rows'] as $row) {
	    fputcsv($h, array_values($row));
	}
	rewind($h);
	$csv = '';
	while (($row = fgets($h)) !== false) {
            $csv .= $row;
        }
	fclose($h);
	
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	echo $csv;
	exit;
	
}

?>
</p>
</body></html>
