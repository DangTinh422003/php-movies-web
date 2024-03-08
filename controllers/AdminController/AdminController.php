<?php
class AdminController
{
    public function verifiedAdminPage()
    {
        if (isset($_SESSION['id'])) {
            $id = $_SESSION['id'];
            if ($id == "0")
                include('views/admin/verifyPage.php');
            else
                header('Location: /');
        } else {
            header('Location: /login');
        }
    }

    public function getAdminPage()
    {
        if (isset($_SESSION['verify']))
            include('views/admin/index.php');
        else
            header('Location: /login');
    }

    public function verify($code)
    {
        require_once "./models/Database/Database.php";
        $databaseIns = new Database();
        $database = $databaseIns->connect(true);

        $query = "select verify_code from user where username = 'admin'";

        if ($statement = $database->prepare($query)) {
            $statement->execute();
            $statement->store_result();
            $statement->bind_result($code_server);
            $statement->fetch();

            if ($code_server == $code) {
                $_SESSION['verify'] = TRUE;
                exit(json_encode(array("status" => true, "message" => "Thành công")));
            } else {
                exit(json_encode(array("status" => false, "message" => "Mã xác thực không chính xác")));
            }
        } else {
            exit(json_encode(array("status" => false, "message" => "Có lỗi xảy ra, vui lòng thử lại")));;
        }
    }

    private function checkVerify()
    {
        return isset($_SESSION['verify']);
    }

    public function deleteMovie($id)
    {
        if ($this->checkVerify()) {
            require_once "./models/Movies/Movie.php";
            $movie = new Movie();
            $result = $movie->deleteMovie($id);

            if ($result) {
                exit(json_encode(array("status" => true, "message" => "Thành công")));
            } else {
                exit(json_encode(array("status" => false, "message" => "Đã có lỗi xảy ra, vui lòng thử lại")));
            }
        } else {
            exit(json_encode(array("status" => false, "message" => "Chưa xác thực admin")));
        }
    }

    public function loadDetail($id)
    {
        require_once "./models/Movies/Movie.php";
        $movie = new Movie();
        $statement = $movie->getMovieByID($id);
        $statement->bind_result($id, $title, $overview, $poster_path, $backdrop_path, $tagline, $release_date, $country, $duration, $director_id, $imdb_id);
        $statement->fetch();
        $data = array(
            "id" => $id,
            "title" => $title,
            "poster_path" => $poster_path,
            "tagline" => $tagline,
            "backdrop_path" => $backdrop_path,
            "release_date" => $release_date,
            'overview' => $overview,
            "country" => $country,
            "duration" => $duration,
        );
        // var_dump($data);
        $statement->close();
        exit(json_encode($data));
    }

    public function getGenres($id)
    {
        require_once "./models/Movies/Movie.php";
        $movie = new Movie();

        $stmt = $movie->getMovieGenres($id);

        $stmt->bind_result($nameGenre, $idGenre);
        $listGenre = [];
        while ($stmt->fetch()) {
            array_push($listGenre, array(
                "id" => $idGenre,
                "name" => $nameGenre
            ));
        }

        // var_dump($data);
        $stmt->close();
        exit(json_encode($listGenre));
    }
}
