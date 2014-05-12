<?php

// Class for uploading files specific to this proc_pdf.
class Upload_proc_pdf
{
	// Data fields:
	protected $_uploaded = array();
	protected $_destination;
	protected $_max = 151200;
	protected $_messages = array();
	protected $_permitted = array('application/pdf');
	protected $_renamed = false;

	// Constructor: 
	public function __construct($path)
	{
		if (!is_dir($path) || !is_writable($path))
		{
			throw new Exception("$path must be a valid, writable directory.");
		}
		$this->_destination = $path;
		$this->_uploaded = $_FILES;
	}

	/* 	Function to move the uploaded file to the upload folder
		but not before passing error and security checks. */
	public function move($overwrite = true)
	{
		$field = current($this->_uploaded);
		if (is_array($field['name']))
		{
			foreach ($field['name'] as $number => $filename)
			{
				// process multiple upload
				$this->_renamed = false;
				$this->processFile($filename, $field['error'][$number],
					$field['size'][$number], $field['type'][$number],
					$field['tmp_name'][$number], $overwrite);
			}
		}
		else
		{
			$this->processFile($field['name'], $field['error'], $field['size'], 
				$field['type'], $field['tmp_name'], $overwrite);
		}

	}
	
	// return $_messages
	public function getMessages()
	{
		return $this->_messages;
	}
	
	// All file sizes are checked in bytes. This method returns the $max
	// size in kB; this can be changed to suit whichever increment is
	// preferred (perhaps MB, or GB)
	public function getMaxSize()
	{
		// Since $max is measured in bytes, 
		// dividing $max by 1024 yields kB
		return number_format($this->_max/1024, 1) . 'kB';
	}

	// Will add types of files permitted on upload. See the 
	// isValidMime function below.
	public function addPermittedTypes($types)
	{
		// cast the $types var as an array
		$types = (array) $types;
		// check on a valid MIME Type
		$this->isValidMime($types);
		// merge the permitted and $types arrays
		$this->_permitted = array_merge($this->_permitted, $types);
	}

	// set the permitted types of MIME types
	public function setPermittedTypes($types)
	{
		// cast the $types var as an array
		$types = (array) $types;
		// check on a valid MIME Type
		$this->isValidMime($types);
		// replaces all of the existing values of _permitted
		$this->_permitted = $types;
	}

	// Check the max size of the file type and verify that it is a number.
	// I am not sure why it would not be a number but here we go anyway.
	public function setMaxSize($num)
	{
		if (!is_numeric($num))
		{
			throw new Exception("Maximum size must be a number.");	
		}
		// cast _max as an integer
		$this->_max = (int) $num;
	}

	// Process the file upload.
	protected function processFile($filename, $error, $size, $type,
		$tmp_name, $overwrite)
	{
		// subject files to error checks (see functions below)
		$OK = $this->checkError($filename, $error);
		// If the error checks return true, then move the files and
		// return a message to the user, validating the upload action.
		if ($OK)
		{
			// perform the acutal checks
			$sizeOK = $this->checkSize($filename, $size);
			$typeOK = $this->checkType($filename, $type);
			// if both of the above conditions are met commence with the upload
			if ($sizeOK && $typeOK)
			{
				$name = $this->checkName($filename, $overwrite);
				$success = move_uploaded_file($tmp_name, $this->_destination .
					$name);
				// determine if a successful upload has occured
				if ($success)
				{
					$message = $filename . ' uploaded successfully.';
					$this->_messages[] = $message;
				} 

			}
				else
				{
					$this->_messages[] = 'Could not upload ' . $filename . '.';
				}	
		}	
	}

	// Define the acceptable types of files for upload; this can
	// be changed depending on what you wish to allow a user to do.
	protected function isValidMime($types)
	{
		// added to the existing array stated in the data fields
		$alsoValid = array('application/pdf');
		// merge the _permitted and $alsoValid arrays
		$valid = array_merge($this->_permitted, $alsoValid);
		// Run through the array and check the types; throw an 
		// exception if the type is not permittd.
		foreach ($types as $type)
		{
			if (!in_array($type, $valid))
			{
				throw new Exception("$type is not a permitted file type.");
			}
		}
	}

	// check the MIME type (ie, what kind of file is being uploaded?)
	protected function checkType($filename, $type)
	{
		// If the file attempting to be uploaded is empy or does not match any
		// of the file types within the array of acceptable formats, return
		// an error message.
		if (empty($type))
		{
			return false;
		}
		elseif (!in_array($type, $this->_permitted))
		{
			$this->_messages[] = "$filename is not a permitted type of file.";
			return false;
		}
		// otherwise the file is an allowable type
		else
		{
			return true;
		}
	}

	// check for errors
	protected function checkError($filename, $error)
	{
		switch ($error)
		{
			// upload succesfull
			case 0:
				return true;
			// file is larger than amount allowed
			case 1:
			case 2: 
				$this->_messages[] = "$filename exceeds maximum size: " .
					$this->getMaxSize();
				return true;
			// partial upload only
			case 3:
				$this->_messages[] = "Error uploading $filename. Please try again.";
				return false;
			// no specified file submitted
			case 4:
				$this->_messages[] = 'No file selected.';
			// default error covers 6 - 8; no reason to delineate them here
			// as these are sysadmin type errors; for example: no upload directory
			default:
				$this->_messages[] = "System error.";
				return false;
		}
	}

	// check the size of the file
	protected function checkSize($filename, $size)
	{
		// file cannot be 0
		if ($size == 0)
		{
			return false;
		}
		// file cannot exceed the maximum amount specified
		elseif ($size > $this->_max)
		{
			$this->_messages[] = "$filename exceeds maximum size: " . 
				$this->getMaxSize();
			return false;
		}
		// file is within the specified size allowed
		else 
		{
			return true;
		}
	}


	// Rename the file, as it is specific to this application.
	protected function checkName($name, $overwrite)
	{
		$this->_renamed = true;
		$newname = 'source.pdf';
		
		// determine if overwriting is being attempted
		if (!$overwrite)
		{
			// Overwrite the file if it already exists
			$existing = scandir($this->_destination);
			if (in_array($existing))
			{
				$this->renamed = true;
			}
		}
		// Return the new name to the uploaded PDF.
		return $newname;
	}

}// End of Upload_proc_pdf class
