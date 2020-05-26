<?php
global $wpdb;

//Get values from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

//Database query 
$rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, ( 3959 * acos( cos( radians($center_lat) ) * cos( radians( x.Latitude ) ) * cos( radians( x.Longitude ) - radians($center_lng) ) + sin( radians($center_lat) ) * sin( radians( x.Latitude ) ) ) ) AS distance, x.Year, y.image as image FROM vicanimalsview x JOIN animal_images y ON x.VernacularName = y.AnimalName HAVING distance < $radius ORDER BY distance LIMIT 0 , 20;");
                  
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
        $newnode->setAttribute("image", $row->image);
        $newnode->setAttribute("year", $row->Year);
    }
    echo $dom->saveXML();
}
?>