<?php
global $wpdb;
$state = $_GET["state"];

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
//echo $state;
if($state == "All State")
{
     $rows = $wpdb->get_results("SELECT DISTINCT(Class) FROM animal_images;");
}
else
{
     $rows = $wpdb->get_results("SELECT DISTINCT(Class) FROM allanimals WHERE State='$state';");
}

       



     $rowCount = $wpdb->num_rows;
            //Check if retrieved row is greater than 0 then display values in table
            if($rowCount > 0)
            {
                
                header("Content-type: text/xml");
                // Iterate through the rows, adding XML nodes for each
                foreach($rows as $row){
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", $row->Class);                 
                }
            
                //echo "DONE";  
                echo $dom->saveXML();
            }
            else 
            {
                //Condition if no animal found
                echo "data not pass";
            }









?>