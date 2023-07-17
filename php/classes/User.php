<?php
    class User{
        public static function handlerReg(){
            global $mysqli;
            $email = $_POST['email'];
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $name = $_POST['name'];
            $lastname = $_POST['lastname'];
            $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
            if($result->num_rows){
                return "Такой пользователь уже существует";
            }else{
                $mysqli->query("INSERT INTO users (name, lastname, email, pass)
                            VALUES ('$name', '$lastname', '$email', '$pass')");
                return "Успешно зарегистрирован!";
            }
        }

        public static function handlerLogin(){
            global $mysqli;
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $result = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
            $row = $result->fetch_assoc();
            if(password_verify($pass, $row['pass'])){
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['lastname'] = $row['lastname'];
                $_SESSION['avatar'] = $row['avatar'];
                $_SESSION['id'] = $row['id'];
                header('location: /profile');
            }else{
                return "Логин или пароль введён неправильно!";
            }
        }

        public static function getUser(){
            $name = $_SESSION['name'];
            $lastname = $_SESSION['lastname'];
            $email = $_SESSION['email'];
            $id = $_SESSION['id'];
            $avatar = $_SESSION['avatar'];
            $user = [
                'name'=>$name,
                'lastname'=>$lastname,
                'id'=>$id,
                'email'=>$email,
                'avatar' =>$avatar
            ];
            return json_encode($user);
        }

        public static function isAuth(){
            return !empty($_SESSION['id']);
        }

        public static function uploadAvatar(){
            global $mysqli;
            $userAvatar = $_FILES['userAvatar'];
            $ext = explode('.', $userAvatar['name'])[count(explode('.', $userAvatar['name']))-1];
            if($ext != 'jpg') exit('ERROR!!!');
            $fileName = microtime().$userAvatar['name'];
            if(move_uploaded_file($userAvatar['tmp_name'], 'img/'.$fileName)){
                $userId = $_SESSION['id'];
                $avatarUri = '/img/'.$fileName;
                $mysqli->query("UPDATE `users` SET `avatar`='$avatarUri' WHERE id = '$userId'");
                $_SESSION['avatar'] = $avatarUri;
                header('Location: /profile');
            }else{
                echo "ОшибКА!";
            }
        }
    }