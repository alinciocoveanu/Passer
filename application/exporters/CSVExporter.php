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
        
        private static function dataToCSVFile($dataQuery, $filename) {
            $output = fopen($filename, "w");

            fputcsv($output, array('ITEM_ID', 'USER_ID', 'TITLE', 'USERNAME', 'PASSWORD', 'URL', 'COMMENT', 'MAX_TIME'));

            while($row = mysqli_fetch_assoc($dataQuery)) {
                fputcsv($output, $row);
            }

            fclose($output);
        }

        public static function export($dataQuery, $uid) {
            $csv_filename = 'csv_export_'. $uid . '_' . date('Y-m-d') . '.csv';
            CSVExporter::dataToCSVFile($dataQuery, $csv_filename);

            readfile($csv_filename);

            header("Content-type: text/x-csv");
            header("Content-Disposition: attachment; filename=" . $csv_filename . "");
        }
    }

?>