<?php include_once("include/file_parse.php");?>
<?php
class agenda {
	/*private*/ var $FILENAME;
	/*private*/ var $parser;
	/*private*/ var $file_contents;
	
	function agenda() {
		$this->FILENAME = './resources/agenda.csv';
		$this->parser = new fileParse("Date", "Time", "Description");
		$this->file_contents = $this->parser->parse_items($this->FILENAME);
	}
	function get_by_day($day) {
		return $this->parser->get_by_field_value($this->file_contents, "Date", $day);
	}

	function get_sorted_by_day($day) {
		$day_agenda = $this->get_by_day($day);
		return $this->parser->array_sort($day_agenda, "Time");
	}
	
	function get_display_row($item) {
		return '<tr><td class="time">'.$item['Time'] .'</td><td> '. $item['Description'].'</td></tr>';
	}
	
	function display_day($day) {
		echo '<table class="agenda">';
		$items = $this->get_sorted_by_day($day);
		$count = count($items);
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
				# display description, date()
				
			echo $this->get_display_row($item);
		}
		echo '</table>';
	}
}
?>