<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="js/libs/modernizr-2.0.6.min.js"></script>
<script src="js/libs/mustache.js"></script>
<script src="js/libs/quantize.js"></script>
<script src="js/color-thief.js"></script>
<?php
require_once("phpFlickr.php");
require_once("ColorPalette.php");

$key = "80f974ba0c1454bdd141c1f69b6ead6a";
$secret = "759dea0d7fc411e9";
$f = new phpFlickr($key, $secret);

$f->enableCache("fs", "./flickrCache");

$boundCoords = $_GET['swLong'].", ".$_GET['swLat'].", ".$_GET['neLong'].", ".$_GET['neLat'];
//$boundCoords = "146.61476416015626, -35.57608366029834, 155.44777197265626, -32.17009604974696";

$photos_Location = $f->photos_search(array("bbox"=>"$boundCoords", "text"=>"residence", "per_page"=>20));

echo "<div class=\"row-fluid\"> <ul class=\"thumbnails\">";

$counter = 0; 
$otherOffset = 20;
foreach((array)$photos_Location['photo'] as $photo){

	$thePhoto = $f->buildPhotoURL($photo);
	echo "<li class=\"span3\" style=\"background-color:rgb(221, 221, 221)\">";
	echo "<a href=\"#\" class=\"thumbnail\">";
	echo "<img id=\"colorPhoto\" data-src=\"".$thePhoto."\" alt=\"260x180\" style=\"width: 260px; height: 180px;\" src=\"".$thePhoto."\">";
	echo "</a>";
	echo "<div class=\"caption\" style=\"ali\">";
	$remotePalette = ColorPalette::GenerateFromUrl($thePhoto);
	echo "<div style=\"background-color:rgb(46,46,46)\"><center>";
	printPalette($remotePalette);
	echo "</center></div>";
	//$newImage = "assets/image".$photo['id'].".jpg";
	//file_put_contents($newImage, file_get_contents($thePhoto));

?>
<!----
<canvas id="my_canvas_id"></canvas>
<script type="text/javascript">
	var myCanvas = document.getElementById('my_canvas_id');
	var ctx = myCanvas.getContext('2d');
	var img = new Image;
	img.onload = function(){
	  ctx.drawImage(img,0,0);
	  dominantColor = getDominantColor(img);
		paletteArray = createPalette(img, 5);  // Or at whatever offset you like
	};
</script>

<center><div style="background-color:rgb(46,46,46);margin-bottom:10px;padding-bottom:10px; width:300px; horizontal-align:middle">
      <span class="label" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px; background-color:rgb(70,130,180)!important;">Color</span>
      <span class="label label-success" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
      <span class="label label-warning" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
      <span class="label label-important" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
      <span class="label label-info" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
      <span class="label label-inverse" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
  </div>
</center>
!-->
<?php
	echo "
	    </div>
	  </li>";
	$counter++;
	if(($counter%4)==0){
		if($counter<2){
			$otherOffset+=5;
		}
		else{
			$otherOffset-=10;
		}
	  echo "</ul> </div>";
	  echo "<div class=\"row-fluid\"><ul class=\"thumbnails\">";

	}
}

?>
<div class="hero-unit" style="clear:both;">
  <h1>City Color Scheme</h1>
  <p>Use our color tagging tool to select the world's colors.
<div id="colorAgg" style="margin-top:10px;background-color:rgb(255, 255, 255);padding-bottom:10px; padding-top:10px; ">
 <?php 
 	printPaletteLarge($remotePalette);
 ?>
</div>
</div>
<?

function printPalette($palette){
  foreach(array_slice(array_keys($palette),0,5) as $color){
?>  

<div style="background-color:<?php print $color?>;display:inline-block;width:50px;height:50px;"></div>

<?php
  }
}

function printPaletteLarge($palette){
  foreach(array_slice(array_keys($palette),0,5) as $color){
?>  

<div style="background-color:<?php print $color?>;display:inline-block;width:150px;height:150px;"></div>

<?php
  }
}

?>

?>
