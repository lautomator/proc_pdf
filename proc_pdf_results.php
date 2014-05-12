<?php 
if (file_exists('./processed/test.txt'))
{
	require_once('./includes/process_pdf_fields.inc.php');
	$go_ahead = true;
}
else
{
	$errors = array();
	$go_ahead = false;
}


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
		<?php
		if ($go_ahead)
		{
			create_articles($pdf_data);
		}

		 

		?>
	</div>
</body>
</html>

