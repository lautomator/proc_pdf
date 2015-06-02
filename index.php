<?php

// Add a file through upload. This
// uploader only accepts a PDF doctype.

// Set the value of the maximum value of the upload in bytes.
$max = 26214400; // 25 mb

// Process the upload.
if (isset($_POST['upload'])) {

    // Define the path to the upload folder.
    $destination = './uploads/';
    // Require the upload class.

    include_once './classes/Upload_Proc_Pdf.php';
    try {

        $upload = new Upload_Proc_Pdf($destination);
        $upload->setMaxSize($max);
        $upload->setPermittedTypes('application/pdf');
        $upload->move(true);
        $result = $upload->getMessages();
        $next = $upload->verifyUpload();
    }
    catch (Exception $e) {

        echo $e->getMessage();
    }
}

// Process the uploaded PDF.
if (isset($_POST['process'])) {
    // Dump the PDF data to a text file.
    include_once './includes/process_pdf_dump.inc.php';

    //  Execute the data fields dump using PDFtk
    try {

        $proc_pdf = system($command, $results);

    } catch (Exception $e) {

        echo "<p>This is not the correct type of PDF.<br>
            PDF must have \"fillable\" fields.</p>";

    }

    // Go to results page.
    header("Location: ./proc_pdf_results.php");
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
                <label for="image"><strong>Upload PDF</strong></label><br><br>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>">
                <input type="file" name="image[]" id="image" single><br><br>
                <input type="submit" name="upload" id="upload" value="Upload">
            </p>

            <?php
            // Verify a PDF is uploaded before moving to next step.
            if (isset($result)) {

                foreach ($result as $message) {

                    echo "<p><em>$message</em></p>";

                }
// If the file has been moved to the upload
// directory and renamed, then it has passed all
// of the security checks; we are now ready to
// proceed with the prompt to process the PDF. */

                if ($next) {

                ?>

                <p class="hrule"></p>
                <p>
                    <label><strong>Process PDF</strong></label><br><br>
                    <input type="submit" name="process" id="process"
                        value="Process">
                </p>
                <?php
                }
            }
            ?>
        </form>
    </div>
</body>
</html>
