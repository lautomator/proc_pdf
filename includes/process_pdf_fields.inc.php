<?php

/* 	This script uses field names and values
	from a PDF and passes that information to
	an HTML template. The PDF is such that it 
	contains fields; the filled fields are
	dumped to a text file. This script is 
	specifically looking for the the FieldName
	and FieldValue properties from the data
	dump. Those fields are specific to the 
	template and values will be used to populate
	the corresponding areas of the HTML template. 

	Author: John Merigliano | April 2014 */

/*	============================================ */

// 	Dump the data from the uploaded PDF into a text file.
/*
// Sanitize the input.
$args = escapeshellargs($user_file_for_upload);
try
{
	$source = system("pdftk user_pdf.pdf dump_data_utf8 output source.txt", 
	$complete);
}
catch
{
	
}

if (isset($complete))
{
	echo $complete . '<br>';
}
*/


// 	Open the text file.
$src = file('./processed/test.txt');

/*	Match specific field keys so that we can
	extract the data from those fields only. */
$field_name = preg_grep('/FieldName:\s/', $src);
$field_value = preg_grep('/FieldValue:\s/', $src);

// 	These arrays will store the processed data.
$f_names = array();
$f_values = array();

// 	Extract the names of the fields.
foreach($field_name as $fn)
{
	/*	Remove the field header, leave the value, 
		and trim any trailing chars. */
	$tmp = trim(str_replace('FieldName:', '', $fn));
	// Add it to the $f_names array.
	array_push($f_names, $tmp);
}
// 	Extract the field values and add them to the values array.
foreach($field_value as $fv)
{
	/*	Remove the field header, leave the value, 
		and trim any trailing chars. */
	$tmp = trim(str_replace('FieldValue:', '', $fv));
	// Add it to the $f_values array.
	array_push($f_values, $tmp);
}	

/*	Combine the arrays: the f_names will be
	keys and the f_values will be the values. */
$pdf_data = array_combine($f_names, $f_values);

function create_articles($pdf_data)
{
	// 	Traverse the keys and print the corresponding keys and values.
	while ($key = key($pdf_data))
	{
		// 	Print the field names and values.
		echo "<h1><strong>" . key($pdf_data) . "</strong></h1>" . 
			"<p>" . current($pdf_data) . "</p>";
		next($pdf_data);
	}
}

?>
