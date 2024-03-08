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
    $sql = 'INSERT INTO trailer(id_movid, key_vd, site, official) VALUES (?, ?, ?, ?)';

    //lấy id actors
    $stmt = $dbCon->prepare($getId);
    $stmt->execute();

    $dataIdMovies = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))

    {
        $dataIdMovies[] = $row;
    }

    $id = 'id';
    $results = "results";
    $key_vd = "key";
    $site = "site";
    $official = "official";
    for($i = 0; $i < count($dataIdMovies); $i++){
        $dataVideos = getVideos($dataIdMovies[$i][$id]);
        for($j = 0; $j < count($dataVideos[$results]); $j++){
            $stmt = $dbCon->prepare($sql);
            $stmt->execute(array($dataIdMovies[$i][$id], $dataVideos[$results][$j][$key_vd], $dataVideos[$results][$j][$site], $dataVideos[$results][$j][$official]));
        }
    }

    function getVideos($id){    
        $data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'https' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($data)
                )
            );
        $context  = stream_context_create($options);
        $url = "https://api.themoviedb.org/3/movie/$id/videos?api_key=59cc23b07d735ee95072b3cc6be078f2&language=en-US";
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, TRUE);
        return $result;
    }
?>