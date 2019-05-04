<?php
    // include interface file
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once(ROOT . DS . 'application' . DS . 'exporters' . DS . 'IExporter.php');

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