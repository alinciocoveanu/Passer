<?php
    // include interface file
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once(ROOT . DS . 'application' . DS . 'exporters' . DS . 'IExporter.php');

    class JSONExporter implements IExporter {
        
        //private constructor
        private function __construct() {
            //
        }

        private function dataToJSON($data) {
            $dbdata = array();

            while ( $row = $data->mysqli_fetch_assoc())  {
	            $dbdata[] = $row;
            }

            $json = json_encode($dbdata);
            return $json;
        }

        public function export($data) {
            $json = $this->dataToJSON($data);

            // export to json file
        }
    }

?>