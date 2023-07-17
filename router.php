<?php
    session_start();
    $mysqli = new mysqli('localhost', 'root', '', 'blog4');
    require_once('php/classes/User.php');
    require_once('php/classes/Blog.php');
    $path = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    // $path = "/blog/2"
    $explodePath = explode('/', $path); // ['', 'blog', '2']
    $content = "Страница не найдена";
    if($path == "/login" and $method == "GET"){
        $content = file_get_contents('view/login.html');
    }else if($path == "/login" and $method == "POST"){
        $content = User::handlerLogin();
    }else if($path == "/reg" and $method == "GET"){
        $content = file_get_contents('view/reg.html');
    }else if($path == "/reg" and $method == "POST"){
        $content = User::handlerReg();
    }else if($path == "/profile"){
        if(User::isAuth())
            $content = file_get_contents('view/profile.html');
        else
            header('Location: /login');
    }else if($path == "/getUser"){
        exit(User::getUser());
    }else if($path == '/addArticle' and $method == "GET"){
        $content = file_get_contents('view/addArticle.html');
    }else if($path == '/addArticle' and $method == "POST"){
        $content = Blog::addArticle();
    }else if($path == '/blog'){
        $content = file_get_contents('view/blog.html');
    }else if($path == '/getArticles'){
        exit(Blog::getArticles());
    }else if($explodePath[1] == 'getArticleById'){
        $articleId = $explodePath[2];
        exit(Blog::getArticleById($articleId));
    } else if($explodePath[1] == 'blog'){
        $content = file_get_contents('view/article.html');
    } else if($path == '/isAuth'){
        exit(User::isAuth());
    } else if($explodePath[1] == 'editArticle' and $method == "GET"){
        $content = file_get_contents('view/editArticle.html');
    } else if($explodePath[1] == 'editArticle' and $method == "POST"){
        $articleId = $explodePath[2];
        exit(Blog::editArticle($articleId));
    }else if($explodePath[1] == "deleteArticle"){
        $articleId = $explodePath[2];
        exit(Blog::deleteArticle($articleId));
    }else if($path == '/logout'){
        session_destroy();
        header('Location: /blog');
    }else if($path == '/uploadAvatar'){
        exit(User::uploadAvatar());
    }
    require_once('view/template.php');