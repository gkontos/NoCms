<?php $PAGE_TITLE="VCU ASME"; include('header.php');?>

<!--<img width="550" height="60" id="_x0000_i1025" src="images/photo_header.jpg">-->
<div class="content">
<?php
function getFiles($directory) {
	if ($handle = opendir($directory)) {
	   while (false !== ($file = readdir($handle))) {
	       if ($file != "." && $file != ".." && $file != "Thumbs.db") {
        	   $files[] = $file;
	       }
	   }
	   closedir($handle);
	}
	return $files;
}

$images = (!empty($_GET["dir"])) ? $_GET["dir"] : "photos";
$cols   = 3; # Number of columns to display

$colCtr = 0;

echo '<h3>'.$images.'</h3><table width="100%" cellspacing="3"><tr>';

$files = getFiles($images);
foreach($files as $file) {
	if($colCtr %$cols == 0) {
		echo '</tr><tr><td colspan='.$cols.'><hr /></td></tr><tr>';
	}
	echo '<td align="center">';
	if (is_dir($images . '/'. $file)) {
		echo '<a class="photo_folder" href="?dir='. $images . '/'. $file . '"><img src="images/folder.png"/><br/>'. $file . '</a>';
	} else {
		echo '<a href="' . $images .'/'. $file . '"><img width="200px" src="' . $images .'/'. $file . '" /></a>';
	}
	echo '</td>';
	$colCtr++;
}

echo '</table>' . "\r\n";

?> 

</div>
<?php include("footer.php");
