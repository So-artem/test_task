<?php
    header("Location: index.php");

    if (isset($_POST['review']))
    {
      
      if ($_POST['name'] != null and $_POST['surname'] != null and $_POST['email'] != null and$_POST['telephone']!= null  and $_FILES['file']['size'] != 0 )
        // AND $_FILES['file']['size']<=2621440
      {
        //проверяем функцией is_uploaded_file 
        if(is_uploaded_file($_FILES['file']['tmp_name']))  
          { 
      $xml = new DomDocument("1.0","UTF-8");
      
      $xml_info = new SplFileInfo('peopleDB.xml');

      if((int)$xml_info->getSize() > 0)
      {
        $xml->load('peopleDB.xml');


        $root = $xml->getElementsByTagName("root")->item(0);
        $info = $xml->createElement("info");
          $root->appendChild($info);

          $sxml = simplexml_load_file("peopleDB.xml");
              foreach($sxml->info as $value)
              { 
                $lastID= "$value->id";
              }
          $lastID++;
        $ID = $xml->createElement("id", $lastID);

        $name=$xml->createElement("name", $_POST['name']);

        $surname=$xml->createElement("surname", $_POST['surname']);

        $email=$xml->createElement("email", $_POST['email']);

        $telephone=$xml->createElement("telephone", $_POST['telephone']);


        $info->appendChild($ID);
        $info->appendChild($name);
        $info->appendChild($surname);
        $info->appendChild($email);
        $info->appendChild($telephone);

        $xml->save('peopleDB.xml');
        
        resize($_FILES['file'], $lastID);
      }
    }}
    die();
}

function resize($file, $id)
{
if ($file['type'] == 'image/jpeg')
 $source = imagecreatefromjpeg ($file['tmp_name']);
elseif ($file['type'] == 'image/png')
 $source = imagecreatefrompng ($file['tmp_name']);
elseif ($file['type'] == 'image/gif')
 $source = imagecreatefromgif ($file['tmp_name']);
else
 return false;

$w_src = imagesx($source); 
$h_src = imagesy($source);

$dest = imagecreatetruecolor(300, 300);
imagecopyresampled ($dest, $source , 0 , 0 , 0 , 0 , 300 , 300 , $w_src, $h_src );

imagejpeg($dest, "uploades/".$id.'.jpg');

imagedestroy($dest);
imagedestroy($source);

 return true;
}
