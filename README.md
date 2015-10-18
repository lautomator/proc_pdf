# Process a PDF

## Summary and Requirements
This script collects field names and corresponding values from a PDF and passes that information to an HTML page for display. The filled fields from the PDF are dumped to a text file using [PDFtk](http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/])

The script is specifically looking for the the *FieldName* and *FieldValue* properties from the data dump. Those fields correspond to the template and values will be used to populate the HTML template.

##Setup
1. *PDFtk* must be installed on a server or in your development environment. See the [PDFLabs](http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/) for more information and installation instructions.

2. You will also need a local development environment with PHP. [MAMP](https://www.mamp.info/en/) or [XAMPP](https://www.apachefriends.org/index.html) will work fine.

3. Clone this repository. The file structure needed for this to work is already set up. You can use the sample PDF file in the next step to test how this works: `sample.pdf`.

4. Open the `sample.pdf` file and add some data to the fields. Save the PDF (you can rename it).

5. Open `index.html` from your browser and upload the PDF. Follow the directions and see your data added to a web page.

##Applications
This is simply a starting point for an array of applications.