<?php 
    class DetailMovieController{
        public function showDetailMoviePage($id){
            $datamovie=$this->loadDetail($id);
            $castsmovie=$this->loadcast($id);
            $genres=$this->loadGenres($id);
            include('views/includes/header/index.php');
            include('views/DetailMovie/index.php');
            include('views/includes/footer/index.php');

        }
        public function loadDetail($id){
            require_once "./models/Movies/Movie.php";
            $movie = new Movie();
            $statement = $movie->getMovieByID($id);
            $statement->bind_result($id, $title, $overview, $poster_path, $backdrop_path, $tagline, $release_date, $country, $duration, $director_id, $imdb_id);
            $statement->fetch();
            $statement->close();


            $statement = $movie->getTrailers($id);
            $statement->bind_result($keyvideo);
            $statement->fetch();
            $statement->close();
            $data=array(
                "id" => $id,
                "title" => $title,
                "poster_path" => $poster_path,
                "tagline" => $tagline,
                "backdrop_path" => $backdrop_path,
                "release_date" => $release_date,
                'overview' => $overview,
                "country" => $country,
                "duration" => $duration,
                'trailer_key' => $keyvideo
            );
            return $data;
        }
        public function loadcast($id)
        {
            require_once "./models/Movies/Movie.php";
            $movie = new Movie();
            $statement = $movie->getCasts($id);
            $statement->bind_result($name,$profile_path);
            $data=[];
            while($statement->fetch())
            {
                array_push($data,array(
                    "name" => $name,
                    "profile_path" => $profile_path
                ));
            };
            $statement->close();
            return $data;

        }
        public function loadGenres($id){
            require_once "./models/Movies/Movie.php";
            $movie = new Movie();
            $statement = $movie->getMovieGenres($id);
    
            $statement->bind_result($name, $id);
    
            $dataGenres = array();
            while ($statement->fetch()) {
                array_push($dataGenres, array(
                    "id" => $id,
                    "name" => $name,
                ));
            }
            $statement->close();
            return $dataGenres;
        }
        public function loadcomment(){
            
            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);

            $movieid=$_GET['id'];
            if ($statement = $db->prepare("SELECT * FROM comments WHERE id = ?")) {

                $statement->bind_param("s", $movieid);
                $statement->execute();
                $statement->store_result();
                $comments=[];
                if ($statement->num_rows > 0){ 
                    $statement->bind_result($id,$username,$comment);
                    while($statement->fetch()){
                        array_push($comments, array(
                            "id" => $id,
                            "name" => $username,
                            "comment" => $comment
                        ));
                    }
                    $data = array("title" => "get comments", "data" => $comments, "status" => true);
                    exit(json_encode($data));
                }
                else{
                    $data = array("title" => "get comments", "data" => $comments, "status" => false);
                    exit(json_encode($data));
                }
                $statement->close();
               
            }
            
        }
        public function insertcomment($id,$username,$comment){
            
            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);
            if($commented = $db->prepare("INSERT INTO comments(id, username,comment) VALUES (?, ?, ?)")){            
                $commented->bind_param("sss", $id, $username,$comment);
                $commented->execute();
                if ($commented->affected_rows > 0){ 
                    $commented->close(); 
                    
                    if ($statement = $db->prepare("SELECT * FROM comments WHERE id = ?")) {

                        $statement->bind_param("s", $id);
                        $statement->execute();
                        $statement->store_result();
                        $comments=[];
                        if ($statement->num_rows > 0){ 
                            $statement->bind_result($id,$username,$comment);
                            while($statement->fetch()){
                                array_push($comments, array(
                                    "id" => $id,
                                    "name" => $username,
                                    "comment" => $comment
                                ));
                            }
                            $data = array("title" => "get comments", "data" => $comments, "status" => true);
                            exit(json_encode($data));
                        }
                        else{
                            $data = array("title" => "get comments", "data" => $comments, "status" => false);
                            exit(json_encode($data));
                        }
                        $statement->close();
                       
                    }
                    
                }
                else{
                    $commented->close(); 
                    $data=array("title" => "comment","message" => "Can't comment","status" => false);
                    exit(json_encode($data));
                }
            }
        }

        public function getDataMovie($id){
            
        }
    }
    

?>