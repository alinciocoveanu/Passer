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
        
        private function dataToCSV($dataQuery) {
            $csv_export = '';
            $field = mysqli_field_num($dataQuery);

            for($i = 0; $i < $field; $i++) {
                $csv_export .= mysqli_field_name($dataQuery, $i) . ',';
            }

            $csv_export .= '
            ';

            while($row = mysqli_fetch_array($dataQuery)) {
                for($i = 0; $i < $field; $i++) {
                    $csv_export .= '"' . $row[mysqli_field_name($dataQuery, $i)] . '",';
                }
                $csv_export .= '
                ';
            }

            return $csv_export;
        }

        public function export($dataQuery) {
            $csv = $this->dataToCSV($dataQuery);
            $csv_filename = 'csv_export_' . date('Y-m-d') . 'csv';

            header("Content-type: text/x-csv");
            header("Content-Disposition: attachment; filename=" . $csv_filename . "");
        }
    }

?>