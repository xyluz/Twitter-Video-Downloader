<?php
include_once('GetTwitterFeed.class.php');

$retrieveUrl = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=xyluz";
$consumer_key = "12u86gn9yvvkcYFRm3lsWcYz7";
$consumer_key_secret = "iKjf5T621LAkVk65NX3Jt9TTlJifSnnccpdEZd9HolscYXvEBF";

$objTwitter = new GetTwitterFeed($retrieveUrl, $consumer_key, $consumer_key_secret);

$raw_feed = json_decode($objTwitter->getJsonFeed(),TRUE);

$count_feed = count($raw_feed);


?>

<!html>
<head>
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<title>Twitter Video Downloader</title>
</head>
<body>
<?php
for($counter = 0; $counter <= $count_feed; $counter++){

$strip_feed = $raw_feed[$counter]['extended_entities']['media'][0]['video_info']['variants'];

//loop
//print_r($strip_feed);


foreach($strip_feed as $strip){

echo "<video width='320' height='240' controls>
  <source src='" . $strip['url'] . "' type='" . $strip['content_type'] . "'>
 
Your browser does not support the video tag.
</video> <br>";

echo "<a href='" . $strip['url'] ."'>" . $strip['content_type']."</a>";

}

}

?>
</body>
</html>

