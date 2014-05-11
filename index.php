<?php

/*	Add a file through upload. This
	uploader only accepts a PDF doc type.
*/

# set the value of the maximum value of the upload in bytes
$max = 26214400; // 25 mb

# move the file out of its temp location to another location
if (isset($_POST['upload']))
{
	# define the path to the upload folder
	$destination = './uploads/';
	# call the upload class
	require_once('./classes/Upload.php');
	try
	{
		$upload = new Upload($destination);
		$upload->setMaxSize($max);
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
		<form action="" method="post" 
		enctype="multipart/form-data" id="uploadImage">
			<p>
				<label for="image"><strong>&#10112;</strong> Upload PDF:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
				<input type="file" name="image[]" id="image" multiple>
				<br><br>
				<input type="submit" name="upload" id="upload" value="Upload">
			</p>

			<?php
			# return messages
			if (isset($result))
			{
				foreach ($result as $message)
				{
					echo "<p><em>$message</em></p>";
				}
			}
			?>
			<p class="hrule"></p>
			
			<p>
				<label><strong>&#10113;</strong> Process PDF:</label>
				<input type="submit" name="process" id="process" 
					value="Process">
			</p>

		</form>
	</div>
</body>
</html>
