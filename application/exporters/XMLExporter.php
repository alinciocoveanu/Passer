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

        private static function dataToXML($dataQuery) {
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->formatOutput = True;

            $root = $dom->createElement('items');
            $dom->appendChild($root);

            while($row = mysqli_fetch_assoc($dataQuery)) {
                $node = $dom->createElement('item');

                foreach($row as $key => $val) {
                    $child = $dom->createElement($key);
                    $child->appendChild($dom->createCDATASection($val));
                    $node->appendChild($child);
                }

                $root->appendChild($node);
            }

            return $dom->saveXML();
        }

        public static function export($dataQuery, $uid) {
            $xml = XMLExporter::dataToXML($dataQuery);
            $xml = str_replace("<![CDATA[","",$xml);
            $xml = str_replace("]]>","",$xml);
            $xml_filename = 'xml_export_'. $uid . '_' . date('Y-m-d') . '.xml';

            $myfile = fopen($xml_filename, "w");

            fwrite($myfile, $xml, strlen($xml));

            fclose($myfile);

            readfile($xml_filename);

            // export to xml file
            header('Content-type: text/xml');
            header("Content-Disposition: attachment; filename=" . $xml_filename . "");
        }
    }

?>