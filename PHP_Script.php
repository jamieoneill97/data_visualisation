<?php

$xml = new XMLReader();
$write = new XMLWriter();

$inputFiles = array("brislington.xml","fishponds.xml","parson_st.xml","rupert_st.xml","wells_rd.xml","newfoundland_way.xml");

$writeFiles = array("brislington_no2.xml","fishponds_no2.xml","parson_st_no2.xml","rupert_st_no2.xml","wells_rd_no2.xml","newfoundland_way_no2.xml");

$locationWrite = array("Brislington", "Fishponds", "Parsons street", "Rupert street", "Wells road", "Newfoundland way");

for($x=0; $x<6; $x++){
    
    $xml->open($inputFiles[$x]); //open file
    
    $write->openURI($writeFiles[$x]);
    
    $write->startDocument('1.0', 'UTF-8'); //Start doc xml 1.0
    $write->setIndent(4); //Set indent 4
    
    $write->startElement('data'); //start element data
    $write->writeAttribute('type', 'nitrogen dioxide'); //Write att no2 
    $write->startElement('location'); //start loc
    $write->writeAttribute('id', $locationWrite[$x]); //write one attribute location id
    
    $written = false;
    
    while($xml -> read()){
        
        if($xml ->nodeType == XMLReader::ELEMENT && 'row' == $xml->name){
            
            $q=0;
            
            while($xml->read() && $q<5){
                if('lat' == $xml-> name && $xml->nodeType == XMLReader::ELEMENT){
                    $lat=$xml -> getAttribute("val"); 
                    $q++;
                }
                    
                else if ('long' == $xml-> name && $xml->nodeType == XMLReader::ELEMENT){
                    $long=$xml -> getAttribute("val"); 
                    $q++;
                }
                    
                else if ('date' == $xml-> name && $xml->nodeType == XMLReader::ELEMENT){
                    $date=$xml -> getAttribute("val"); 
                    $q++;
                }
                    
                else if ('time' == $xml-> name && $xml->nodeType == XMLReader::ELEMENT){
                    $time=$xml -> getAttribute("val"); 
                    $q++;
                }
                    
                else if ('no2' == $xml-> name && $xml->nodeType == XMLReader::ELEMENT){
                    $no2=$xml -> getAttribute("val"); 
                    $q++;
                    
                } //else if
                
            } //end while 
            
            
            if($written == false){    
            $write->writeAttribute('lat', $lat); //Write latitude for location
            $write->writeAttribute('long', $long); //Write longitude for location
            $written = true;
            }
             
            $write->startElement('reading'); //start element! Reading
            $write->writeAttribute('date', $date);
            $write->writeAttribute('time', $time);
            $write->writeAttribute('val', $no2);
            $write->endElement(); //End element
            
        } //end if
        
    
    } //end read while
    
    $write->endElement(); //end element for loc
    $write->endElement(); //end element for data
    
    $write->flush();
    $xml ->close(); //close xml reader    
    
} //end for

echo "Finished!";

?>