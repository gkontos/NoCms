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
include_once('include/images.php');
include_once('include/file_data.php');
$sales = new file_data('./resources/sales_info.csv',array("SaleId","SortDate", "DateTeaser","SaleType","LocationTeaser","SaleTitle","SaleTimes","Address","Directions","Listing"),true);
$id = $_GET["id"];
$dir = $_GET['dir'];
$items = $sales->get_by('SaleId',$id);
$item = $items[0];
if (!isset($dir)) {
	$dir = "images/" . $id;
}
$images = new image_display($dir);
?>

<html>
<head>
<title>TITLE | <?=$item['SaleType'];?></title>
</head>
<body bgcolor="#000000" dir="LTR">

	<span><?php echo $item['SaleType'];?> - Photos </span>
	<p><?php echo $item['SaleTimes'];?></p>
        <p><strong>Location:</strong><?php echo $item['Address'];?></p>
	<?=$images->display();?>    
       
</body>
</html>
