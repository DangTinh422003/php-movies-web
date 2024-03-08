<?php
require './config.php';
session_set_cookie_params(EXPIRE_TIME);
session_start();
require_once './controllers/HomeController/HomeController.php';
require_once './controllers/SignInController/SignInController.php';
require_once './controllers/SignUpController/SignUpController.php';
require_once './controllers/ForgotPassController/ForgotPassController.php';
require_once './controllers/DetailMovieController/DetailMovieController.php';
require_once './controllers/UserDetailController/UserDetailController.php';
require_once './controllers/WatchController/WatchController.php';
require_once './controllers/SearchController/SearchController.php';
require_once './controllers/AdminController/AdminController.php';



$request = $_SERVER['REQUEST_URI'];
$split_request = explode("?", $request);
$request_parts = explode('/', $split_request[0]);

switch ($request_parts[1]) {
    case "":{
        $homeController = new HomeController();
        if(isset($_GET['getUserInf'])){
            $homeController->getUserInf();
        }else if(isset($_GET['logOut'])){
            $homeController->logOut();
        }else if(isset($_GET['getNewestMovie'])){
            $homeController->getNewestMovie();
        }else if(isset($_GET['getPopularMovie'])){
            $homeController->getPopularMonthMovie();
        }else if(isset($_GET['getGenres'])){
            $homeController->getGenres();
        }else if(isset($_GET['getSpecialMovie'])){
            $homeController->getSpecialMovies();
        }else if(isset($_GET['getSortMovies'])){
            $listGenres = $_GET['listGenresSelect'];
            $yearSelected = $_GET['yearSelected'];
            $sortType = $_GET['sortType'];
            $pageNumber = $_GET['pageNumber'];
            $homeController->getSortMovies($listGenres, $yearSelected, $sortType, $pageNumber);
        }else if(isset($_GET['getRecommendMovies'])){
            $homeController->getRecommendFilm();
        }
        else{
            $homeController->showHome();
        }
        break;
    }
    case "login":{
        $signInController = new SignInController();
        if(isset($_POST['submit'])){
            $user = $_POST['username'];
            $password = $_POST['password'];
            $signInController->userAuth(true, $user, $password);
        }else{
            $signInController->showSignInPage();
        }
        break;
    }
    case "loginonmobile":{
        $signInController = new SignInController();
        $user = $_POST['username'];
        $password = $_POST['password'];
        $signInController->userAuth(false, $user, $password);
        break;
    }
    case "register":{
        $signUpController = new SignUpController();
        if(isset($_POST['submit'])){
            $signUpController->register(false);
        }
        else if(isset($request_parts[2])){
            if($request_parts[2] == "notification")
            $signUpController->notification();
        }
        else{
            $signUpController->showSignUpPage();
        }
        break;
    }
    case "forgotPass":{
        $forgotPassController = new ForgotPassController();
        $forgotPassController->showForgotPassPage();
        break;
    }
    case "verify":{
        $admin = new AdminController();
        if(isset($_POST['verify'])){
            $code = $_POST['code'];
            $admin->verify($code);
        }else{
            $admin->verifiedAdminPage();
        }
        break;
    }
    case "admin":{
        $admin = new AdminController();
        if(isset($_POST['deleteMovie'])){
            $id = $_POST['id'];
            $admin->deleteMovie($id);
        }else if(isset($_GET['detailMovie'])){
            $id = $_GET['id'];
            $admin->loadDetail($id);
        }else if(isset($_GET['getGenres'])){
            $id = $_GET['id'];
            $admin->getGenres($id);
        }
        else{
            $admin->getAdminPage();
        }
        break;
    }
    case "detail":{
        $detailMovieController = new DetailMovieController();
        if(isset($_GET['getcmt'])){
            $detailMovieController->loadcomment();
        }
        if(isset($_POST['id']) && isset($_POST['username'])){
            $detailMovieController->insertcomment($_POST['id'],$_POST['username'],$_POST['comment']);
        }
        else{
            $id=$_GET['id'];
            $detailMovieController->showDetailMOviePage($id);
        }
        break;
    }
    case "profile": {
        $userDetailController = new UserDetailController();
        if(isset($_GET['getFullInfor'])){
            $userDetailController->getFullInforUser();
        }else if(isset($_POST['changeProfile'])){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $birthDay = $_POST['birthday'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $userDetailController->changeProfile($firstName, $lastName, $birthDay, $email, $phone);
        }else if(isset($_POST['changePassword'])){
            $oldpass = $_POST['oldPass'];
            $newpass = $_POST['newPass'];
            $userDetailController->changePassword($oldpass, $newpass);
        }
        else{
            $userDetailController->showUserPage();
        }
        break;
    }
    case "search":{
        $q = $_GET['q'];
        $searchController = new SearchController();
        $searchController->getSearchData($q);
        break;
    }
    case "watch":{
        $id=$_GET['id'];
        $watchController= new WatchController();
        $watchController->showWatchPage($id);
        break;
    }
    default: require __DIR__ . '/views/404.php';
}
