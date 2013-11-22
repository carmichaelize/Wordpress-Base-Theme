<?php

  	//http://bugs.openweathermap.org/projects/api/wiki/Weather_Condition_Codes
  	//55.8937106  //-3.070292399999

	$weather = get_transient( 'sc_weather_forecast' );

	if(!$weather){

		$location = 'cupar,uk';
		$limit = 2;

	    $weather = (object)wp_remote_get("http://api.openweathermap.org/data/2.5/forecast/daily?q={$location}&units=metric&mode=json&cnt={$limit}");
		$weather = json_decode($weather->body);

		//Cache Response
		if($weather && is_array($weather->list)){
			set_transient( 'sc_weather_forecast', $weather, 60*60 );
		}

	}

  ?>

  <?php if(is_array($weather->list)) : ?>

	  <?php foreach($weather->list as $day) : ?>

		  <span class="weather-day"><?php echo date('l', $day->dt); ?></span>

		  <br />

		  <img class="waether-icon" src="<?php echo TEMPLATE_PATH; ?>/images/weather_icons/<?php echo $day->weather[0]->icon; ?>.png" />

		  <br />

		  <span class="waether-temperature"><?php echo round( ($day->temp->max + $day->temp->min) / 2 ); ?>&deg;</span>

		  <br />
		  <br />

	  <?php endforeach; ?>

  <?php endif; ?>