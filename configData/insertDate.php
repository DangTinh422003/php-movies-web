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

    $getId = 'SELECT DISTINCT id from movie';
    $sql = 'UPDATE movie set release_date = ? where id = ?';

    //lấy id actors
    $stmt = $dbCon->prepare($getId);
    $stmt->execute();

    $dataIdMovies = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $dataIdMovies[] = $row;
    }

    // var_dump($dataIdMovies);
    for($i = 0; $i < count($dataIdMovies); $i++){
        $film = filmDetail($dataIdMovies[$i]['id']);
        $stmt = $dbCon->prepare($sql);
        $stmt->execute(array($film['release_date'], $dataIdMovies[$i]['id']));
    }

    function filmDetail($id){    
        $data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'https' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($data)
                )
            );
        $context  = stream_context_create($options);
        $url = "https://api.themoviedb.org/3/movie/$id?api_key=59cc23b07d735ee95072b3cc6be078f2&language=en-US";
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, TRUE);
        return $result;
    }

?>