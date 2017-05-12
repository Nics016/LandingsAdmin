<?php 
	namespace landing;

	require('Place.php');
	require('LandingService.php');

	use landing\Place;
	use landing\LandingService;

	// Получение данных о сайте
	$username = 'test_manager';
	$pass = '555666888';
	$data = LandingService::getData(
		$username,
		$pass
	);
	$landing = $data['landing'];
	$places = $data['places'];

	// Обработка заявок
	if (isset($_POST['client_name'])){
		$client_name = LandingService::check_input($_POST['client_name']);
		if (isset($_POST['client_msg']))
			$client_msg = LandingService::check_input($_POST['client_msg']);
		if (isset($_POST['client_email']))
			$client_email = LandingService::check_input($_POST['client_email']);
		$msg = "<h1 style='color:green'>Поступило новое сообщение на вашем сайте!</h1><br>";
		if (isset($_POST['client_email']))
			$msg = "<h1 style='color:green'>Поступила новая заявка на вашем сайте!</h1><br>";
		 		$msg .= "<h2> Имя - ".$client_name."</h2>";
		 		if (isset($_POST['client_email']))
		 			$msg .= "<h2> Email - ".$client_email."</h2>";
				if (isset($_POST['client_msg']))
		 			$msg .= "<h2> Сообщение : ".$client_msg."</h2>";
		$topic = 'Пришло новое сообщение на вашем сайте "' . $landing['title'] . '"';
		if (isset($_POST['client_email']))
			$topic = 'Поступила новая заявка на вашем сайте "' . $landing['title'] . '"!';
		$email = $landing['email'];
		LandingService::SendEmail($username, $pass, $msg, $topic, $email);
		echo 'Ваше сообщение было успешно отправлено. Спасибо!';		
	}
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $landing['building_type'] ?> <?= $landing['title'] ?></title>
	<link href="css/plagins.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/style750.css" rel="stylesheet">
	<link href="css/style320.css" rel="stylesheet">
</head>
<body>

