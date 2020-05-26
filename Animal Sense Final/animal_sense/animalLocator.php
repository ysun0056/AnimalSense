<?php
echo "I am called";
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Search the rows in the markers table
$query = sprintf("SELECT VernacularName, Latitude, Longitude, ( 3959 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < '%s' ORDER BY distance LIMIT 0 , 20",
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($center_lng),
  mysql_real_escape_string($center_lat),
  mysql_real_escape_string($radius));
$rows = $wpdb->get_results($query);
                    
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
                    $newnode->setAttribute("distance", $row->distance);
                }
            
                echo $dom->saveXML();
            }
            else 
            {
                //Condition if no animal found
                echo "There are no endangered animals in the specified radius. Please increase the radius :)";
            }
?>