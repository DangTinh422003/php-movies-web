<?php 
    class WatchController{
        public function showWatchPage($id){
            $result=$this->getDataMovie($id);
            include('views/includes/header/index.php');
            include('views/WatchPage/index.php');
            include('views/includes/footer/index.php');
        }
        private function getDataMovie($id){
            require_once "./models/Movies/Movie.php";
            $movie = new Movie();
            $result = $movie->getDataForWatch($id);
            $result->bind_result($id,$title,$overview);
            $result->fetch();
            return array("id"=>$id, "title"=>$title, "overview"=>$overview);
        }
    }
?>