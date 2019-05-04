<?php
    // include interface file
    define('DS5', DIRECTORY_SEPARATOR);
    define('ROOT5', dirname(dirname(__FILE__)));

    require_once(ROOT5 . DS5 . 'exporters' . DS5 . 'IExporter.php');

    class XMLExporter implements IExporter {
        
        //private constructor
        private function __construct() {
            //
        }

        private function dataToXML($dataArray) {
            $xml= "<?xml version=\"1.0\"?>\n";
            $xml.= "\n";

            for($r = 0; $r < mysqli_num_rows($data); $r++) {
                $row = mysqli_fetch_assoc($data);
                $xml = "\t\n" . $data . "";
            }

            $xml.= "";

            return $xml;
        }

        public function export($data) {
            $xml = $this->dataToXML($data);

            // export to xml file
        }
    }

?>