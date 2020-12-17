<?php
	require "includes/config.php"
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title><?php echo $config['title'] ?></title>

	<!-- Bootstrap Grid -->
	<link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

	<!-- Custom -->
	<link rel="stylesheet" type="text/css" href="/media/css/style.css">
</head>
<body>

	<div class="wrapper">

		
			<?php include "includes/header.php"; ?>
		

		<div class="content">
			<div class="container">
				<div class="row">
					<section class="content__left col-md-8">
						<div class="block">
							<a href="/article.php">Все статьи</a>
							<h3>Новейшее в блоге</h3>
							<div class="block_content">
								<div class="articles articles_horizontal">
								  <?php 
								    $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY 'id' DESC LIMIT 10");

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
													<div class="article_info_preview"><?php echo mb_substr(nl2br($art['text']), 0, 100, 'utf-8') . '...'; ?></div>
												</div>
											</article>
								  		<?php
								  	}
								  ?>

								</div>
							</div>
						</div>

						<div class="block">
							<a href="/article.php?categorie=6">Все статьи</a>
							<h3>Безопасность [Новейшее]</h3>
							<div class="block_content">
								<div class="articles articles_horizontal">

								<?php 
								    $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = 6 ORDER BY 'id' DESC LIMIT 10");
								    
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
							<a href="/article.php?categorie=3">Все статьи</a>
							<h3>Программирование [Новейшее]</h3>
							<div class="block_content">
								<div class="articles articles_horizontal">

									<?php 
								    $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` = 3 ORDER BY 'id' DESC LIMIT 10");
								    
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
					</section>
					<section class="content__right col-md-4">
						<?php include "includes/sidebar.php"; ?>
					</section>
				</div>
			</div>
		</div>
	</div>

	<?php include"includes/footer.php"; ?>

</body>
</html>