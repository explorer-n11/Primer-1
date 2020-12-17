<div class="block">
  <h3>Мы знаем</h3>
  <div class="block_content">
    <script type="text/javascript" src="//rf.revolvermaps.com/0/0/8.js?i=5xdidq8bqz0&amp;m=7&amp;c=ff0000&amp;cr1=ffffff&amp;f=calibri&amp;l=49&amp;rs=100" async="async"></script>
  </div>
</div>

<div class="block">
  <h3>Топ читаемых татей</h3>
  <div class="block_content">
    <div class="articles articles_vertical">

                  <?php 
                    $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` DESC LIMIT 5");
                    
                    while ( $art = mysqli_fetch_assoc($articles) ) 
                    {
                      ?>
                        <article class="article">
                        <div class="article_image" style="background-image: url(/static/images/<?php echo $art['images']; ?>);"></div>
                        <div class="article_info">
                          <a href="/articles.php?id=<?php echo $art['id']; ?>"><?php echo $art['title']; ?></a>
                          <div class="article_info_meta">
                            <?php 
                              $art_cat = false;
                              foreach ($categories as $cat) 
                              {
                                if ($cat['id'] == $art['categorie_id'])
                                {
                                  $art_cat = $cat;
                                  break;
                                }
                              }
                            ?>
                            <small>Категория: <a href="/article.php?categorie=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title']; ?></a></small>
                          </div>
                          <div class="article_info_preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . '...'; ?></div>
                        </div>
                      </article>
                      <?php
                    }
                  ?>

    </div>
  </div>
</div>

<div class="block">
  <h3>Комментарии</h3>
  <div class="block_content">
    <div class="articles articles_vertical">

     
                  <?php 
                    $comments = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `pubdate` DESC LIMIT 5");
                    
                    while ( $comment = mysqli_fetch_assoc($comments) ) 
                    {
                      ?>
                        <article class="article">
                        <div class="article_image" style="background-image: url(https://ru.gravatar.com/avatar/<?php echo md5($comment['email']); ?>);"></div>
                        <div class="article_info">
                          <a href="/articles.php?id=<?php echo $comment['articles_id']; ?>"><?php echo $comment['author']; ?></a>
                          <div class="article_info_meta"></div>
                          <div class="article_info_preview"><?php echo mb_substr(strip_tags($comment['text']), 0, 100, 'utf-8') . '...'; ?></div>
                        </div>
                      </article>
                      <?php
                    }
                  ?>

    </div>
  </div>
</div>