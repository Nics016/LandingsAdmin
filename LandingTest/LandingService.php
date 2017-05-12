<?php 
	namespace landing;
	
	use landing\LandingService;

	class LandingService
	{
		/**
		 * Requests through curl data from server and returns it as array
		 * 
		 * @param  integer $id       id of the landing
		 * @param  string $username 
		 * @param  string $password 
		 * @return array $data
		 */
		
		const BASE_URL = "http://landings.devcloud.pro/?r=data/";
		const ID = 1;

		public function getData($username, $password){
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
			$exec_result=curl_exec($ch);
			$result = json_decode($exec_result, true);
			// Closing connection
			curl_close($ch);

			return $result;
		}

		// Function for stripping tags, etc from input value
		public function check_input($data){
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
		public function SendEmail($username, $password, $msg, $topic, $email){
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
		public function proccessPrice($price){
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
		public function stripZero($number){
			$answNumber = "";
			$strNumber = "" . $number;
			if (substr($strNumber, strlen($strNumber) - 2) !== '.0')
				return $number;
			$answNumber .= substr($strNumber, 0, strlen($strNumber) - 2);

			return $answNumber;
		}
	}
 ?>