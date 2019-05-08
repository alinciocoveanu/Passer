<?php
    // include interface file
    define('DS4', DIRECTORY_SEPARATOR);
    define('ROOT4', dirname(dirname(__FILE__)));

    require_once(ROOT4 . DS4 . 'exporters' . DS4 . 'IExporter.php');

    class JSONExporter implements IExporter {
        
        //private constructor
        private function __construct() {
            //
        }

        private function dataToJSON($dataQuery) {
            $json_array = array();

            while ( $row = mysqli_fetch_assoc($dataQuery)) {
	            $json_array[] = $row;
            }

            $json = json_encode($json_array);
            return $json;
        }

        public function export($dataQuery) {
            $json = $this->dataToJSON($dataQuery);
            $json_filename = 'json_export_' . date('Y-m-d') . 'json';

            // export to json file
            header('Content-type: application/json');
            header("Content-Disposition: attachment; filename=" . $json_filename . "");
        }
    }

?>