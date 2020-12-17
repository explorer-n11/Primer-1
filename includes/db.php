<?php

//include - просто подключает файл, если не находит - выдаёт ошибку без прерывания
//include_once - подключает файл только один раз, если не находит - выдаёт ошибку без прерывания
//require - просто подключает файл, если не находит - прекращает выполнение скрипта
//require_once - подключает файл только один раз, если не находит - прекращает выполнение скрипта

	$connection = mysqli_connect(
		$config['db']['server'],
		$config['db']['username'],
		$config['db']['password'],
		$config['db']['name']
	);

	if ( $connection == false )
	{
		echo 'Не удалось подключиться к базе данных!<br>';
		echo mysqli_connect_error();
		exit();
	}