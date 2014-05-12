<?php

/* 	Dump the data from the uploaded PDF 
	into a text file using using PDFtk. */

// Sanitize the input.
$args = escapeshellargs($user_file_for_upload);
try
{
	$source = system("pdftk user_pdf.pdf dump_data_utf8 output source.txt", 
	$complete;
}
catch
{
	
}

if (isset($complete))
{
	echo $complete . '<br>';
}
*/