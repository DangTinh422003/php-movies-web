<?php
class UserDetailController
{
    public function showUserPage()
    {
        include('views/includes/header/index.php');
        include('views/UserDetail/index.php');
        include('views/includes/footer/index.php');
    }

    public function getFullInforUser()
    {
        //check user is loggin or not
        if (isset($_SESSION['id'])) {
            $idRequest = $_SESSION['id'];
            require_once "./models/User/User.php";
            $user = new User();
            //query data through to user object
            $statement = $user->getUserInfo($idRequest, 1);

            if ($statement->num_rows > 0) {
                $statement->bind_result($id, $usernameDB, $firstName, $lastName, $phone, $email, $birthDay, $path);
                $statement->fetch();

                //check that user data have img or not
                if ($path == null) {
                    $path = 'gs://moonvie-a3d56.appspot.com/img/default_avatar.png';
                }

                $user_data = array(
                    "id" => $id,
                    "username" => $usernameDB,
                    "firstName" => $firstName,
                    "lastName" => $lastName,
                    "phone" => $phone,
                    "email" => $email,
                    "birthday" => $birthDay,
                    "path" => $path,
                );

                $data = array("title" => "getUserInfo", "id" => $id, "data" => $user_data, "status" => true);
                //Close prepare statement
                $statement->close();
                exit(json_encode($data));
            }else {
                $data = array("title" => "getUserInfo", "message" => "Not match any user", "status" => false);
                //Close prepare statement
                $statement->close();
                exit(json_encode($data));
            }
        }else {
            $data = array("title" => "login", "message" => "Not logged in", "status" => false);
            exit(json_encode($data));
        }
    }

    public function changeProfile($firstName, $lastName, $birthDay, $email, $phone){
        if (isset($_SESSION['id'])) {
            $idRequest = $_SESSION['id'];
            require_once "./models/User/User.php";
            $user = new User();
            //query data through to user object
            $result = $user->changeInfor($idRequest, $firstName, $lastName, $birthDay, $email, $phone);

            if($result){
                $data = array("title" => "chagneProfile", "message" => "successful", "status" => true);
                exit(json_encode($data));
            }else{
                $data = array("title" => "chagneProfile", "message" => "failure", "status" => false);
                exit(json_encode($data));
            }
        }else {
            $data = array("title" => "login", "message" => "Not logged in", "status" => false);
            exit(json_encode($data));
        }
    }

    public function changePassword($oldpass, $newpass){
        if (isset($_SESSION['id'])) {
            $idRequest = $_SESSION['id'];
            require_once "./models/User/User.php";
            $user = new User();
            //query data through to user object
            $result = $user->changePassword($idRequest, $oldpass, $newpass);

            exit(json_encode($result));
        }else {
            $data = array("title" => "login", "message" => "Not logged in", "status" => false);
            exit(json_encode($data));
        }
    }
}

?>