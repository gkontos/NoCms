<?php include_once("include/file_parse.php");?>
<?php
class speakers {
	/*private*/ var $FILENAME;
	/*private*/ var $parser;
	/*private*/ var $file_contents;
	
	function speakers() {
		$this->FILENAME = './resources/speakers.csv';
		$this->parser = new fileParse("Name", "LastName", "FilePrefix", "Organizer", "Title", "Institution", "Field","Region","Country", "Attending");
		$this->file_contents = $this->parser->parse_items($this->FILENAME);
	}
	
	/*
	function add_mcleskey($items) {
		$item = array(
					"Name"=>"",
					"Title"=>"",
					"Institution"=>"",
					"Field"=>"",
					"Region"=>"",
					"Country"=>"",
					"Attending"=>"");
		return array_unshift($item, $items);
	}
	
	function add_elsobki($items) {
		$item = array(
					"Name"=>"",
					"Title"=>"",
					"Institution"=>"",
					"Field"=>"",
					"Region"=>"",
					"Country"=>"",
					"Attending"=>"");
		return array_unshift($item, $items);
	}
	*/
	/**
	 * 
	 * Add the organizer to the top of the list.  Remove organizer from list
	 * @param unknown_type $region
	 * @param unknown_type $items
	 */
	function add_organizer($region, $items) {
		$orgs = $this->parser->get_by_field_value($this->file_contents, "Organizer", "Y");
		
		$orgs = $this->parser->get_by_field_value($orgs, "Region", $region);
		
		$count = count($items);
		$filtered = $orgs;
		
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
			
			if ($item['Organizer'] != 'Y' && $item['Organizer'] != 'y') {
				$filtered[] = $item;
			}
		}

		return $filtered;
	}
	
	function get_by_country($country) {
		$items = $this->parser->get_by_field_value($this->file_contents, "Country", $country);
		return $this->filter_attending($items); 
	}

	function get_sorted_by_country($country) {
		$country_speakers = $this->get_by_country($country);
		$items = $this->parser->array_sort($country_speakers, "Name"); 
		return $items;
	}
	
	function get_sorted_by_region($region) {
		
		$items = $this->parser->get_by_field_value($this->file_contents, "Region", $region);
		$items = $this->filter_attending($items);
		$items = $this->parser->array_sort($items, "LastName");

		return $items;
	}
	
	function get_display_row($item) {
		$row = ''; 
		if (!empty($item['Name'])) {
			$prefix = $item['FilePrefix'];
			$bio_file =  $this->person_file_exists($prefix, "bio");
			$grad_file = $this->person_file_exists($prefix, "grad");
			$abstract_file = $this->person_file_exists($prefix, "abstract");
			$has_docs = strlen($bio_file)+ strlen($grad_file) + strlen($abstract_file);
			$row_style = '';
			if ($has_docs == 0) {
				$row_style = 'class="row_space"';
			}
			$row = '<tr '.$row_style.'><td class="name">'.$item['Name'] .'</td><td> '. $item['Title'].'; '.$item['Institution'] .'<br/> '.$item['Field'].'</td><td> '. $item['Country'].'</td></tr>';
						
			if ($has_docs > 0) {
				$row_style = 'class="row_space"';
				$row = $row . '<tr '.$row_style.'><td colspan="3">';
				
				$count = 0;
				if (strlen($abstract_file) > 0) {
					if ($count > 0) {
						$row = $row .'&nbsp;&bull;&nbsp;';
					}
					$row = $row .'<a href="'.$this->get_person_file_name($prefix,"abstract").'.'.$abstract_file.'">Abstract</a>';
					$count ++;
				}
				if (strlen($bio_file) > 0) {
					if ($count > 0) {
						$row = $row .'&nbsp;&bull;&nbsp;';
					}
					$row = $row .'<a href="'.$this->get_person_file_name($prefix,"bio").'.'.$bio_file.'">Research Bio</a>';
					$count ++;
				}
				if (strlen($grad_file) > 0) {
					if ($count > 0) {
						$row = $row .'&nbsp;&bull;&nbsp;';
					}
					$row = $row .'<a href="'.$this->get_person_file_name($prefix,"grad").'.'.$grad_file.'">Graduate Student Opportunities</a>';
					$count ++;
				}
				
			
				$row = $row . '</td></tr>';
			}
		} 
		return $row;
	}
	
	function display_region($region) {
		echo '<table class="speakers">';
		$items = $this->get_sorted_by_region($region);
		$items = $this->add_organizer($region, $items);
		
		$count = count($items);
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
				# display description, date()
				
			echo $this->get_display_row($item);
		}
		echo '</table>';
	}
	/*
	function display_country($country) {
		echo '<table class="speakers">';
		$items = $this->get_sorted_by_country($country);
		$count = count($items);
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
				# display description, date()
				
			echo $this->get_display_row($item);
		}
		echo '</table>';
	}
	*/
	function filter_attending($items) {
		$count = count($items);
		$filtered = array();
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
			
			if ($item['Attending'] == 'Y' || $item['Attending'] == 'y') {
				$filtered[] = $item;
			}
		}
		return $filtered;
	}
	
	function get_person_file_name($prefix, $file_type) {
		return './resources/'.$prefix.'_'.$file_type;
	}
	/**
	 * 
	 * Return the file extension if the specified file exists in the resources folder
	 * Return blank string if the file does not exist
	 * @param unknown_type $prefix
	 * @param unknown_type $file_type
	 */
	function person_file_exists($prefix, $file_type) {
		$extension = '';
		$file_name = $this->get_person_file_name($prefix,$file_type);
		$files = glob($file_name.'.*');
		if(count($files) > 0) {
    		$extension = substr(strrchr($files[0],'.'), 1);
		} 				
		return $extension;
	}
}
?>