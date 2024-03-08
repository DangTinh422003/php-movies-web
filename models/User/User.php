<?php
    class User{
        public function login($username,$password,$web){
            require_once "./models/Database/Database.php";
            $databaseIns=new Database();
            $database=$databaseIns->connect($web);
             //Check if username and password are defined
            if ( !isset($username, $password) ) {
                if ($web) {
                    exit('Please fill both the username and password fields!');
                }
                else{
                    $resp=array("title" => "connect to database","status" => false);
                    exit(json_encode($resp));
                }
            }
            //Prepare sql query to prevent SQL injection and for better performance
            if ($statement = $database->prepare('SELECT id, username, password, role FROM user WHERE username = ?')) {
                //Pass parameters and store results
                $statement->bind_param('s', $username);
                $statement->execute();
                $statement->store_result();
                return $statement;
            }
        }

        public function getUserInfo($id, $type){
            require_once "./models/Database/Database.php";
            $databaseIns=new Database();
            $database=$databaseIns->connect(true);

            //Check if username and password are defined
            if ( !isset($id) ) {
                exit('Error, can not find user thought this id');
            }

            $query = "";
            //Prepare sql query to prevent SQL injection and for better performance
            if($type == 0){
                $query = 'SELECT id, username, first_name, img_path FROM user WHERE id = ?';
            }else if($type == 1){
                $query = 'SELECT `id`, `username`, `first_name`, `last_name`, `phone`, `email`, `birthday`, `img_path` FROM `user` WHERE id = ?';
            }

            if ($statement = $database->prepare($query)) {
                //Pass parameters and store results (id and password)
                $statement->bind_param('s', $id);
                $statement->execute();
                $statement->store_result();
                return $statement;
            }
        }

        public function register($id, $firstName, $lastName, $username, $password, $email, $role, $web){
            require_once "./models/Database/Database.php";
            $databaseIns=new Database();

            //connect to database
            $database=$databaseIns->connect($web);

            //prepare for sql query
            $result = $database->prepare("SELECT username FROM user WHERE username=?");
            $result->bind_param("s",$username);
            $result->execute();
            $result->store_result();
            $result->bind_result($username);

            if ($result->num_rows()>0){
                $result->close();   
                $data=array("title" => "register","message" => "Tài khoản đã tồn tại","status" => "false");
                exit(json_encode($data));
            } else {
                $result->close();
                
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                if($register = $database->prepare("INSERT INTO user(id, username, first_name, last_name, password, email, role) VALUES (?, ?, ?, ?, ?, ?, ?)")){            
                    $register->bind_param("ssssssi", $id, $username, $firstName, $lastName, $hashed_password, $email, $role);
                    $register->execute();
                    return $register;
                }

            }

        }

        public function getLargestId(){
            require_once "./models/Database/Database.php";
            $databaseIns=new Database();
            $database=$databaseIns->connect(true);

            $query = "SELECT id FROM `user` ORDER by id desc limit 1";

            $result = $database->prepare($query);
            $result->execute();
            $result->store_result();
            $result->bind_result($id);
            $result->fetch();
            
            return $id;
        }
    
        public function changeInfor($id, $firstName, $lastName, $birthDay, $email, $phone){
            $query = "UPDATE `user` SET first_name = ?, last_name = ?, birthday = ?, email = ?, phone = ? where id = ?";

            require_once "./models/Database/Database.php";
            $databaseIns=new Database();
            $database=$databaseIns->connect(true);

            if($statement = $database->prepare($query)){
                $statement->bind_param("ssssss", $firstName, $lastName, $birthDay, $email, $phone, $id);
                $statement->execute();
                $statement->close();
                return true;
            }else{
                return false;
            }
        }

        public function changePassword($idRequest, $oldpass, $newpass){
            
            require_once "./models/Database/Database.php";
            $databaseIns=new Database();
            $database=$databaseIns->connect(true);

            $query = 'Select password from user where id = ?';
            $statement = $database->prepare($query);
            $statement->bind_param("s", $idRequest);
            $statement->execute();
            $statement->bind_result($password);
            $statement->fetch();
            $statement->close();

            //decode mật khẩu lấy từ database
            //here

            if($password == $oldpass){
                $query = 'update user set password = ? where id = ?';

                //encode mật khẩu mới
                //here

                $stmt = $database->prepare($query);
                $stmt->bind_param("ss", $newpass, $idRequest);
                $stmt->execute();

                return ["status" => true];
            }else{
                return ["status" => false, "message" => "mật khẩu cũ không đúng"];
            }
        }
    } 
?>