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

    $getId = 'SELECT DISTINCT id_actor from actor_movie';
    $sql = 'INSERT INTO actor(id, name, gender, biography, profile_path, birthday) VALUES (?, ?, ?, ?, ?, ?)';

    //lấy id actors
    $stmt = $dbCon->prepare($getId);
    $stmt->execute();

    $dataIdActors = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))

    {
        $dataIdActors[] = $row;
    }

    $id = 'id_actor';
    $name = 'name';
    $gender = 'gender';
    $biography = 'biography';
    $profile_path = 'profile_path';
    $birthday = 'birthday';
    for($i = 0; $i < count($dataIdActors); $i++){
        $dataActor = getActorDetail($dataIdActors[$i][$id]);
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($dataIdActors[$i][$id], $dataActor[$name], $dataActor[$gender], $dataActor[$biography], $dataActor[$profile_path], $dataActor[$birthday]));
    }

    function getActorDetail($id){
        $data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'https' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($data)
                )
            );
        $context  = stream_context_create($options);
        $url = "https://api.themoviedb.org/3/person/$id?api_key=59cc23b07d735ee95072b3cc6be078f2&language=us";
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, TRUE);
        return $result;
    }
?>