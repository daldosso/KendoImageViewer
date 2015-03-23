<?php

    require_once "config.php";
    $mysqli = new mysqli($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass'],  $_CONFIG['dbname']);
  
/*    $requestBody = file_get_contents('php://input');
    $obj = json_decode($requestBody);
    $op = $obj->{'op'};
    $race = $obj->{'race'};
    $race_name = '';
    $id = $mysqli->real_escape_string($race->{'id'});
    $when = $mysqli->real_escape_string($race->{'when'});
    $where = $mysqli->real_escape_string($race->{'where'});
    $length = $mysqli->real_escape_string($race->{'length'});
    $length2 = $mysqli->real_escape_string($race->{'length2'});
    $length3 = $mysqli->real_escape_string($race->{'length3'});
    $organizer = $mysqli->real_escape_string($race->{'organizer'});
    $type = $mysqli->real_escape_string($race->{'type'});
    $web = $mysqli->real_escape_string($race->{'web'});
    $result = array('success' => 'true');
    if ($op == "C") {
        if ($when == "") {
            $result['success'] = 'false';
            $result['message'] = 'data e ora mancanti';
        } elseif ($where == "") {
            $result['success'] = 'false';
            $result['message'] = 'luogo mancante';
        } else {
            $query = "INSERT INTO mobile_footraces(race_name, race_when, race_where, race_length, 
                                                   race_length2, race_length3, race_organizer, race_website, race_type)
                      VALUES ('$race_name', '$when', '$where', '$length', '$length2', '$length3', '$organizer', '$web', '$type')";
        }
    } elseif ($op == "U") {
            $query = "UPDATE mobile_footraces
                         SET race_name = '$race_name',  
                             race_when = '$when', 
                             race_where = '$where', 
                             race_length = '$length', 
                             race_length2 = '$length2', 
                             race_length3 = '$length3', 
                             race_organizer = '$organizer',
                             race_website = '$web', 
                             race_type = '$type'
                       WHERE id = $id";
    } elseif ($op == "D") {
            $query = "DELETE FROM mobile_footraces WHERE id = $id";

    } else {
    }
    //$mysqli->query($query);
    */
    
    $name = htmlspecialchars($_GET["name"]);
    $url = htmlspecialchars($_GET["url"]);
    if ($name != "") {
        $query = "INSERT INTO kendo_images(name, url, description) VALUES ('$name', '$url', '$name')";
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