<?php
require_once "./config.php";
class SearchController
{

    public function getSearchData($q)
    {
        require_once "./models/Movies/Movie.php";
        $movies = new Movie();
        $statement = $movies->search(trim($q));
        $statement->bind_result($id, $title, $backdrop_path, $duration, $release_date);

        $dataMovies = array();
        while ($statement->fetch()) {
            array_push($dataMovies, array(
                "id" => $id,
                "title" => $title,
                "backdrop_path" => $backdrop_path,
                "release_date" => $release_date,
                'duration' => $duration,
            ));
        }

        //Close prepare statement
        $statement->close();

        if (isset($dataMovies)) {
            $data = array("title" => "search data", "data" => $dataMovies, "status" => true);
            exit(json_encode($data));
        } else {
            $data = array("title" => "search data", "status" => false);
            exit(json_encode($data));
        }
    }
}

?>