<?php

    $host = 'localhost';
    $dbName = 'moonvie';
    $username = 'root';
    $password = '';
    set_time_limit(5000);

    try {
        $dbCon = new PDO("mysql:host=" . $host . ";dbname=" . $dbName, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $ex) {
        die(json_encode(array('status' => false, 'data' => 'Unable to connect: ' . $ex->getMessage())));
    }

    $getId = 'SELECT imdb_id from movie';
    $sql = 'INSERT INTO imdb_rating VALUES(?, ?, ?)';

    $handle = fopen("rating.txt", "r");
    $data = [];
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $parts = explode("\t", $line);
            $data[$parts[0]] = $parts[1].",".$parts[2];
        }
        fclose($handle);
    }


    // // lấy id imdb
    $stmt = $dbCon->prepare($getId);
    $stmt->execute();

    $dataIdMovies = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $dataIdMovies[] = $row;
    }

    for($i = 0; $i < count($dataIdMovies); $i++){
        $id = $dataIdMovies[$i]['imdb_id'];
        if(isset($data[$id])){
            $IMDBdata = $data[$id];
            $parts = explode(',', $IMDBdata);

            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array($id, $parts[0], $parts[1]));
        }
    }
?>