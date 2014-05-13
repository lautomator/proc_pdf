<?php 

// Verify the processed file exists.
if (file_exists('./processed/source.txt'))
{
	require_once('./includes/process_pdf_fields.inc.php');
}
else
{
	echo "<p>Processed file does not exist.<br>
		Try uploading again.</p>";
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
		<?php create_articles($pdf_data); ?>
	</div>
</body>
</html>

