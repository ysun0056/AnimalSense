<?php
global $wpdb;
//echo "I am called";
//echo $center_lat;
//echo $center_lng;
//echo $radius;
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, x.Year, y.image as image FROM vicanimalsview x JOIN animal_images y ON x.VernacularName = y.AnimalName;");
                  
            //Get number of rows in the result
            $rowCount = $wpdb->num_rows;
            //Check if retrieved row is greater than 0 then display values in table
            if($rowCount > 0)
            {
                
                header("Content-type: text/xml");
                // Iterate through the rows, adding XML nodes for each
                foreach($rows as $row){
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", $row->VernacularName);
                    $newnode->setAttribute("lat", $row->Latitude);
                    $newnode->setAttribute("lng", $row->Longitude);
                    $newnode->setAttribute("image", $row->image);
                    $newnode->setAttribute("year", $row->Year);
                }
            
                //echo "DONE";  
                echo $dom->saveXML();
            }
            else 
            {
                //Condition if no animal found
                echo "There are no endangered animals in the specified radius. Please increase the radius :)";
            }
?>