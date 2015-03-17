<?php
//Methods for reading a file and returning an array of objects
class fileParse {
	protected $fields = array();
	public function __construct( /*...*/) {
		$args = func_get_args();
		for( $i=0, $n=count($args); $i<$n; $i++ ) {
			$this->fields[$i] = $args[$i];
		}
    }
    
# read a file and return an array of items
function parse_items($file_name) {
	if(function_exists('date_default_timezone_set')) {
   		date_default_timezone_set('America/New_York');
	} else {
   	#	putenv("TZ=America/New_York");
	} 
	$items = array();
	$file_handle = fopen($file_name, "r");
	if ($file_handle) {
		
		while (!feof($file_handle) ) {
			$item = fgetcsv($file_handle, 1024);
			if ($item[0] != '') {
				$temp_item = array();
				for ($i=0; $i<count($item); $i++) {
					$temp_item[$this->fields[$i]] = trim($item[$i]);
				}
				$items[] = $temp_item;
			}
		}
		fclose($file_handle);
	}
	return $items;
}


# return all items of array where the field denoted by field name matches the string value of $match 
function get_by_field_value($items, $field_name, $match) {
	$count = count($items);
	$item_types = array();
	$array_index = $this->find_key($field_name);
	if (!is_null($array_index)) {  
		for ($i = 0; $i < $count; $i++) {
			
			$item = $items[$i];
			
			if ($item[$field_name] == $match) {
				$item_types[] = $item;
			}
		}
	}
	return $item_types;
}

#phpdotnet at m4tt dot co dot uk (from php.net)
function array_sort($array, $on, $order='SORT_ASC') {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case 'SORT_ASC':
                asort($sortable_array);
            break;
            case 'SORT_DESC':
                arsort($sortable_array,SORT_NUMERIC);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
}
	
	function find_key($field_name) {
		$key = null;
		foreach ( array_keys ( $this->fields ) as $k => $v ) {
			if ($v == $field_name) {
				$key = $k;
			}
		}
		return $key;	
	}
}
?>