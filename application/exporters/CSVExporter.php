<?php
    // include interface file
    define('DS3', DIRECTORY_SEPARATOR);
    define('ROOT3', dirname(dirname(__FILE__)));

    require_once(ROOT3 . DS3 . 'exporters' . DS3 . 'IExporter.php');

    class CSVExporter implements IExporter {

        //private constructor
        private function __construct() {
            //
        }
        
        private function dataToCSV($data) {
            return $csv;
        }

        public function export($data) {
            $csv = $this->dataToCSV($data);

            // export to xml file
        }
    }

?>