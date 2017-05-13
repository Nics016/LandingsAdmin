<?php 
	namespace landing;
	
	use landing\LandingService;

	class LandingService
	{		
		const BASE_URL = 'http://landings.devcloud.pro/?r=data/';
		const CACHE_DIRNAME = 'cache/';
		const CACHE_FILENAME = LandingService::CACHE_DIRNAME . 'cache.data';
		const CACHE_MINUTES = 3;
		const ID = 1;

		/**
		 * Requests through curl data from server and returns it as array
		 * 
		 * @param  integer $id       id of the landing
		 * @param  string $username 
		 * @param  string $password 
		 * @return array $data
		 */
		public function getData($username, $password)
		{
			// only cache if LandingService::CACHE_MINUTES were passed
			if (LandingService::newRequestAllowed()){
				$url = LandingService::BASE_URL . "get-landing-data&id=" . LandingService::ID;

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

				// Execute command
				$exec_result = curl_exec($ch);
				$result = json_decode($exec_result, true);
				// Closing connection
				curl_close($ch);

				// if successful transfer data, return it
				// otherwise return cached
				if (is_array($result) 
						&& array_key_exists('status', $result)
						&& ($result['status'] === 'ok')) {
					$result = LandingService::cache_data($result);
					return $result;
				}
				else {
					$result = LandingService::get_cached_data();
				}

			} else {
				// required time wasn't passsed, just return cached data
				$result = LandingService::get_cached_data();
			}

			return $result;
		}

		/**
		 * Проверка - разрешено ли кэшировать.
		 * Зависит от того, прошло ли достаточно времени
		 * с момента предыдущего кэширования.
		 * 
		 * @return bool $allowedToCache
		 */
		public function newRequestAllowed()
		{
			if (!(file_exists(LandingService::CACHE_FILENAME))){
				return true;
			} else if (filemtime(LandingService::CACHE_FILENAME) < 
					(time() - LandingService::CACHE_MINUTES * 60)){
				return true;
			}

			return false;
		}

		/**
		 * Возвращает кэшированные ранее данные.
		 * Используется при ошибке соединения с сервером
		 * и если newRequestAllowed вернул false.
		 *
		 * Если кэширование ранее не производилось, покажет ошибку на сайте.
		 * 
		 * @return array $data
		 */
		public function get_cached_data()
		{
			$result = [];

			if (file_exists(LandingService::CACHE_FILENAME)){
				$result = json_decode(file_get_contents(LandingService::CACHE_FILENAME), true);
			} else {
				$result['landing'] = [ 'title' => 'Ошибка соединения с сервером' ];
			}

			return $result;
		}

		/**
		 * Кэширует массив данных в локальный файл LandingService::CACHE_FILENAME
		 * в формате JSON. Так же кэшируются все картинки
		 * в папку LandingService::CACHE_DIRNAME.
		 * 
		 * @param  array $data - начальные данные
		 * @return array $newData - кэшированные данные с обновленными ссылками
		 */
		public function cache_data($data)
		{
			$newData = $data;
			if (!file_exists(LandingService::CACHE_DIRNAME)){
				mkdir(LandingService::CACHE_DIRNAME);
			}
			$newData = LandingService::cache_imgs($data);
			file_put_contents(LandingService::CACHE_FILENAME, json_encode($newData));

			return $newData;
		}

		/**
		 * Кэширует все картинки из $data, 
		 * несколько раз вызывая saveImgs($photos).
		 * 
		 * @param  array $data - массив данных о Лэндинге и его площадках
		 * @return array $newData - новый массив с обновленными ссылками на изобр-я
		 */
		public function cache_imgs($data)
		{
			// photos
			$newData = $data;
			$newData['landing']['photos'] = LandingService::saveImgs(
				$newData['landing']['photos']
			);
			// arendator photos
			$newData['landing']['arendator_photos'] = LandingService::saveImgs(
				$newData['landing']['arendator_photos']
			);
			// places photos
			for($i = 0; $i < count($newData['places']); $i++){
				$newData['places'][$i]['object_photos'] = LandingService::saveImgs(
					$newData['places'][$i]['object_photos']
				);
			}

			return $newData;
		}

		/**
		 * Кэширует массив картинок и возвращает новый
		 * массив, состоящий из новых ссылок на кэшированные изображения.
		 * 
		 * @param  JSON $photos
		 * @return JSON $newPhotos
		 */
		public function saveImgs($photos)
		{
			$newPhotos = json_decode($photos);
			for($i = 0; $i < count($newPhotos); $i++)
			{
				$newPhotos[$i] = LandingService::saveImg($newPhotos[$i]);
			}
			$newPhotos = json_encode($newPhotos);

			return $newPhotos;
		}

		/**
		 * Скачивает картинку из удаленного источника,
		 * берет её базовое имя и сохраняет локально 
		 * в папку LandingService::CACHE_DIRNAME. Далее
		 * возвращает новый путь к локальной картинке.
		 * 
		 * @param  string $photo - путь к удаленному изображению
		 * @return string $outPath - новый путь к локальному изображению
		 */
		public function saveImg($photo)
		{
			$file = file_get_contents($photo);
			$outPath = LandingService::CACHE_DIRNAME 
				. basename($photo);
			if (!file_exists($outPath))
				file_put_contents($outPath, $file);

			return $outPath;
		}

		// Function for stripping tags, etc from input value
		public function check_input($data)
		{
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		/**
		 * Sends email on $email with $msg message and $topic topic
		 * @param string $msg   
		 * @param string $topic 
		 * @param string $email 
		 */
		public function SendEmail($username, $password, $msg, $topic, $email)
		{
			$url= LandingService::BASE_URL . "send-email&id=" . LandingService::ID
				. '&msg=' . urlencode($msg)
				. '&topic=' . urlencode($topic)
				. '&email=' . urlencode($email);

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

			// Execute command
			$exec_result=curl_exec($ch);
			$result = json_decode($exec_result, true);
			// Closing connection
			curl_close($ch);

			return $result;
		}

		/**
		 * Adds ' ' between thousands and lesser part of the number
		 * @param integer $price  
		 */
		public function proccessPrice($price)
		{
			$fixedPrice = "";
			$strPrice = "" . $price;
			if ($price < 1000){
				return $price;
			}
			$fixedPrice .= substr($strPrice, 0, strlen($strPrice) - 3);
			$fixedPrice .= ' ' . substr($strPrice, strlen($strPrice) - 3);

			return $fixedPrice;
		}

		/**
		 * Strips ".0" at the end of the string if exists
		 * @param float $number
		 */
		public function stripZero($number)
		{
			$answNumber = "";
			$strNumber = "" . $number;
			if (substr($strNumber, strlen($strNumber) - 2) !== '.0')
				return $number;
			$answNumber .= substr($strNumber, 0, strlen($strNumber) - 2);

			return $answNumber;
		}
	}
 ?>