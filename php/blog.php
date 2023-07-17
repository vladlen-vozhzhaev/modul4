<?php
    $mysqli = new mysqli('localhost', 'root', '', 'blog4');
    $result = $mysqli->query("SELECT * FROM articles");
    while (($row = $result->fetch_assoc()) != null){
        echo "<h1>".$row['title']."</h1>";
        echo "<p>".$row['article']."</p>";
        echo "<p>".$row['author']."</p>";
    }