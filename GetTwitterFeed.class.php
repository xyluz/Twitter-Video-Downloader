<?php
class GetTwitterFeed {
	public $feedUrl;
	public $urlApi;
	public $consumer_key;
	public $consumer_key_secret;
	private $bearerArray;
	private $access_token;
	private $ch;
	private $responseToPost;
	private $responseToGet;
	public $logs;

	function __construct($url, $key, $secret) {
       $this->feedUrl = urldecode($url);
       $this->logs = array();
       $this->urlApi = "https://api.twitter.com/oauth2/token";
       $this->consumer_key = $key;
       $this->consumer_key_secret = $secret;
       $this->doPostRequest();
       $this->doGetRequest();
   }

   public function getJsonFeed() {
   		return $this->responseToGet;
   }
   private function doGetRequest() {
   		$this->access_token = $this->bearerArray["access_token"];
   		$this->initGETCurl();
   		$this->responseToGet = curl_exec($this->ch);
   		curl_close($this->ch);
   }
   private function initGETCurl() {
   		$this->ch = curl_init();
   		curl_setopt($this->ch, CURLOPT_URL, $this->feedUrl);
		  curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->setGetHeaders());
		  curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
		  curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
   }
   private function setGetHeaders() {
   		return array( 
		    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
			  "Authorization: Bearer " . $this->access_token,
		    "Cache-Control: no-cache", 
		    "Pragma: no-cache"
		);
   }
   private function doPostRequest() {
   		$this->initPOSTCurl();
   		$this->responseToPost = curl_exec($this->ch);
  		curl_close($this->ch);
  		$this->logLine($this->responseToPost);
  		$this->bearerArray = $this->gunzipResponse($this->responseToPost);
   }
   private function encodePostKey() {
   	    return base64_encode($this->consumer_key . ":" . $this->consumer_key_secret);
   }
   private function setPostHeaders() {
   		return array( 
		    "Content-Type: application/x-www-form-urlencoded; charset=UTF-8",
			  "Authorization: Basic " . $this->encodePostKey(),
		    "Cache-Control: no-cache", 
		    "Pragma: no-cache",
		    "Accept-Encoding: gzip",
		    "Content-length: " . $this->getPostDataLength()
		);
   }
   private function setPostData() {
   		return http_build_query(array("grant_type" => "client_credentials"));
   }
   private function getPostDataLength() {
   		return strlen($this->setPostData());
   }
   private function initPOSTCurl() {
   		$this->ch = curl_init();
   		curl_setopt($this->ch, CURLOPT_URL, $this->urlApi);
  		curl_setopt($this->ch, CURLOPT_POST, 1);
  		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->setPostData());
  		curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->setPostHeaders());
  		curl_setopt($this->ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
  		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
   }
   private function gunzipResponse($response) {
   		return json_decode(gzdecode($response), true);
   }

   private function logLine($str) {
   		array_push($this->logs, date('c') .": " .$str);
   }
   public function printLog() {
   		echo print_r($this->logs, true);
   }
}

?>