<?php

/*  Dump the data from the uploaded PDF into a text file using using PDFtk.
    See: http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/
    for more information. This must be installed on the server.
*/

// The source file:
$proc_source = './uploads/source.pdf';

// Sanitize the input.
$command = escapeshellcmd(
    "pdftk $proc_source dump_data_fields_utf8 output ./processed/source.txt"
);
