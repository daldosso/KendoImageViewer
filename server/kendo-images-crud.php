<?php
    require_once "config.php";
    $mysqli = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'],  $_CONFIG['dbname']);
  
    $name = htmlspecialchars($_GET["name"]);    
    $id = htmlspecialchars($_GET["id"]);
    $url = htmlspecialchars($_GET["url"]);
    if ($name != "") {
        $query = "INSERT INTO kendo_images(name, url, description) VALUES ('$name', '$url', '$name')";
        $mysqli->query($query);
    } else if ($id != "") {
        $query = "DELETE FROM kendo_images WHERE id = $id AND id > 5";
        $mysqli->query($query);
    } else {
        $data = array();    
        $sql = "SELECT * FROM kendo_images"; 
        if ($result = $mysqli->query($sql)) { 
            while($obj = $result->fetch_object()) {
                $data[] = array(
                  'id' => $obj->id,
                  'name' => $obj->name,
                  'url' => $obj->url,
                  'description' => $obj->description
                );                    
            } 
        } 
        $result->close();    
        echo "callback(" . json_encode($data) . ");";    
    }

?>