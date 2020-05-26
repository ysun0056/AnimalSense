<?php
global $wpdb;

//get values from URL
$state = $_GET["state"];
$class = $_GET["class"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

//Check state and class values to filter database results
if ($state == "All State") {
    if ($class == "All Class")
    {
        $rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, x.Year, y.image as image, y.ID as id FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName;");
    }
    else
    {
        $rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, x.Year, y.image as image, y.ID as id FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.Class='$class';");
    }
}
else{
    if ($class == "All Class")
    {
        $rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, x.Year, y.image as image, y.ID as id FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state';");
        
    }
    else
    {
        $rows = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude, x.Year, y.image as image, y.ID as id FROM allanimals x JOIN animal_images y ON x.VernacularName = y.AnimalName WHERE x.State='$state' AND x.Class='$class';");
        
    }
}

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
        $newnode->setAttribute("year", $row->Year);
        $newnode->setAttribute("image", $row->image);                    
        $newnode->setAttribute("id", $row->id);
    }
              
    echo $dom->saveXML();
}
?>