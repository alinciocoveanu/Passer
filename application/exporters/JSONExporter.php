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

        private static function dataToJSON($dataQuery) {
            $json_array = array();

            while ( $row = mysqli_fetch_assoc($dataQuery)) {
                array_push($json_array, $row);
            }

            $json = json_encode($json_array, JSON_PRETTY_PRINT);
            return $json;
        }

        public static function export($dataQuery, $uid) {
            $json = JSONExporter::dataToJSON($dataQuery);
            $json_filename = 'json_export_'. $uid . '_' . date('Y-m-d') . '.json';

            $myfile = fopen($json_filename, "w");

            fwrite($myfile, $json, strlen($json));

            fclose($myfile);

            readfile($json_filename);
            // export to json file
            header('Content-type: application/json');
            header("Content-Disposition: attachment; filename=" . $json_filename . "");
        }
    }

?>