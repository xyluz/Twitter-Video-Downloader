<?php
include_once('GetTwitterFeed.class.php');

$retrieveUrl = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=xyluz";
$consumer_key = "customer secret";
$consumer_key_secret = "customer_key_secret";

$objTwitter = new GetTwitterFeed($retrieveUrl, $consumer_key, $consumer_key_secret);

$raw_feed = json_decode($objTwitter->getJsonFeed(),TRUE);

$count_feed = count($raw_feed);


?>

<!html>
<head>
<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">

<title>Twitter Video Downloader</title>
</head>
<body>
<div class="container">
<div class="col-xs-12 col-sm-9">
<div class="row">
<?php
for($counter = 0; $counter <= $count_feed; $counter++){

$strip_feed = $raw_feed[$counter]['extended_entities']['media'][0]['video_info']['variants'];

// print_r($strip_feed);

foreach($strip_feed as $strip){


if($strip['content_type'] != "application/x-mpegURL"){

echo "<div class='col-xs-6 col-lg-4'><h2>" . $strip['content_type']. "</h2>
<p>Bitrate : ". $strip['bitrate'] ."</p>
 <p><video width='100%' controls>
  <source src='" . $strip['url'] . "' type='" . $strip['content_type'] . "'>
 
Your browser does not support the video tag.
</video> </p>";

echo " <p><a class='btn btn-default' href='" . $strip['url'] ."' role='button'>Download</a></p></div>";

}
}
}

?>
</div>
</div>
</div>

</body>
</html>

