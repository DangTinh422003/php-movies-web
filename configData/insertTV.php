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

//-------------------------------------------------
//https://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php
// use key 'http' even if you send the request to https://...
$data = array('key1' => 'value1', 'key2' => 'value2');
$options = array(
    'https' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET',
        'content' => http_build_query($data)
        )
    );
$context  = stream_context_create($options);

$insertTV = 'INSERT INTO `tv`(`id`, `poster_path`, `backdrop_path`, `first_air_date`, `episode_run_time`, `number_of_episodes`, `number_of_seasons`, `status`, `tagline`, `overview`, `name`, `director_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
$insertGenres = 'INSERT INTO tv_genre(id_TV, id_genre) VALUES (?, ?)';
$insertTVactor = 'INSERT INTO actor_tv(id_TV, id_actor, actor_character) VALUES (?, ?, ?)';
$insertActor = 'INSERT INTO actor(id, name, gender, biography, profile_path, birthday) VALUES(?, ?, ?, ?, ?, ?)';
$insertDirector = 'INSERT INTO director VALUES(?, ?, ?, ?)';

$listId = [];
//lap lay cac trang du lieu
for($i = 1; $i < 60; $i++) {
    $url = "https://api.themoviedb.org/3/tv/popular?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi&page=$i";
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { continue; }

    $result = json_decode($result, TRUE);   
    $films = $result['results'];

    for($j = 0; $j < count($films); $j++){
        if(isset($films[$j]['origin_country'][0])){
            if($films[$j]['origin_country'][0] == "US")
                array_push($listId, $films[$j]['id']);
        }
    }
}

for($i = 0; $i < count($listId); $i++){
    $detailTV = getDetailTV($listId[$i]);
    $creditTV = getCredit($listId[$i]);

    $cast = $creditTV['cast'];
    for($j = 0; $j < count($cast); $j++){

        $checkExist = $dbCon->prepare('select * from actor_tv where id_TV = ? and id_actor = ?');
        $checkExist->execute(array($listId[$i],$cast[$j]['id']));

        if($checkExist->rowCount() == 0){
            $stmt = $dbCon->prepare($insertTVactor);
            $stmt->execute(array($listId[$i], $cast[$j]['id'], $cast[$j]['character']));
        }


        $checkExist = $dbCon->prepare('select name from actor where id = ?');
        $checkExist->execute(array($cast[$j]['id']));

        if($checkExist->rowCount() == 0){
            $detailActor = getDetailActor($cast[$j]['id']);

            $stmt = $dbCon->prepare($insertActor);
            $stmt->execute(array($cast[$j]['id'], $detailActor['name'], $detailActor['gender'], $detailActor['biography'], $detailActor['profile_path'], $detailActor['birthday']));
        }
    }


    $idDirectors = null;
    $crew = $creditTV['crew'];
    for($j = 0; $j < count($crew); $j++){
        if($crew[$j]['known_for_department'] != "Directing") continue;

        //kiem tra xem dao dien do co ton tai chua
        $checkExist = $dbCon->prepare('select name from director where id = ?');
        $checkExist->execute(array($crew[$j]['id']));
        $checkExist->fetch();
        
        if($checkExist->rowCount() == 0){
            
            if($crew[$j]['job'] == "Creator"){
                $idDirector = $crew[$j]['id'];
                $name = $crew[$j]['name'];
                $gender = $crew[$j]['gender'];
                $path = $crew[$j]['profile_path'];

                $stmt = $dbCon->prepare($insertDirector);
                $stmt->execute(array($idDirector, $name, $gender, $path));
                $idDirectors = $idDirector;
            }
        }
    }

    // var_dump($idDirectors);

    $id = $detailTV['id'];
    $detailTVGenre = $detailTV['genres'];
    for($j = 0; $j < count($detailTVGenre); $j++){
        $idGenre = $detailTVGenre[$j]['id'];

        $stmt = $dbCon->prepare($insertGenres);
        $stmt->execute(array($id, $idGenre));
    }

    $poster_path = $detailTV['poster_path'];
    $backdrop_path = $detailTV['backdrop_path'];
    $first_air_date = $detailTV['first_air_date'];
    $episode_run_time = $detailTV['episode_run_time'];
    $number_of_episodes = $detailTV['number_of_episodes'];
    $number_of_seasons = $detailTV['number_of_seasons'];
    $status = $detailTV['status'];
    $tagline = $detailTV['tagline'];
    $overview = $detailTV['overview'];
    $name = $detailTV['name'];

    $stmt = $dbCon->prepare($insertTV);
    $stmt->execute(array($id, $poster_path, $backdrop_path, $first_air_date, $episode_run_time, $number_of_episodes, $number_of_seasons, $status, $tagline, $overview, $name, $idDirectors));
}


function getDetailTV($id){
    $data = array('key1' => 'value1', 'key2' => 'value2');
    $options = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
            )
        );
    $context  = stream_context_create($options);
    $url = "https://api.themoviedb.org/3/tv/$id?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi";
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, TRUE);
    return $result;
}

function getCredit($id){
    $data = array('key1' => 'value1', 'key2' => 'value2');
    $options = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
            )
        );
    $context  = stream_context_create($options);
    $url = "https://api.themoviedb.org/3/tv/$id/credits?api_key=59cc23b07d735ee95072b3cc6be078f2&language=en-US";
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, TRUE);
    return $result;
}

function getDetailActor($id){
    $data = array('key1' => 'value1', 'key2' => 'value2');
    $options = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
            )
        );
    $context  = stream_context_create($options);
    $url = "https://api.themoviedb.org/3/person/$id?api_key=59cc23b07d735ee95072b3cc6be078f2&language=en-US";
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, TRUE);
    return $result;
}

?>