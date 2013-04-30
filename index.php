<html>
<head>
<title>Getting Colors based on Location</title>
<link href="bootstrap.min.css" rel="stylesheet">
<link href="bootstrap-responsive.min.css" rel="stylesheet">
<link href="font-awesome.min.css" rel="stylesheet">
<link href="bootswatch.css" rel="stylesheet">
<?php 
  require_once("phpFlickr.php");
  require_once("ColorPalette.php");
  $key = "80f974ba0c1454bdd141c1f69b6ead6a";
  $secret = "759dea0d7fc411e9";
  $f = new phpFlickr($key, $secret);
?>
</head>
<body style="background-color:rgb(6,73,117);">

	 <div class="navbar navbar-fixed-top">
   <div class="navbar-inner">
     <div class="container">
       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
       </a>
       <a class="brand" href="../">GeoHue</a>
       <div class="nav-collapse collapse" id="main-menu">
       
        <ul class="nav pull-right" id="main-menu-right">
          <li><a rel="tooltip" target="" href="index.php" onclick="_gaq.push(['_trackEvent', 'click', 'outbound', 'builtwithbootstrap']);">Locations <i class="icon-share-alt"></i></a></li>
          <li><a rel="tooltip" target="" href="picker.html" onclick="_gaq.push(['_trackEvent', 'click', 'outbound', 'wrapbootstrap']);">Pick a Location <i class="icon-share-alt"></i></a></li>
        </ul>
       </div>
     </div>
   </div>
 </div>

    <div class="container">

<div class="hero-unit" style="margin-top:50px">
  <h1 style="font-size:124px;color:rgb(6,73,117);">GeoHue</h1>
  <h3>Use our color tagging tool to select the world's colors</h3>
  <form name="parameterInput" class="form-inline" action="index.php" method="POST">
    <label>Enter a location: </label>
    <input type="text" name="locationInput">
    <label>Type a search term: </label>
    <input type="text" name="searchInput">
    <input class="btn btn-primary" height="50px" type="submit" value="Submit">

  </form>
</div>

<?php
  if(isset($_POST['locationInput'])&&isset($_POST['searchInput'])){
    $placeInput = $_POST['locationInput'];
    $termInput = $_POST['searchInput'];
  }
  elseif(isset($_POST['searchInput'])){
    $termInput = $_POST['searchInput'];
    $placeInput = "Manhattan";
  }
  else{
    $placeInput = $_POST['locationInput'];
    $termInput = "residence";
  }

  $location = $f->places_find($placeInput);
  $locLat = $location['places']['place'][0]['latitude'];
  $locLong = $location['places']['place'][0]['longitude'];

  if(!isset($locLong)){
    $locLong=-74.003;
    $locLat=40.792;
  }

  $places_location = $f->places_findByLatLon($locLat, $locLong);

  $photos_Location = $f->photos_search(array( "lat"=>$locLat, "lon"=>$locLong, "radius"=>20, "per_page"=>20, "text"=>$termInput));
?>
  <div class="row-fluid">
            <ul class="thumbnails">
              <?php
              $counter = 0; 
              foreach((array)$photos_Location['photo'] as $photo){

                $thePhoto=$f->buildPhotoURL($photo);

                echo "<li class=\"span3\" style=\"background-color:rgb(221, 221, 221)\">";
                echo "<a href=\"picker.html?$lat=".$locLat."&$long=".$locLong."\" class=\"thumbnail\">";
                echo "<img data-src=\"".$f->buildPhotoURL($photo)."\" alt=\"260x180\" style=\"width: 260px; height: 180px;\" src=\"".$f->buildPhotoURL($photo)."\">";
                echo "</a>";
                
                $remotePalette = ColorPalette::GenerateFromUrl($thePhoto);
                echo "<div style=\"background-color:rgb(46,46,46)\"><center>";
                printPalette($remotePalette);
                echo "</center></div>";
                ?>
                <!---
                <center><div style="background-color:rgb(46,46,46);margin-bottom:10px;padding-bottom:10px; width:240px; horizontal-align:middle">
                <span class="label" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px; background-color:rgb(70,130,180)!important;">Color</span>
                <span class="label label-success" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
                <span class="label label-warning" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
                <span class="label label-important" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
                <span class="label label-info" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
                <span class="label label-inverse" style="font-size:0px!important;width:25px;height:25px;min-width:25px;min-height:25px;background-color: <?php printf("#%06X\n", mt_rand(0,0x595959));?>!important;">Color</span>
                </div>
                 </center>
-->
                <?php
                echo "<div class=\"caption\" style=\"ali\">";
                echo "<h3 style=\"margin-left:10px;\">".$placeInput."<a href=\"picker.html?locLat=".$locLat."&locLong=".$locLong."\" style=\"float:right;margin-right:10px;margin-top:5px\" class=\"btn btn-primary\">View</a></h3>	 </p>
                    </div>
                  </li>";
                $counter++;
                if(($counter%4)==0){
                  echo "</ul> </div>";
                  echo "<div class=\"row-fluid\"><ul class=\"thumbnails\">";

                }
                }
                function printPalette($palette){
                  foreach(array_slice(array_keys($palette),0,5) as $color){
                ?>  

                <div style="background-color:<?php print $color?>;display:inline-block;width:50px;height:50px;"></div>

                <?php
                  }
                }
                ?>

                ?>

            </ul>
          </div>

</body>
</html>