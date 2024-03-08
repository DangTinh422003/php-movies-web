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

//insert bảng movie
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

$insertMovie = 'INSERT INTO movie(id, title, overview, poster_path, backdrop_path, tagline, yearProduce, country, duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
$insertGenres = 'INSERT INTO movie_genre(id_movid, id_type) VALUES (?, ?)';
$insertMovieactor = 'INSERT INTO actor_movie(id_movie, id_actor, character_actor) VALUES (?, ?, ?)';

//lap lay cac trang du lieu
for($i = 12; $i < 600; $i++) {
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi&page=$i&region=US";
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ }

    $result = json_decode($result, TRUE);   
    $key = 'results';
    $films = $result[$key];

    $id = 'id';
    $title = 'title';
    $overview = 'overview';
    $poster_path = 'poster_path';
    $backdrop_path = 'backdrop_path';
    $tagline = 'tagline';
    $yearProduce = 'release_date';
    $production_countries = 'production_countries';
    $name = 'name';
    $genres = 'genres';
    $test = 0;
    $character = 'character';
    $cast = 'cast';
    $runtime = 'runtime';

    for($j = 0; $j < count($films); $j++){
        $detailMovie = getDetailMovie($films[$j][$id]);
        $date = $detailMovie[$yearProduce];
        $parts = explode('-', $date);
        $stmt = $dbCon->prepare($insertMovie);
        if($detailMovie[$production_countries][$test][$name]){
            $stmt->execute(array($detailMovie[$id], $detailMovie[$title], $detailMovie[$overview], $detailMovie[$poster_path], $detailMovie[$backdrop_path], $detailMovie[$tagline], $parts[0], $detailMovie[$production_countries][$test][$name], $detailMovie[$runtime]));
            for($k = 0; $k < count($detailMovie[$genres]); $k++){
                $stmt = $dbCon->prepare($insertGenres);
                $stmt->execute(array($detailMovie[$id], $detailMovie[$genres][$k][$id]));
            }
    
            $credit = getCredit($films[$j][$id]);
            for($l = 0; $l < count($credit[$cast]); $l++){
                $stmt = $dbCon->prepare($insertMovieactor);
                if($credit[$cast][$l][$character]){
                    $stmt->execute(array($detailMovie[$id], $credit[$cast][$l][$id], $credit[$cast][$l][$character]));
                }
            }
        }

    }

}


function getDetailMovie($id){
    $data = array('key1' => 'value1', 'key2' => 'value2');
    $options = array(
        'https' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET',
            'content' => http_build_query($data)
            )
        );
    $context  = stream_context_create($options);
    $url = "https://api.themoviedb.org/3/movie/$id?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi";
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
    $url = "https://api.themoviedb.org/3/movie/$id/credits?api_key=59cc23b07d735ee95072b3cc6be078f2&language=vi";
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, TRUE);
    return $result;
}

?>