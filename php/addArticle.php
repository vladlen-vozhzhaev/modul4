<?php
    $title = $_POST['title'];
    $article = $_POST['article'];
    $author = $_POST['author'];
    $mysqli = new mysqli('localhost', 'root', '', 'blog4');
    $mysqli->query("INSERT INTO articles (title, article, author) VALUES ('$title', '$article', '$author')");
    echo "Статья добавлена";