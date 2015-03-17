<?php 

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
			displaySingle = true;
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
		if ($this->displaySingle()) {
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
		foreach($files as $file) {
			if($colCtr % $this->columns == 0) {
				echo '</tr><tr>';
			}
			echo '<td>';
			if (is_dir($directory . '/'. $file)) {
				echo '<a class="photo_folder" href="?dir='. $directory . '/'. $file . '"><img src="images/folder.png"/><br/>'. $file . '</a>';
			} else {
				echo '<a href="?dir=' . $directory .'/'. $file . '"><img width="'.$this->maxImageWidth.'px" src="' . $directory .'/'. $file . '" /></a>';
			}
			echo '</td>';
			$colCtr++;
		}
		echo '</tr></table>';
	}
}
