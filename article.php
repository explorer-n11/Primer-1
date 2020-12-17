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
							<h3>Все статьи</h3>
							<div class="block_content">
								<div class="articles articles_horizontal">
								  <?php 
								  	$per_pages = 4;
								  	$page = 1;
								  	$categorie = 'IS NOT NULL';

								  	if (isset($_GET['page'])) 
								  	{
								  		$page = (int) $_GET['page'];
								  	}

								  	if (isset($_GET['categorie']))
								  	{
								  		$categorie = "= ".(int) $_GET['categorie'];
								  	}

								  	$total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count_q` FROM `articles` WHERE `categorie_id` ".$categorie);
								  	$total_count = mysqli_fetch_array($total_count_q);
									  	$total_pages = ceil($total_count[0] / $per_pages);

									  	if ($page <= 1 || $page > $total_pages) 
									  	{
									  		$page = 1;
										}

										$offset = ($per_pages * $page) - $per_pages;

									    $articles = mysqli_query($connection, "SELECT * FROM `articles` WHERE `categorie_id` ".$categorie." ORDER BY 'id' DESC LIMIT $offset,$per_pages");
								  	#$total_count = mysqli_fetch_assoc($total_count_q);
								  	#$total_count = $total_count['total_count']; //не работает!!!
								  	

								    $articles_exist = true;

								    if (mysqli_num_rows($articles) <= 0) 
								    {
								    	echo 'Не обнаружено ни одной статьи!';
								    	$articles_exist = false;
								    }

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
							  	<?php
								  	if ( $articles_exist == true ) 
								  	{
								  		echo '<div class="paginator">';
								  			if ($page > 1) 
								  			{
								  				echo '<a href="/article.php?page='.($page - 1).'">&laquo; Назад</a> ';
								  			}
								  			if ($page < $total_pages) 
									  		{
									  			echo '<a href="/article.php?page='.($page + 1).'">Вперёд &raquo;</a>';
									  		}
								  		echo '</div>';
								  	}
								?>
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