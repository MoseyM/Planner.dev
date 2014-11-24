<?php
class Filestore
{ 
    protected $filename = '';
    protected $isCSV;

    public function __construct($filename)
    {
        $this->filename = $filename;
        if(substr($filename, -3) == 'csv'){
            $this->isCSV = true;
        } else {
            $this->isCSV = false;
        }
    }

    public function read() {
        if ($this->isCSV) {
            return $this->readCSV();
        } else {
            return $this->readLines();
        }
    }

    public function write($array) {
        $this->isCSV ? $this->writeCSV($array) : $this->writeLines($array);
    }

    protected function readCSV() 
    {
        $array = [];
        $fileLocation = $this->filename;
        $handle = fopen($fileLocation, 'r');
        if (file_exists($fileLocation) && filesize($fileLocation)>0) {
            while(!feof($handle)) {
                $row = fgetcsv($handle);
                if (!empty($row)) {
                $array[] = $row;
                }
            }
        }
        fclose($handle);
        return $array;
    }
    protected function readLines()
    {
        $array = [];
        if (filesize($this->filename)>0) {
            $handle = fopen($this->filename, 'r');
            $contents = fread($handle, filesize($this->filename));
            $array=explode("\n", $contents);
            fclose($handle);
        }
        return $array;
    }

    protected function writeLines($array)
    {
        $handle = fopen($this->filename, 'w');
        $newInfos = implode("\n", $array);
        fwrite($handle, $newInfos);
        fclose($handle);
    }
    
    protected function writeCSV($array) 
    {
        $handle=fopen($this->filename, 'w');
        foreach ($array as $wholeList => $value) {
            fputcsv($handle, $value);
        }
        fclose($handle);
    }

    public function testType() 
    {
        if ($_FILES['file1']['type'] == 'text/csv') {
            $uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
            // filename var is giving the file name with extension
            $filename = basename($_FILES['file1']['name']);
            $savedFilename = $uploadDir.$filename;
            //the file is saved temporarily so we are moving it from the temp location to a permanent location which file address and name with extension was creted with the $savedFilename var.
            move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
            //need to create a new object for the new filename. File hasn't been converted to an array yet.
            $this->filename=$savedFilename;
            $newInfo = $this->readLines();
            $this->addresses = array_merge($this->addresses, $newInfo);
            $this->writeLines();
          } else {
            echo "<p> Please attach a csv file</p>";
          }
    }
}