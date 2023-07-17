<?php
    class Blog{
        public static function addArticle(){
            global $mysqli;
            $title = $_POST['title'];
            $article = $_POST['article'];
            $author = $_POST['author'];
            $mysqli->query("INSERT INTO articles (title, article, author) VALUES ('$title', '$article', '$author')");
            return "Статья добавлена";
        }

        public static function getArticles(){
            global $mysqli;
            $result = $mysqli->query("SELECT * FROM articles");
            $articles = [];
            $i = 0;
            while (($row = $result->fetch_assoc()) != null){
                $articles[$i]['title'] = $row['title'];
                $articles[$i]['article'] = $row['article'];
                $articles[$i]['author'] = $row['author'];
                $articles[$i]['id'] = $row['id'];
                $i++;
            }
            return json_encode($articles);
        }

        public static function getArticleById($articleId){
            global $mysqli;
            $result = $mysqli->query("SELECT * FROM articles WHERE id = '$articleId'");
            $row = $result->fetch_assoc();
            return json_encode($row);
        }

        public static function editArticle($articleId){
            global $mysqli;
            $title = $_POST['title'];
            $article = $_POST['article'];
            $author = $_POST['author'];
            $mysqli->query("UPDATE `articles` SET `title`='$title',`article`='$article',`author`='$author' WHERE id='$articleId'");
            header('Location: /blog/'.$articleId);
        }

        public static function deleteArticle($articleId){
            global $mysqli;
            $mysqli->query("DELETE FROM `articles` WHERE id='$articleId'");
            header('Location: /blog');
        }
    }