<div id="main">
	<header id="header">
		<div class="header_top">
			<div class="header_box">
				<h1 class="logo">
					<a href="#">
						<span><?= $landing['building_type'] ?></span>
							
						<?php if (is_array($data)): ?>
							<?= $landing['title'] ?>
						<?php else: ?>
							<?= $data ?>
						<?php endif; ?>
					</a>
				</h1>
				<div class="head_phone">
					Отдел аренды
					<span class="phone"><a href="tel:"><?= $landing['phone'] ?></a></span>
				</div>
				<span class="head_address">
					<?= $landing['address'] ?>
				</span>
			</div>
		</div>
		<div class="header_bot" style="background: url(<?= $landing['bg_photo'] ?>)">
			<div class="header_btn">
				<div class="header_box">
					<div class="header_bot_col">
						<a href="sc_free" class="btn_blue btn_scroll">СВОБОДНЫЕ ПОМЕЩЕНИЯ</a>
					</div>
					<div class="header_bot_col">
						<a href="#" class="btn_blue open_popup" data-id-popup="p_form">ОСТАВИТЬ ЗАЯВКУ</a>
					</div>
				</div>
			</div>
			<nav>
				<a href="#" class="open_menu"><span></span></a>
				<ul class="menu">
					<li><a href="#m_photo">Фотографии</a></li>
					<li><a href="#m_object">Об объекте</a></li>
					<li><a href="#m_data">Характеристики</a></li>
					<li><a href="index.html">Новости</a></li>
					<li><a href="#m_info">Инфраструктура</a></li>
					<li><a href="#m_address">Расположение </a></li>
					<li><a href="#map">Контакты </a></li>
					<li><a href="#m_partner">Арендаторы</a></li>
				</ul>
			</nav>
		</div>
	</header>

	


	<!--CONTENT-->
	<div class="content">


		<section class="section" id="sc_free">
			<div class="content_box">
				<div class="head_title">
					<h2>Свободные площади</h2>
					<p>Свободные площади <strong><a href="tel:" class="tel"><?= $landing['phone'] ?></a></strong></p>
				</div>
				<table class="tbl_free">
					<tr>
						<th>Площадь, кв.м.</th>
						<th>Этаж</th>
						<th>Цена, кв.м./год</th>
						<th>Состояние</th>
						<th>Планировка</th>
						<th>Фото</th>
					</tr>
					<?php foreach($places as $place): ?>
						<tr>
							<td><?= LandingService::stripZero($place['meters']) ?></td>
							<td><?= $place['floor'] ?></td>
							<td><?= LandingService::proccessPrice($place['price']) ?> <?= Place::getDdlText($place['price_sign'], Place::PRICE_SIGN) ?></td>
							<td><?= Place::getDdlText($place['state'], Place::STATE) ?></td>
							<td><?= Place::getDdlText($place['planning'], Place::PLANNING) ?></td>
							<td><span class="underline">Фото</span></td>
						</tr>
						<tr class="tbl_hidden">
							<td colspan="6">
								<div class="free_photo">
									<ul class="list_photo">
										<?php foreach(json_decode($place['object_photos']) as $photo): ?>
										<li>
											<a href="<?= $photo ?>" rel="group1"><img src="<?= $photo ?>" alt=""></a>
										</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
				<form method="POST">
				<div class="form_page">
					<label>Ваше имя *</label>
					<div class="in_box">
						<input type="text" class="tx" name="client_name">
					</div>
					<label>Собщение</label>
					<div class="in_box">
						<textarea name="client_msg"></textarea>
					</div>
					<button class="btn_blue" type="submit">Отправить</button>
				</div>
			</form>
			</div>
		</section>



		<section class="galery" id="m_photo">
			<div class="content_box">
				<div class="head_title">
					<h2>ФОТОГАЛЕРЕЯ</h2>
				</div>
				<ul class="list_photo">
					<?php foreach(json_decode($landing['photos']) as $photo): ?>
					<li>
						<a href="<?= $photo ?>" rel="galery"><img src="<?= $photo ?>" alt=""></a>
					</li>
				<?php endforeach; ?>					
				</ul>
			</div>
		</section>


		<section class="section" id="m_object">
			<div class="content_box">
				<div class="head_title">
					<h2>Об объекте</h2>
				</div>
				<?= $landing['about_text'] ?>
			</div>
		</section>


		<section class="section" id="m_data">
			<div class="content_box">
				<div class="head_title">
					<h2>характеристики</h2>
				</div>
				<?= $landing['characteristics_text'] ?>
			</div>
		</section>


		<section class="section" id="m_info">
			<div class="content_box">
				<div class="head_title">
					<h2>Инфраструктура</h2>
				</div>
				<?= $landing['infostructure_text'] ?>
			</div>
		</section>


		<section class="section" id="m_address">
			<div class="content_box">
				<div class="head_title">
					<h2>РАСПОЛОЖЕНИЕ</h2>
				</div>
				<?= $landing['location_text'] ?>
			</div>
			<div id="map"></div>
		</section>


		<section class="section partners" id="m_partner">
			<div class="content_box">
				<div class="head_title">
					<h2>АРЕНДАТОРЫ БИЗНЕС-ЦЕНТРА</h2>
				</div>
				<ul class="list_partners">
					<?php foreach(json_decode($landing['arendator_photos']) as $photo): ?>
					<li>
						<span class="partners_one">
							<img src="<?= $photo ?>" alt="">
						</span>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</section>


	</div>
</div>

<div class="popup" id="p_form">
	<div class="popup_box">
		<a href="#" class="clouse_popup"></a>
		<form method="POST">
			<div class="form_page">
				<label>Ваше имя *</label>
				<div class="in_box">
					<input type="text" class="tx" name="client_name">
				</div>
				<label>Эл. почта *</label>
				<div class="in_box">
					<input type="text" class="tx" name="client_email">
				</div>
				<button class="btn_blue" type="submit">Отправить</button>
			</div>
		</form>
	</div>
</div>





	<!--[if lt IE 9]>
	  <script src="js/html5.js"></script>
	<![endif]-->
	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU" type="text/javascript"></script>
	<script src="js/plagins.js"></script>
	<script src="js/scripts.js"></script>
	<script>
		var latitude = parseFloat(<?= $landing['latitude'] ?>);
		var longitude = parseFloat(<?= $landing['longitude'] ?>);
		generateMap(latitude, longitude);
	</script>
</body>
</html>
