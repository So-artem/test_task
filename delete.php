<?php
    header("Location: index.php");
    
    $xml = new DomDocument("1.0","UTF-8");
    $xml->load('peopleDB.xml');

    $cname = $_POST['deleteHidden'];
    $xpath = new DomXpath($xml);

    foreach ($xpath->query("/root/info[id = '$cname']") as $node) 
    {
        $node->parentNode->removeChild($node);
    }

    $xml->formatoutput = true;
    $xml->save('peopleDB.xml');
    unlink ("uploades/$cname.jpg");
    
    die();
