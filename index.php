<?php

// vairables
$fuelTypes =[
	1 => "Diesal",
	2 => "Petrol",
	3 => "Electric",
	4 => "Petrol_electric",
	5 => "Petrol_lpg",
	6 => "Diesal_electric",
	7 => "Lpg"
];

$transmissions = [ 
	1 => "Automatic",
	2 => "Manual",
	3 => "Semi"
];

$bodyStyles = [
	1 => "Hatchback",
	2 => "Saloon",
	3 => "Super",
	4 => "Mpv",
	5 => "Suv",
	6 => "Convertible",
	7 => "Coupe",
	8 => "Estate",
	9 => "Van" 
]; 

$bodyStylesImages =[
	1 => "assets/img/find-a-whip/hatchback.png",
	5 => "assets/img/find-a-whip/suv.png",
	3 => "assets/img/find-a-whip/super.png",
	9 => "assets/img/find-a-whip/van.png",
];

// geting body style images dinamically
function body_style_img($type){
	global $bodyStylesImages;

	foreach($bodyStylesImages as $i => $v){		
		switch ($type){
			case 1:
				return $v;
				break;
			
			case 3:
				return $v;
				break;
			
			case 9:
				return $v;
				break;
			
			default:
				return "assets/img/find-a-whip/hatchback.png";		
		}		
	}		
}

//gets an int from from the API and returns a value
function convertIntAndText($data, $value){	

		foreach($data as $i => $v){
			if( $i == $value){
				return $v;
			}else{
				// does not exist
				// could should a message
			}
		}
}

function getDetails($type, $value){
	//setting variables on scope
	global $bodyStyles;
	global $fuelTypes;
	global $transmissions;

	switch ($type){
		case "body_style":			
			return convertIntAndText($bodyStyles, $value);
			break;

		case "fuel_type":
			return convertIntAndText($fuelTypes, $value);
			break;

		case "transmission":
			return convertIntAndText($transmissions, $value);
			break;
	}
}

// connect to the API
function url_get_contents ($Url) {
	if (!function_exists('curl_init')){ 
		die('CURL is not installed!');
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);

	return $output;
}


$cars = json_decode( url_get_contents("https://us-central1-whipgo-backend-core.cloudfunctions.net/list-vehicles"));

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Whipgo</title>
	<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
	<div class="container">
	<div class="row">
	<?php foreach( $cars as $i => $car)  :?>
		<div class="car">

			<figure>
				<img src="<?=$car->image_url ?>" class="car__img" alt="<?=$car->make_model ?>"/>
				<figcaption class="car__name">
					<?=$car->make_model?><div class="car__price"><span class="car__price__value">£<?=$car->price_per_day?></span><span class="car__price__day">/DAY</span></div>
				</figcaption>
			</figure>

			<ul class="car__details">
				<li>
					<figure>
						<img src="<?=body_style_img($car->body_style)?>" class="car__bodyIcon" alt="<?=getDetails("body_style", $car->body_style)?>">
						<figcaption><?=getDetails( "body_style", $car->body_style)?></figcaption>
					<figure>
				</li>

				<li>
					<figure>
						<img src="assets/img/find-a-whip/fuel-type.png" class="car__fuelIcon" alt="<?=getDetails("fuel_type",$car->fuel_type)?>">
						<figcaption><?=getDetails("fuel_type", $car->fuel_type)?></figcaption>
					<figure>
				</li>

				<li>
					<figure>
						<img src="assets/img/find-a-whip/transmission.png" class="car__transmissionIcon" alt="<?=getDetails("transmission",$car->transmission)?>">
						<figcaption><?=getDetails( "transmission", $car->transmission)?></figcaption>
					<figure>
				</li>

				<li>
					<figure>
						<img src="assets/img/find-a-whip/seats.png" class="car__seatIcon" alt="seats">
						<figcaption>s</figcaption>
					<figure>
				</li>

				<li>
					<figure>
						<img src="assets/img/find-a-whip/doors.png" class="car__doorsIcon" alt="doors">
						<figcaption>s</figcaption>
					<figure>
				</li>
			</ul>
		</div>
	<?php endforeach;?>
	</div>
	</div>

</body>
</html>