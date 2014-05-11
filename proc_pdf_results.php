<?php 
require_once('./includes/process_pdf_fields.inc.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Process PDF: results</title>
	<link href="./css/styles.css" type="text/css" rel="stylesheet">
	<meta charset="utf-8">
</head>
<body>
	<div id="page">
		<!--// PDF field names and field values: //-->
		<?php create_articles($pdf_data); ?>
	</div>
</body>
</html>

