<?php
	require "includes/config.php";

	$echo = "<div class='table'>
		<div class='table-wrapper'>
			<div class='block'>
				<h3>Войти в панель администратора</h3>
				<form method='post' id='login-form' class='login-form'>
					<input type='text' placeholder='Логин' class='input' name='login' required><br>
					<input type='password' placeholder='Пароль' class='input' name='password' required><br>
					<input type='submit' value='Войти' class='button'>
				</form>
			</div>
		</div>
	</div>";

	function login($db,$login,$password)
	{
		//Обязательно нужно провести валидацию логина и пароля, чтобы исключить вероятность инъекции
		//Запрос в базу данных

		$loginResult = mysqli_query($db, 'SELECT * FROM `users` WHERE `login` = "' . $login . '" AND `password` = "' . $password . '" AND `privilegy` = 1');
		if(mysqli_num_rows($loginResult) == 1)
		{
			//Если есть совпадение, возвращается true
			return true;
		}
		else
		{
			//Если такого пользователя не существует, данные стираются, а возвращается false
			unset($_SESSION['login'],$_SESSION['password']);
			return false;
		}
		//$login = '';
		//$password = '';
	}

	if(isset($_POST['login'])&& isset($_POST['password']))
	{
		$_SESSION['login']=$_POST['login'];
		$_SESSION['password']=$_POST['password'];
	}

	if(isset($_SESSION['login'])&& isset($_SESSION['password']))
	{
		if(login($connection,$_SESSION['login'],$_SESSION['password']))
		{
			//Попытка авторизации
			//Тут будут проходить все операции
			if(isset($_GET['act']))
			{
				$act = $_GET['act'];
			}
			else
			{
				$act = 'home';
			}

			switch ($act) {
				case 'home':
					$article_result = mysqli_query($connection,'SELECT * FROM `articles`');
					if (mysqli_num_rows($article_result) >= 1) 
					{
						while ($article_array = mysqli_fetch_array($article_result)) {
							$articles.="<div class="."table-content_list-item".">
								<a class="."col-md-1"." href="."?act=edit_article&id=".$article_array['id'].">".$article_array['id']."</a>
								<a class="."col-md-1q"." href="."?act=edit_article&id=".$article_array['id']."> | ".$article_array['title']."</a>
							</div>";
						}
					}
					else
					{
						$articles = "Статей нет";
					}

					$users_result = mysqli_query($connection,'SELECT * FROM `users`');
					if (mysqli_num_rows($users_result) >= 1) 
					{
						while ($users_array = mysqli_fetch_array($users_result)) {
							$users.="<div class="."table-content_list-item".">
								<a class="."col-md-1"." href="."?act=edit_user&id=".$users_array['id'].">".$users_array['id']."</a>
								<a class="."col-md-11"." href="."?act=edit_user&id=".$users_array['id']."> | ".$users_array['login']."</a>
							</div>";
						}
					}
					else
					{
						$users = "Пользователи не обнаружены";
					}
					$echo =
					"<div class='tables'>

						<div class='col-md-6'>
							<div class='table-wrapper'>
								<div class='block'>
									<h3>Страницы</h3><hr>
									$articles<hr>
									<a href='?act=add_article' class='col-md-6' id='add-article'>+</a>
								</div>
							</div>
						</div>

						<div class='col-md-6'>
							<div class='table-wrapper'>
								<div class='block'>
									<h3>Пользователи</h3><hr>
									$users<hr>
									<a href='?act=add_user' class='col-md-6' id='add-user'>+</a>
								</div>
							</div>
						</div>
						
					</div>";			
				break;

				case 'edit_article':
					if (isset($_GET['id'])) 
					{
						(int) $id = $_GET['id'];
						
						$result=mysqli_query($connection,'SELECT * FROM `articles` WHERE `id` = ' . $id);

						if (mysqli_num_rows($result) == 1) {

							if (isset($_POST['title']) && isset($_POST['text']) && isset($_POST['categorie_id'])) {
								//Тут должна быть валидация

								//Обновление таблицы

								$update = mysqli_query($connection, ('UPDATE `articles` SET `title` = '.$_POST['title'].', `text` = '.$_POST['text'].', `categorie_id` = '.$_POST['categorie_id'].' WHERE `id` = '.$id));

								if ($update)  {
									//Если обновление прошло успешно, получаются новые данные
									$result = mysqli_query('SELECT * FROM `articles` WHERE `id` = '.$id);

									$message = "Таблица успешно обновлена!";
								}
								else
								{
									$message = "Обшибка при обновлении таблицы!";
								}
							  
							}

							$article = mysqli_fetch_array($result);//Получение информации в массив

							//Форма редактирования
							$echo = 
      							"<div class='table'>
									<div class='table-wrapper'>
										<div class='block'>
											<h3 class='col-md-6'>Редактирование статьи</h3>
											<a class='col-rd-6' href='?act=home'>Вернуться</a><br><br>
											

											<form method='post' class='article'>
												<a class='col-md-2'>Название: </a>

												<textarea class='col-md-10' name='title'>".$article['title']."</textarea><br>

												<a class='col-md-2'>Текст: </a>

												<textarea class='col-md-10' name='text'>".$article['text']."</textarea><br>

												<a class='col-md-2'>ИД категории: </a>

												<input class='col-md-10' type='text' name='categorie_id' value=".$article['categorie_id']."><br>

												<input type='submit' class='button' name='submit_edit' value='Сохранить''><br><br>
											</form>
										</div>
									</div>
								</div>";
							
						}
					}
				break;

				case 'edit_user':
					if (isset($_GET['id'])) 
					{
						(int) $id = $_GET['id'];
						$result = mysqli_query($connection,'SELECT * FROM `users` WHERE `id` = '.$id);

						if (mysqli_num_rows($result) == 1) {

							if ( isset($_POST['login']) && isset($_POST['password']) && isset($_POST['privilegy']) ) {
								//Тут должна быть валидация

								//Обновление таблицы

								$update = mysqli_query($connection,'UPDATE `users` SET `login` = '.$_POST['login'].', `password` = '.$_POST['password'].', `privilegy` = '.$_POST['privilegy']. ' WHERE `id` = '.$id);

								if ($update) {
									//Если обновление прошло успешно, получаются новые данные
									$result = mysqli_query('SELECT * FROM `users` WHERE `id` = '.$id);

									$message = "Таблица успешно обновлена!";
								}
								else
								{
									$message = "Обшибка при обновлении таблицы!";
								}
							}

							$article = mysqli_fetch_array($result);//Получение информации в массив

							//Форма редактирования

							$echo = "<div class='table'>
								<div class='table-wrapper'>
									<div class='block'>
										<h3>Редактирование статьи</h3>
										<a href='?act=home'>Вернуться</a><br>
										$message<br>
										<form method='post' class='article'>
										<a class="."col-md-2".">Логин: </a><input class="."col-md-10"." type='text' name='login_edit' value=".$article['login']."><br>
										<a class="."col-md-2".">Пароль: </a><input class="."col-md-10"." type='password' name='password_edit' value=".$article['password']."><br>
										<a class="."col-md-2".">Права: </a><input class="."col-md-10"." type='text' name='privilegy' value=".$article['privilegy']."><br>
										<input type='submit' class='button' value='Сохранить'>
										</form>
									</div>
								</div>
							</div>";
						}
					}
				break;

			}

			//$echo = null; //Обнуление переменной, чтобы удалить из вывода форму авторизации
			//echo "<div>Успех</div>";
		}
		else
		{
			echo "<div>Неправильный логин или пароль</div>";
		}
	}

 ?>

<!DOCTYPE html>
<html lang="ru">
	 <head>
	 	<title>Панель администратора</title>
	 	<!-- Bootstrap Grid -->
		<link rel="stylesheet" type="text/css" href="/media/assets/bootstrap-grid-only/css/grid12.css">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

		<!-- Custom -->
		<link rel="stylesheet" type="text/css" href="/media/css/style.css">
	 </head>

	 <body>
	 	<div class="wrapper">
	 		<main class="main" id="main">
	 			<?php echo $echo; ?>
	 		</main>
	 	</div>
	 </body>
 </html>