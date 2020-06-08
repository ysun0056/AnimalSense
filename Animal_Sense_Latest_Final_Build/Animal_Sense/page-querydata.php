<?php
	global $wpdb;

    $ID = $_GET["ID"];

	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);

    //join table to query the data
	$values = $wpdb->get_results("SELECT x.VernacularName, x.Latitude, x.Longitude,x.Year, x.IndividualCount, x.Address, y.ID as id FROM allanimals x JOIN animal_images y ON x.VernacularName LIKE y.AnimalName WHERE ID='$ID'");


	 $rowNumber = $wpdb->num_rows;
            //Check if retrieved row is greater than 0 then display values in table
            if($rowNumber > 0)
            {
                
                header("Content-type: text/xml");
                // Iterate through the rows, adding XML nodes for each
                foreach($values as $va){
                    $node = $dom->createElement("marker");
                    $newnode = $parnode->appendChild($node);
                    $newnode->setAttribute("name", $va->VernacularName);
                    $newnode->setAttribute("lat", $va->Latitude);
                    $newnode->setAttribute("lng", $va->Longitude);                  
                    $newnode->setAttribute("id", $va->id);
                    $newnode->setAttribute("add",$va->Address);
                    $newnode->setAttribute("year",$va->Year);
                    $newnode->setAttribute("count",$va->IndividualCount);
                  }
            
                echo $dom->saveXML();
            }
            else{
                echo "data not pass";
            }
?>

