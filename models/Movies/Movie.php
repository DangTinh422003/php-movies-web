<?php
    class Movie
    {
        function __construct(){
        }

        public function getMovieByID($id){
            $query= 'SELECT movie.* FROM movie WHERE id =?';
            return $this->getDataByQueryAndID($query, $id);
        }

        public function getCasts($id){
            $query= 'SELECT actor.name,actor.profile_path FROM actor,actor_movie WHERE actor_movie.id_movie =? and actor.id=actor_movie.id_actor';
            return $this->getDataByQueryAndID($query, $id);
        }
        //[GET]lấy các phim mới nhất
        public function getNewestMovie(){
            $query = 'SELECT id, title, poster_path, backdrop_path, release_date FROM `movie` WHERE release_date < now() ORDER by release_date desc limit 0, 20';
            return $this->getDataByQuery($query);
        }

        //[GET]lấy các phim phổ biến
        public function getPopularMonthMovie(){
            $query = 'SELECT movie.id, movie.title, movie.poster_path, movie.backdrop_path, movie.release_date, imdb_rating.score from movie LEFT JOIN imdb_rating on movie.imdb_id = imdb_rating.id where year(CURDATE()) - year(release_date) < 2 order by imdb_rating.score desc limit 20';
            return $this->getDataByQuery($query);
        }

        //moi dan vo
        public function getDataForWatch($id){
            $query = 'SELECT id, title, overview FROM `movie` WHERE id=?';
            return $this->getDataByQueryAndID($query, $id);
        }
        
        //[GET]lấy danh sách các thể loại phim
        public function getGenres(){
            $query = "SELECT * FROM genre ORDER by cast(id as int) asc";
            return $this->getDataByQuery($query);
        }

        //[GET]lấy 5 phim mới, có điểm imdb cao nhất trong tháng
        public function getSpecialMovie(){
            $query = 'select movie.*, imdb_rating.score from movie LEFT JOIN imdb_rating on movie.imdb_id = imdb_rating.id where movie.overview != "" and movie.id IN (select id from movie where (MONTH(release_date) BETWEEN MONTH(CURDATE()) - 3 and MONTH(CURDATE())) AND YEAR(release_date) = YEAR(CURDATE())) ORDER by imdb_rating.score desc limit 5';
            return $this->getDataByQuery($query);
        }

        //[GET]lấy các thể loại của phim
        public function getMovieGenres($id){
            $query = 'SELECT genre.name, genre.id FROM `movie_genre` left join genre on genre.id = movie_genre.id_type WHERE movie_genre.id_movid = ?';
            return $this->getDataByQueryAndID($query, $id);
        }

        //[GET] lấy các trailer của phim
        public function getTrailers($id){
            $query = 'SELECT key_vd FROM `trailer` WHERE id_movid = ? and official = 1';
            return $this->getDataByQueryAndID($query, $id);
        }

        //[GET] lấy phim theo thể loại, năm và sắp xếp
        public function getMovieSelectd($listGenres, $yearSelected, $sortType, $pageNumber){
            $numMoviePerPage = 18;
            $index = ($pageNumber - 1) * $numMoviePerPage;
            $query = "SELECT DISTINCT ? FROM `movie`, `movie_genre` WHERE movie_genre.id_movid = movie.id";

            //xử lí câu lệnh truy vấn
            if($listGenres[0] != ""){
                $genres = "(";
                foreach($listGenres as $value){
                    $genres = $genres."'$value',";
                }
                $genres = substr($genres, 0, strlen($genres) - 1).")";
                $query = $query." and movie_genre.id_type in ".$genres;
            }

            if($yearSelected != "none"){
                $query = $query." and year(movie.release_date) = $yearSelected";
            }

            if($sortType != "none"){
                if($sortType == "desc")
                $query = $query." order by title desc";
                else
                $query = $query." order by title asc";
            }

            $subQuery = $query;
            $query = $query." limit $index, $numMoviePerPage";
            
            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);
            
            $param = "movie.id, movie.title, movie.poster_path, movie.backdrop_path, movie.release_date, movie.duration";
            $getDataQuery = str_replace("?", $param, $query);
            if ($statement = $db->prepare($getDataQuery)) {
                $statement->execute();
                $statement->store_result();
                
                $paramCount = "select count(id) from movie where id in (";
                $subQuery = str_replace("?", "movie.id", $subQuery);
                $getCountDataQuery = $paramCount.$subQuery.")";
                $stmt = $db->prepare($getCountDataQuery);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($count);
                $stmt->fetch();
                $stmt->close();

                return [$statement, ceil($count/$numMoviePerPage)];
            }
        }

        //[GET] lấy các phim đề xuất
        public function getRecommendFilm(){
            $query = 'select movie.*, imdb_rating.score from movie LEFT JOIN imdb_rating on movie.imdb_id = imdb_rating.id ORDER by imdb_rating.score desc limit 6';
            return $this->getDataByQuery($query);
        }

        //[GET]hàm tổng lấy data theo query và id
        private function getDataByQueryAndID($query, $id){

            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);

            if ($statement = $db->prepare($query)) {
                $statement->bind_param("s", $id);
                $statement->execute();
                $statement->store_result();
                return $statement;
            }
        }

        //[GET]hàm tổng lấy data theo query
        private function getDataByQuery($query){

            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);

            if ($statement = $db->prepare($query)) {
                $statement->execute();
                $statement->store_result();
                return $statement;
            }
        }

        //[GET] tìm kiếm thông tin
        public function search($q){
            $q = '%'.$q.'%';
            $query = "select movie.id, movie.title, movie.backdrop_path, movie.duration, movie.release_date from movie where title like ?";

            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);

            if ($statement = $db->prepare($query)) {
                $statement->bind_param("s", $q);
                $statement->execute();
                $statement->store_result();
                return $statement;
            }
        }

        //[POST] xóa phim
        public function deleteMovie($id){
            $deleteGenres = "delete from movie_genre where id_movid = ?";
            $deleteActor = "delete from actor_movie where id_movie = ?";
            $query = "delete from movie where id = ?";

            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $db = $databaseIns->connect(true);

            $stmt = $db->prepare($deleteActor);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->close();

            $stmt = $db->prepare($deleteGenres);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $stmt->close();

            if ($statement = $db->prepare($query)) {
                $statement->bind_param("s", $id);
                $statement->execute();
                $statement->close();
                return true;
            }else{
                return false;
            }
        }

        public function __getMovies($page)
        {
            require_once "./models/Database/Database.php";
            $databaseIns = new Database();
            $database = $databaseIns->connect(true);
            $result = $database->prepare("SELECT movie.id, movie.title, movie.overview, movie.poster_path, movie.backdrop_path, movie.tagline, movie.release_date , movie.country, movie.duration, movie.director_id, imdb_rating.id , imdb_rating.score, imdb_rating.vote_count FROM movie INNER JOIN imdb_rating WHERE movie.imdb_id=imdb_rating.id LIMIT ?,?");
            $quantity = $page * 20;
            $limit = 20;
            $result->bind_param('ii', $quantity, $limit);
            $result->execute();
            $result->store_result();
            $data = array();
            $movie = array();
            if ($result->num_rows() > 0) {
                $result->bind_result($id, $title, $overview, $poster_path, $backdrop_path, $tagline, $release_date, $country, $duration, $director_id, $imdb_id, $score, $vote_count);
                while ($result->fetch()) {

                    $movie["id"] = $id;
                    $movie["title"] = $title;
                    $movie["overview"] = $overview;
                    $movie["poster_path"] = $poster_path; #them duong dan den thu muc chua anh
                    $movie["backdrop_path"] = $backdrop_path; #them duong dan den thu muc chua anh
                    $movie["tagline"] = $tagline;
                    $movie["release_date"] = $release_date;
                    $movie["country"] = $country;
                    $movie["duration"] = $duration;
                    $movie["director_id"] = $director_id;
                    $movie["imdb_id"]=$imdb_id;
                    $movie["score"]=$score;
                    $movie["vote_count"]=$vote_count;
                    array_push($data, $movie);
                }
                header('Content-Type: application/json');
                exit(json_encode($data));
            } else {
                exit("Failed to get data");
            }
            $result->close();
        }
    }
