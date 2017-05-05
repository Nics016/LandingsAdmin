<?php 
	function getData(){
		$url="http://landings.devcloud.pro/?r=data/get-landing-data&id=1";
		$username = "manager";
		$password = "333777";

		//  Initiate curl
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Set data for auth
		curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

		// Execute
		$exec_result=curl_exec($ch);
		$result = json_decode($exec_result, true);
		// Closing
		curl_close($ch);

		return $result;
	}

	$data = getData();
 ?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $data['title'] ?></title>
	<link href="css/plagins.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="css/style750.css" rel="stylesheet">
	<link href="css/style320.css" rel="stylesheet">
</head>
<body>


<div id="main">
	<header id="header">
		<h1 style="text-align: center;"><?= $data['title'] ?></h1>
	</header>

	


	<!--CONTENT-->
	<div class="content">


		<section class="section" id="sc_free">
			<div class="content_box">
				<div class="head_title">
					<h2>Свободные площади</h2>
					<p>Свободные площади <strong><a href="tel:" class="tel">8 (495) 637-84-54</a></strong></p>
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
					<tr>
						<td>771</td>
						<td>3</td>
						<td>32 203 руб.</td>
						<td>С отделкой</td>
						<td></td>
						<td><span class="underline">Фото</span></td>
					</tr>
					<tr class="tbl_hidden">
						<td colspan="6">
							<div class="free_photo">
								<ul class="list_photo">
									<li>
										<a href="img/img_photo_1.jpg" rel="group1"><img src="img/img_photo_1.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_2.jpg" rel="group1"><img src="img/img_photo_2.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_3.jpg" rel="group1"><img src="img/img_photo_3.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_4.jpg" rel="group1"><img src="img/img_photo_4.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_5.jpg" rel="group1"><img src="img/img_photo_5.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_6.jpg" rel="group1"><img src="img/img_photo_6.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_7.jpg" rel="group1"><img src="img/img_photo_7.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_8.jpg" rel="group1"><img src="img/img_photo_8.jpg" alt=""></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td>535</td>
						<td>4</td>
						<td>32 203 руб.</td>
						<td>С отделкой</td>
						<td></td>
						<td><span class="underline">Фото</span></td>
					</tr>
					<tr class="tbl_hidden">
						<td colspan="6">
							<div class="free_photo">
								<ul class="list_photo">
									<li>
										<a href="img/img_photo_1.jpg" rel="group2"><img src="img/img_photo_1.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_2.jpg" rel="group2"><img src="img/img_photo_2.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_3.jpg" rel="group2"><img src="img/img_photo_3.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_4.jpg" rel="group2"><img src="img/img_photo_4.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_5.jpg" rel="group2"><img src="img/img_photo_5.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_6.jpg" rel="group2"><img src="img/img_photo_6.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_7.jpg" rel="group2"><img src="img/img_photo_7.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_8.jpg" rel="group2"><img src="img/img_photo_8.jpg" alt=""></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td>1153.2</td>
						<td>10</td>
						<td>32 203 руб.</td>
						<td>С отделкой</td>
						<td></td>
						<td><span class="underline">Фото</span></td>
					</tr>
					<tr class="tbl_hidden">
						<td colspan="6">
							<div class="free_photo">
								<ul class="list_photo">
									<li>
										<a href="img/img_photo_1.jpg" rel="group3"><img src="img/img_photo_1.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_2.jpg" rel="group3"><img src="img/img_photo_2.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_3.jpg" rel="group3"><img src="img/img_photo_3.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_4.jpg" rel="group3"><img src="img/img_photo_4.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_5.jpg" rel="group3"><img src="img/img_photo_5.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_6.jpg" rel="group3"><img src="img/img_photo_6.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_7.jpg" rel="group3"><img src="img/img_photo_7.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_8.jpg"><img src="img/img_photo_8.jpg" alt=""></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td>1101.8</td>
						<td>17</td>
						<td>32 203 руб.</td>
						<td>С отделкой</td>
						<td></td>
						<td><span class="underline">Фото</span></td>
					</tr>
					<tr class="tbl_hidden">
						<td colspan="6">
							<div class="free_photo">
								<ul class="list_photo">
									<li>
										<a href="img/img_photo_1.jpg" rel="group4"><img src="img/img_photo_1.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_2.jpg" rel="group4"><img src="img/img_photo_2.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_3.jpg" rel="group4"><img src="img/img_photo_3.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_4.jpg" rel="group4"><img src="img/img_photo_4.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_5.jpg" rel="group4"><img src="img/img_photo_5.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_6.jpg" rel="group4"><img src="img/img_photo_6.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_7.jpg" rel="group4"><img src="img/img_photo_7.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_8.jpg" rel="group4"><img src="img/img_photo_8.jpg" alt=""></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					<tr>
						<td>690.3</td>
						<td>19</td>
						<td> 32 203 руб.</td>
						<td>С отделкой</td>
						<td></td>
						<td><span class="underline">Фото</span></td>
					</tr>
					<tr class="tbl_hidden">
						<td colspan="6">
							<div class="free_photo">
								<ul class="list_photo">
									<li>
										<a href="img/img_photo_1.jpg" rel="group5"><img src="img/img_photo_1.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_2.jpg" rel="group5"><img src="img/img_photo_2.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_3.jpg" rel="group5"><img src="img/img_photo_3.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_4.jpg" rel="group5"><img src="img/img_photo_4.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_5.jpg" rel="group5"><img src="img/img_photo_5.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_6.jpg" rel="group5"><img src="img/img_photo_6.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_7.jpg" rel="group5"><img src="img/img_photo_7.jpg" alt=""></a>
									</li>
									<li>
										<a href="img/img_photo_8.jpg" rel="group5"><img src="img/img_photo_8.jpg" alt=""></a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
				</table>
				<form>
				<div class="form_page">
					<label>Ваше имя *</label>
					<div class="in_box">
						<input type="text" class="tx">
					</div>
					<label>Собщение</label>
					<div class="in_box">
						<textarea></textarea>
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
					<li>
						<a href="img/img_photo_1.jpg" rel="galery"><img src="img/img_photo_1.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_2.jpg" rel="galery"><img src="img/img_photo_2.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_3.jpg" rel="galery"><img src="img/img_photo_3.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_4.jpg" rel="galery"><img src="img/img_photo_4.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_5.jpg" rel="galery"><img src="img/img_photo_5.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_6.jpg" rel="galery"><img src="img/img_photo_6.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_7.jpg" rel="galery"><img src="img/img_photo_7.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_8.jpg" rel="galery"><img src="img/img_photo_8.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_1.jpg" rel="galery"><img src="img/img_photo_1.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_2.jpg" rel="galery"><img src="img/img_photo_2.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_3.jpg" rel="galery"><img src="img/img_photo_3.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_4.jpg" rel="galery"><img src="img/img_photo_4.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_5.jpg" rel="galery"><img src="img/img_photo_5.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_6.jpg" rel="galery"><img src="img/img_photo_6.jpg" alt=""></a>
					</li>
					<li>
						<a href="img/img_photo_7.jpg" rel="galery"><img src="img/img_photo_7.jpg" alt=""></a>
					</li>
				</ul>
			</div>
		</section>


		<section class="section" id="m_object">
			<div class="content_box">
				<div class="head_title">
					<h2>Об объекте</h2>
				</div>
				<?= $data['about_text'] ?>
			</div>
		</section>


		<section class="section" id="m_data">
			<div class="content_box">
				<div class="head_title">
					<h2>характеристики</h2>
				</div>
				<p>Новый офисный комплекс, состоящий из трех офисных блоков, расположенных на единой стилобатной части. Общая площадь всего комплекса - 77 500 кв. м. 28-этажная башня (Блок 1) общей площадью 28 426 кв. м, специально спроектированная для размещения головного офиса крупной компании, является отдельной частью комплекса. Офисная часть башни составляет 18 556,84 кв. м. На 5-ти подземных уровнях здания расположены специализированные помещения широкого назначения, включая организацию сертифицированного хранилища. Панорамное остекление. Развитая инфраструктура. Столовая для арендаторов. Площадь типового этажа 400-1073 кв. м. Высота потолков - 3,9 м. Блок 1 оснащен вертолетной площадкой и обособленным VIP-паркингом на 7 м/м с отдельным лифтом и въездом. <br> Комплекс расположен между станциями метро Красные Ворота и Комсомольская. Непосредственный доступ к Бульварному и Садовому Кольцу, а также Третье транспортное кольцо. Легкий доступ ко всегоем частям города.</p>
			</div>
		</section>


		<section class="section" id="m_info">
			<div class="content_box">
				<div class="head_title">
					<h2>Инфраструктура</h2>
				</div>
				<p>Новый офисный комплекс, состоящий из трех офисных блоков, расположенных на единой стилобатной части. Общая площадь всего комплекса - 77 500 кв. м. 28-этажная башня (Блок 1) общей площадью 28 426 кв. м, специально спроектированная для размещения головного офиса крупной компании, является отдельной частью комплекса. Офисная часть башни составляет 18 556,84 кв. м. На 5-ти подземных уровнях здания расположены специализированные помещения широкого назначения, включая организацию сертифицированного хранилища. Панорамное остекление. Развитая инфраструктура. Столовая для арендаторов. Площадь типового этажа 400-1073 кв. м. Высота потолков - 3,9 м. Блок 1 оснащен вертолетной площадкой и обособленным VIP-паркингом на 7 м/м с отдельным лифтом и въездом. <br> Комплекс расположен между станциями метро Красные Ворота и Комсомольская. Непосредственный доступ к Бульварному и Садовому Кольцу, а также Третье транспортное кольцо. Легкий доступ ко всегоем частям города.</p>
			</div>
		</section>


		<section class="section" id="m_address">
			<div class="content_box">
				<div class="head_title">
					<h2>РАСПОЛОЖЕНИЕ</h2>
				</div>
				<p>5 минут ходьбы от м. Красные ворота. Комплекс расположен между станциями метро Красные Ворота и Комсомольская. Непосредственный доступ к Бульварному и Садовому Кольцу, а также Третье транспортное кольцо. Легкий доступ ко всем частям города.</p>
			</div>
			<div id="map"></div>
		</section>


		<section class="section partners" id="m_partner">
			<div class="content_box">
				<div class="head_title">
					<h2>АРЕНДАТОРЫ БИЗНЕС-ЦЕНТРА</h2>
				</div>
				<ul class="list_partners">
					<li>
						<span class="partners_one">
							<img src="img/img_partners_1.jpg" alt="">
						</span>
					</li>
					<li>
						<span class="partners_one">
							<img src="img/img_partners_2.jpg" alt="">
						</span>
					</li>
					<li>
						<span class="partners_one">
							<img src="img/img_partners_3.jpg" alt="">
						</span>
					</li>
					<li>
						<span class="partners_one">
							<img src="img/img_partners_4.jpg" alt="">
						</span>
					</li>
				</ul>
			</div>
		</section>


	</div>
</div>

<div class="popup" id="p_form">
	<div class="popup_box">
		<a href="#" class="clouse_popup"></a>
		<form>
			<div class="form_page">
				<label>Ваше имя *</label>
				<div class="in_box">
					<input type="text" class="tx">
				</div>
				<label>Эл. почта *</label>
				<div class="in_box">
					<input type="text" class="tx">
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
</body>
</html>
