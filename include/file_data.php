<?php include_once("include/file_parse.php");?>
<?php
class file_data {
	/*private*/ var $FILENAME;
	/*private*/ var $parser;
	/*private*/ var $file_contents;

	/**
	 * fileName = relative path to .csv file
	 * columnHeaders = array of column headers
	 */
	function file_data($fileName, $columnHeaders) {
		$this->FILENAME = $fileName;
		$this->parser = new fileParse($columnHeaders);
		$this->file_contents = $this->parser->parse_items($this->FILENAME);
	}

	/*
	 * Get csv rows which match a specific var on a specific column.  
	 * ie, $column = "Data", $var="2015/3/14" will return all file rows with the date 3/14/2015
	 */
	function get_by($filterColumn, $match) {
		return $this->parser->get_by_field_value($this->file_contents, $filterColumn, $match);
	}

	function get_sorted_by($sortColumn, $filterColumn,$match) {
		$filteredItems = $this->get_by($filterColumn, $match);
		$items = $this->parser->array_sort($filteredItems, $sortColumn); 
		return $items;
	}

	function get_most_recent() {
		$items = $this->parser->array_sort($this->file_contents, "Date", SORT_ASC);
		return $items[0];
		
	}

	function display_row($item) {
		$row_style = '';
		$row = '<tr '.$row_style.'>';
		foreach($item as $key=>$value) {
			$row .= '<td class="'.$key.'">'.$value .'</td>';	
		} 
		
		$row .= '</tr>';
	}

	function display_table($filterColumn,$match, $sortColumn, $templateFile) {
		if ($filterColumn && $sortColumn) {
			$items = $this->get_sorted_by($sortColumn, $filterColumn,$match);
		} else if ($filterColumn) {
			$items = $this->get_by($filterColumn,$match);
		} else {
			$items = $this->file_contents;
		}
		$table = '<table class="noCmsTable">';
		$count = count($items);
		for ($i=0; $i<$count; $i++) {
			$item = $items[$i];
				# display description, date()
			if ($templateFile) {
				$table .= load_into_template($item,$templateFile);
			} else {
				$table .= $this->get_display_row($item);
			}
		}
		$table .= '</table>';
		echo $table;
	}
	function load_into_template($item, $templateFile) {
		ob_start();
		include $templateFile;
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}
	/**
	 * display a unique record.
	 * requires a column containing a unique identifier with the csv file.
	 */
	function display_record($filterColumn, $match, $templateFile) {
		$items = $this->get_by($filterColumn, $match);
		$item = $items[0];
		if ($templateFile) {
			$html = load_into_template($item,$templateFile);
		} else {

			$html = '<div class="noCmsRecord">';
			foreach($item as $key=>$value) {
				$html .= '<p class="'.$key.'">'.$value .'</p>';
			}
			$html .= '</div>';
		}
		echo $html;	
	}

	function display_most_recent() {
		$item = $this->get_most_recent();

		$display_text =  '<p style="text-align:center;"> <img src="'. $item['Image'] .'" height="300" alt="recent updates" /> </p>  <p>'. $item['Description'].'</p> ';
		echo $display_text;
	}
	
}
?>
