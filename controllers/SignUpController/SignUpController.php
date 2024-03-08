<?php 
    class SignUpController{
        public function showSignUpPage(){
            include('views/SignUp/index.php');
        }

        public function notification(){
            include('views/SignUp/notification.php');
        }

        public function register($web){
            require_once "./models/User/User.php";
            $user = new User();

            //get data from request
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $lastName = $_POST['lastName'];
            $firstName = $_POST['firstName'];
            $role = 1;
            
            //get last id from user table
            $largestId = $user->getLargestId();
            $id = ((int)$largestId) + 1;
            if($id < 10){
                $id="0000".$id;
            }
            else if($id<100){
                $id="000".$id;
            }
            else if($id<1000){
                $id="00".$id;
            }
            else{
                $id="0".$id;
            }

            //call function to register
            $register = $user->register($id, $firstName, $lastName, $username, $password, $email, $role, $web);

            //check if register was successful
            if ($register->affected_rows > 0){ 
                $data=array("title" => "register","User id" => $id,"status" => true);
                exit(json_encode($data));
            }
            else{
                $data=array("title" => "register","message" => "Can't register","status" => false);
                exit(json_encode($data));
            }
            $register->close(); 
        }

    }
?>