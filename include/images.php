<?php

/*
 * Copyright 2015
   author : Greg Kontos (contact gregkontos - gmail)

    This file is part of NoCms
 
    NoCms is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    NoCms is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

 */
?>

<?php 

/**
 * Display and browse all images within a directory, or a specific image by file name
 */
class image_display {
	var $directory;
	var $columns = 3;
	var $files;
	var $maxImageWidth = 200;
	var $displaySingle = false;
	

	function image_display($dir, $columns = 3, $maxImageWidth=200) {
		$images = (!empty($dir)) ? $dir : "images";
		$this->directory = $images;		
		if (!is_dir($images)) {
			$this->displaySingle = true;
		} else {
			$this->columns = $columns;
			$this->maxImageWidth = $maxImageWidth;
			$this->get_files();
		}
	}

	function get_files() {
		if ($handle = opendir($this->directory)) {
		   while (false !== ($file = readdir($handle))) {
		       if ($file != "." && $file != ".." && $file != "Thumbs.db") {
        		   $files[] = $file;
		       }
		   }
		   closedir($handle);
		}
		$this->files = $files;
	}

	function display($title = '') {
		if ($this->displaySingle) {
			$this->display_single();
		} else {
			$this->display_images($title);
		}
	}

	function display_single() {
		echo '<div class="noCmsImage"><img src="' . $this->directory . '" /></div>';
	}

	function display_images($title = '') {
		$directory = $this->directory;
		$colCtr = 0;
		echo '<h3>'.$title.'</h3><table class="noCmsImageTable"><tr>';
		foreach($this->files as $file) {
			if($colCtr % $this->columns == 0) {
				echo '</tr><tr>';
			}
			echo '<td>';
			$params = array_merge($_GET, array("dir" => $directory . '/'. $file));
			$query_string = http_build_query($params);
			if (is_dir($directory . '/'. $file)) {
			
				echo '<a class="photo_folder" href="?'.$query_string.'"><img src="images/folder.png"/><br/>'. $file . '</a>';
			} else {

				echo '<a href="?'.$query_string.'"><img width="'.$this->maxImageWidth.'px" src="' . $directory .'/'. $file . '" /></a>';
			}
			echo '</td>';
			$colCtr++;
		}
		echo '</tr></table>';
	}
}
