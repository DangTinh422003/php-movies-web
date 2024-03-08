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
    $sql = 'UPDATE movie set imdb_score = ?, director_id = ? where id = ?';
    $spli = 'INSERT INTO director VALUES(?, ?, ?, ?)';

    //lấy id actors
    $stmt = $dbCon->prepare($getId);
    $stmt->execute();

    $dataIdMovies = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $dataIdMovies[] = $row;
    }

    // var_dump($dataIdMovies);
    $idDirectors = [];
    for($i = 0; $i < count($dataIdMovies); $i++){
        $dataVideos = filmDetailCrew($dataIdMovies[$i]['id']);
        $credit = $dataVideos['crew'];
        var_dump(count($credit));
        for($j = 0; $j < count($credit); $j++){
            if($credit[$j]['known_for_department'] != "Directing") continue;
            if($credit[$j]['job'] == "Director"){
                $id = $credit[$j]['id'];
                if(!in_array($id, $idDirectors)){
                    $name = $credit[$j]['name'];
                    $gender = $credit[$j]['gender'];
                    $path = $credit[$j]['profile_path'];
                    $stmt = $dbCon->prepare($spli);
                    $stmt->execute(array($id, $name, $gender, $path));
                    
                    $ran_score = createRandomScore();

                    $stmt = $dbCon->prepare($sql);
                    $stmt->execute(array($ran_score, $id, $dataIdMovies[$i]['id']));
                    
                    array_push($idDirectors, $id);
                }
            };
        }
    }

    function filmDetailCrew($id){    
        $data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'https' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'GET',
                'content' => http_build_query($data)
                )
            );
        $context  = stream_context_create($options);
        $url = "https://api.themoviedb.org/3/movie/$id/credits?api_key=59cc23b07d735ee95072b3cc6be078f2&language=en-US";
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, TRUE);
        return $result;
    }

    function createRandomScore(){
        $random_float = round(rand(10, 100) / 100, 1);
        if($random_float < 0.25){
            return round(rand(10, 40) / 10, 1);
        }else if($random_float < 0.8){
            return round(rand(50, 75) / 10, 1);
        }
        return round(rand(75, 99) / 10, 1);
    }
?>