<?php
session_start();
require('auto/autoload.php');

if($_POST){
    $post = Post::init();
    if(isset($_POST['create'])){
        $_SESSION['create'] = $post->createPost($_POST['userId'], $_POST['title'], $_POST['body']);
    } elseif(isset($_POST['update'])){
        $_SESSION['update'] = $post->updatePost($_POST['id'], $_POST['title'], $_POST['body'], $_POST['userId']);
    }
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$user = Data::init();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{JSON} Placeholder (Задание)</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php if(!empty($_SESSION['create'])):?>
        <h2 class="center">New Post</h2>
        <h3>User: <?= $_SESSION['create']->userId ?></h3>
        <h3>Post id: <?= $_SESSION['create']->id ?></h3>
        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>">Back</a>
        <div class="flex">
            <div class="blocks">
                <p><b>Title:</b> <?= $_SESSION['create']->title?></p>
                <p><b>Body:</b> <?= $_SESSION['create']->body?></p>
            </div>
        </div>
        <?php unset($_SESSION['create'])?>
    <?php elseif(!empty($_SESSION['update'])): ?>
        <h2 class="center">Update Post</h2>
        <h3>User: <?= $_SESSION['update']->userId ?></h3>
        <h3>Post Id: <?= $_SESSION['update']->id ?></h3>
        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>">Back</a>
        <div class="flex">
            <div class="blocks">
                <p><b>Title:</b> <?= $_SESSION['update']->title?></p>
                <p><b>Body:</b> <?= $_SESSION['update']->body?></p>
            </div>
        </div>
        <?php unset($_SESSION['update'])?>
    <?php elseif(!empty($_SESSION['delete'])): ?>
        <h2>Post deleted</h2>
        <?php unset($_SESSION['delete'])?>
    <?php elseif(empty($_GET)): ?>
        <h2 class="center">Table Users</h2>
        <div class="flex">    
            <?php foreach($user->getUser() as $value): ?>
                <div class="block">
                    <p><b>Name:</b> <?= $value->name?></p>
                    <p><b>Username:</b> <?= $value->username?></p>
                    <p><b>Email:</b> <?= $value->email?></p>
                    <p class="addr"><b>address:</b> 
                        <span><i>city</i> <?= $value->address->city?> </span>
                        <span><i>street</i> <?= $value->address->street?> </span>
                        <span><i>suite</i> <?= $value->address->suite?> </span>
                        <span><i>zipcode</i> <?= $value->address->zipcode?></span>
                        <i class="geo">geo</i> 
                            <span class="m"><i>lat</i> <?= $value->address->geo->lat?></span>
                            <span class="m"><i>lng</i> <?= $value->address->geo->lng?></span>
                    </p>
                    <p><b>Phone:</b> <?= $value->phone?></p>
                    <p><b>Website:</b> <?= $value->website?></p>
                    <p class="com"><b>Company:</b>
                        <span><i>name</i> <?= $value->company->name?></span>
                        <span><i>catchPhrase</i> <?= $value->company->catchPhrase?></span>
                        <span><i>bs</i> <?= $value->company->bs?></span>
                    </p>
                    <div class="div">
                        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>?user=<?= $value->id?>&post">Posts</a>
                        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>?user=<?= $value->id?>&todos">Todos</a>
                    </div>
                    
                </div>
            <?php endforeach; ?>    
        </div>
    <?php elseif(isset($_GET['user']) && isset($_GET['post'])): ?>
        <h2 class="center">Table Posts</h2>
        
        <h3>User: <?= $_GET['user']?></h3>
        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>?user=<?= $_GET['user']?>&create">Create</a>
        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>">Back</a>
    
        <div class="flex">
            <?php foreach($user->getPost($_GET['user']) as $value): ?>
                <div class="block flex">
                    <p><b>Title:</b> <?= $value->title?></p>
                    <p><b>Body:</b> <?= $value->body?></p>
                    <div class="div">
                        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>?user=<?= $_GET['user']?>&posts=<?= $value->id?>&update">Update</a>
                        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>?user=<?= $_GET['user']?>&posts=<?= $value->id?>&delete">Delete</a>
                    </div>  
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif(isset($_GET['user']) && isset($_GET['todos'])): ?>
        <h2 class="center">Table Todos</h2>
        
        <h3>User: <?= $_GET['user']?></h3>
        <a class="btn" href="<?= $_SERVER['PHP_SELF']?>">Back</a>
    
        <div class="flex">
            <?php foreach($user->getTodos($_GET['user']) as $value): ?>
                <div class="blocks">
                    <p><b>Title:</b> <?= $value->title?></p>
                    <p><b>Completed:</b> <?php if($value->completed) echo 'true'; else echo 'false';?></p>  
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif(isset($_GET['user']) && isset($_GET['create'])): ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <div>
                Title: <input type="text" name="title" required>
            </div>
            <div>
                Body: <textarea name="body" required></textarea>
            </div>
            <input type="hidden" name="userId" value="<?= $_GET['user']?>" >
            <input type="submit" name='create' value="Create">
        </form>
    <?php elseif(isset($_GET['user']) && isset($_GET['update'])): ?>
        <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
            <div>
                Title: <input type="text" name="title" >
            </div>
            <div>
                Body: <textarea name="body" ></textarea>
            </div>
            <input type="hidden" name="userId" value="<?= $_GET['user']?>">
            <input type="hidden" name="id" value="<?= $_GET['posts']?>">
            <input type="submit" name='update' value="Update">
        </form>
    <?php elseif(isset($_GET['user']) && isset($_GET['delete'])): ?>
        <?php
            $post = Post::init();
            $_SESSION['delete'] = $post->deletePost($_POST['id']);
            header('location: '. $_SERVER['PHP_SELF']);
            exit;
        ?>
    <?php endif; ?>
</body>
</html>