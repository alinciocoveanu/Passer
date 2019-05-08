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

        private function dataToXML($dataQuery) {
            $xml = "<?xml version=\"1.0\"?>\n";
        
            // root node
            $xml .= "<items>\n";

            // rows
            while ($row = mysqli_fetch_assoc($dataQuery)) {    
                $xml .= "\t<item>\n"; 
                
                $i = 0;
                // cells
                foreach ($row as $cell) {
                    $col_name = mysqli_field_name($dataQuery, $i);
                    // creates the "<tag>contents</tag>" representing the column
                    $xml .= "\t\t<" . $col_name . ">" . $cell . "</" . $col_name . ">\n";
                    $i++;
                }

                $xml .= "\t</item>\n"; 
            }

            $xml .= "</items>\n";

            return $xml;
        }

        public function export($dataQuery) {
            $xml = $this->dataToXML($dataQuery);
            $xml_filename = 'xml_export_' . date('Y-m-d') . 'xml';

            // export to xml file
            header('Content-type: text/xml');
            header("Content-Disposition: attachment; filename=" . $xml_filename . "");
        }
    }

?>