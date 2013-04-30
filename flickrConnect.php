<title>CitiColor</title>
	<?php 
	require_once("phpFlickr.php");
	$key = "80f974ba0c1454bdd141c1f69b6ead6a";
	$secret = "759dea0d7fc411e9";
	$f = new phpFlickr($key, $secret);

	$location = $f->places_find("07481");
	$locLat = $location['places']['place'][0]['latitude'];
	$locLong = $location['places']['place'][0]['longitude'];

	$places_location = $f->places_findByLatLon($locLat, $locLong);

	$photos_Location = $f->photos_search(array( "lat"=>$locLat, "lon"=>$locLong, "radius"=>2, "per_page"=>20));

	
	foreach((array)$photos_Location['photo'] as $photo){
		//echo "<a href=http://www.flickr.com/photos/$photo[owner]/$photo[id]>";
	    //echo "<img border='0' alt='$photo[title]' ".
	      //  "src=" . $f->buildPhotoURL($photo, "Square") . ">";
	    //echo "</a>"; 
	}
	 
	
	
	$photos_red = $f->photos_search(array("tags"=>"Manhattan", "per_page"=>6));
	foreach ((array)$photos_red['photo'] as $photo) {
	    // Build image and link tags for each photo
	    //echo "<a href=http://www.flickr.com/photos/$photo[owner]/$photo[id]>";
	    //echo "<img border='0' alt='$photo[title]' ".
	      //  "src=" . $f->buildPhotoURL($photo, "Square") . ">";
	  //  echo "</a>";
	}
	 
	
	// Search for most interesting photos with the text "cat"
	$photos_cat = $f->photos_search(array("text"=>"Manhanttan", "per_page"=>6));
	foreach ((array)$photos_cat['photo'] as $photo) {
	    // Build image and link tags for each photo
	   // echo "<a href=http://www.flickr.com/photos/$photo[owner]/$photo[id]>";
	    //echo "<img border='0' alt='$photo[title]' ".
	    //    "src=" . $f->buildPhotoURL($photo, "Square") . ">";
	    //echo "</a>";
	}

	 
	 
 

?>

</body>
</html>