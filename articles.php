<?php
  require "includes/config.php"
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title'] ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="\media\assets\bootstrap-grid-only\css\grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

  <div id="wrapper">

    
    <?php include "includes/header.php";
    
    $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);

    if (mysqli_num_rows($article) <= 0)
    {    
      ?>
        <div class="content">
          <div class="container">
            <div class="row">

              <section class="content__left col-md-8">
                <div class="block">
                  <h3>Такая статья не найдена!</h3>
                  <div class="block_content">
                    <div class="full-text">
                      Запрашиваемая вами статья не существует.
                    </div>
                  </div>
                </div>
              </section>

              <section class="content__right col-md-4">
                <?php include "includes/sidebar.php"; ?>
              </section>

            </div>
          </div>
        </div>

      <?php
    } else
    {
      $art = mysqli_fetch_assoc($article);
      mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $art['id'])
      ?>
      <div class="content">
        <div class="container">
          <div class="row">
            <section class="content__left col-md-8">

              <div class="block">
                <a ><?php echo $art['views'] ?> просмотров</a>
                <h3><?php echo $art['title'] ?></h3>

                <div class="block_content">
                  <img src="/static/images/<?php echo $art['images']; ?>" style="max-width: 100%;">

                  <div class="full-text">
                    <?php echo nl2br($art['text']) ?>
                  </div>

                </div>
              </div>
                  <div class="block">
                    <a href="#comment-add-form">Добавить комментарий</a>
                    
                    <h3>Комментарии</h3>
                    <div class="block_content">
                      <div class="articles articles_vertical">
                       
                        <?php 
                          $comments = mysqli_query($connection, "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $art['id'] . " ORDER BY `id` DESC");
                          if (mysqli_num_rows($comments) <= 0)
                          {
                            echo "К этой статье пока нет комментариев!";
                          }
                          while ( $comment = mysqli_fetch_assoc($comments) ) 
                          {
                            ?>
                              <article class="article">
                              <div class="article_image" style="background-image: url(https://ru.gravatar.com/avatar/<?php echo md5($comment['email']); ?>);"></div>
                              <div class="article_info">
                                <a href="/articles.php?id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['author']; ?></a>
                                <div class="article_info_meta"></div>
                                <div class="article_info_preview"><?php echo $comment['text']?></div>
                              </div>
                            </article>
                            <?php
                          }
                        ?>

                      </div>
                    </div>
                  </div>
              

                    <div id="comment-add-form" class="block">
                      <h3>Добавить комментарий</h3>
                      <div class="block_content">
                        <form class="form" method="POST" action="/articles.php?id=<?php echo $art['id']; ?>#comment-add-form">

                          <?php 
                            if (isset($_POST['do_post']) )
                            {
                              $errors = array();

                              if ( $_POST['name'] == '' )
                              {
                                $errors[] = 'Введите имя!';
                              }

                              if ( $_POST['nickname'] == '' )
                              {
                                $errors[] = 'Введите никнейм!';
                              }

                              if ( $_POST['email'] == '' )
                              {
                                $errors[] = 'Введите email!';
                              }

                              if ( $_POST['text'] == '' )
                              {
                                $errors[] = 'Введите текст комментария!';
                              }

                              if (empty($errors)) 
                              {
                                //разрешить добавить комментарий
                                mysqli_query($connection, "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `pubdate`, `articles_id`) VALUES ('".$_POST['name']."', '".$_POST['nickname']."','".$_POST['email']."','".$_POST['text']."', NOW(), '".$art['id']."')");

                                echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;">Комментарий сохранён</span>';
                              }
                              else
                              {
                                //вывести текст ошибки
                                echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">' . $errors['0'] . '</span>';
                              }
                            }

                          ?>

                          <div class="form_group">
                            <div class="row">
                              <div class="col-md-4">
                                <input type="text" name="name" class="form_control" placeholder="Имя" value="<?php echo($_POST['name']) ?>">
                              </div>
                              <div class="col-md-4">
                                <input type="text" name="nickname" class="form_control" placeholder="Никнейм" value="<?php echo($_POST['nickname']) ?>">
                              </div>
                              <div class="col-md-4">
                                <input type="text "name="email" class="form_control" placeholder="Почта (не будет показана)" value="<?php echo($_POST['email']) ?>">
                              </div>
                            </div>
                          </div>
                          <div class="form_group">
                            <textarea class="form_control" name="text" placeholder="Текст комментария..."><?php echo($_POST['text']) ?></textarea>
                          </div>
                          <div class="form_group">
                            <input type="submit" name="do_post" value="Добавить комментарий" class="form_control">
                          </div>
                        </form>
                      </div>
                    </div>

            </section>
            <section class="content__right col-md-4">
              <?php include "includes/sidebar.php"; ?>
            </section>
          </div>
        </div>
      </div>
    </div>
    <?php
    }
    ?>
  <?php include"includes/footer.php"; ?>

</body>
</html>