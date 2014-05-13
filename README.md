This script uses field names and values from a PDF and passes 
that information to an HTML page. The PDF is such that it 
contains fields; the filled fields are dumped to a text file 
using PDFtk. See: 
http://www.pdflabs.com/tools/pdftk-the-pdf-toolkit/
for more information. This must be installed on a server. 
This script is specifically looking for the the FieldName
and FieldValue properties from the data dump. Those fields 
are specific to the template and values will be used to 
populate the corresponding areas of the HTML template.

Author: John Merigliano | April 2014 

