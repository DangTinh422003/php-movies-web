<?php 
    header('Access-Control-Allow-Origin: *');
    
    $host = 'localhost';
    $dbName = 'moonvie';
    $username = 'root';
    $password = '';
    set_time_limit(5000);
    
    try{
        $dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $ex){
        die(json_encode(array('status' => false, 'data' => 'Unable to connect: ' . $ex->getMessage())));
    }

    $sql = 'INSERT INTO genre(id, name) VALUES (?, ?)';

    $data = array('key1' => 'value1', 'key2' => 'value2');
    $options = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
            )
        );
    $context  = stream_context_create($options);
    $url = "https://api.themoviedb.org/3/genre/tv/list?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi";
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, TRUE);

    $genres = "genres";
    $id = 'id';
    $name = 'name';

    for($i = 0; $i < count($result[$genres]); $i++){
        $stmt = $dbCon->prepare($sql);
        try{
            $stmt->execute(array($result[$genres][$i][$id], $result[$genres][$i][$name]));
        }
        catch(PDOException $ex){
            continue;
        }
    }

    
?>