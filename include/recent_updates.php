<?php include_once("include/file_parse.php");?>
<?php
class updates {
	/*private*/ var $FILENAME;
	/*private*/ var $parser;
	/*private*/ var $file_contents;
	
	function updates() {
		$this->FILENAME = './resources/recent_news.csv';
		$this->parser = new fileParse("Date",  "Description", "Image");
		$this->file_contents = $this->parser->parse_items($this->FILENAME);
	}
	function get_by_day($day) {
		return $this->parser->get_by_field_value($this->file_contents, "Date", $day);
	}

	function get_most_recent() {
		$items = $this->parser->array_sort($this->file_contents, "Date", SORT_ASC);
		return $items[0];
		
	}
	
	function display_most_recent() {
		$item = $this->get_most_recent();

		$display_text =  '<p style="text-align:center;"> <img src="'. $item['Image'] .'" height="300" alt="recent updates" /> </p>  <p>'. $item['Description'].'</p> ';
		echo $display_text;
	}
	
}
?>