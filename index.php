<?php

/*	Add a file through upload. This
	uploader only accepts a PDF doc type.
*/

# set the value of the maximum value of the upload in bytes
$max = 151200;

# move the file out of its temp location to another location
if (isset($_POST['upload']))
{
	# define the path to the upload folder
	$destination = './uploads/';
	# call the upload class
	require_once('./classes/Upload.php');
	try
	{
		$upload = new Ps2_Upload($destination);
		$upload->setMaxSize($max);
		$upload->addPermittedTypes(array('application/pdf'));
		$upload->move(true);
		$result = $upload->getMessages();	
	}
	catch (Exception $e)
	{
		echo $e->getMessage();
	}
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
		<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
		<p>
			<label for="image">Upload PDF:</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
			<input type="file" name="image[]" id="image" multiple>
			<br><br>
			<input type="submit" name="upload" id="upload" value="Upload" >
		</p>

			<?php
		# return messages
		if (isset($result))
		{
			echo '<ul>';
			foreach ($result as $message)
			{
				echo "<p><li>$message</li></p>";
			}
			echo '</ul>';
		}
		?>
		</form>
	</div>
</body>
</html>
