<?php

/*
 * This file is part of NoCms
 *
 * NoCms is free software: you can redistribute it and/or modify
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
include_once ("include/file_data.php");
$teasers = new file_data('./resources/sales_info.csv',array("SaleId","SortDate", "DateTeaser","SaleType","LocationTeaser","SaleTitle","SaleTimes","Address","Directions","Listing"),true);
 
?>

<html>
<head>
<title>Title | Calendar</title>
<meta http-equiv="Content-Type" content="text/html;">
</head>
<body bgcolor="#000000">
	    <?php 
 		$teasers->display_all_records('SortDate','','','include/teaser_view.php'); 
    	    ?>

</body>
</html>
