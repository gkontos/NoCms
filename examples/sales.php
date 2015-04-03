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
include_once('include/file_data.php');
$sales = new file_data('./resources/sales_info.csv',array("SaleId","SortDate", "DateTeaser","SaleType","LocationTeaser","SaleTitle","SaleTimes","Address","Directions","Listing"),true);
$id = $_GET["id"];
$items = $sales->get_by('SaleId',$id);
$item = $items[0];
?>

<html>
<head>
<title>Title | <?=$item['SaleType'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>
<body bgcolor="#000000" dir="LTR">

      <table width="580" border="0" cellspacing="0" cellpadding="20">
        <tr>
		<td>
			<p><?php echo $item['SaleType'];?></p>
			<p><?php echo $item['SaleTimes'];?></p>
        		<p>Location:<?php echo $item['Address'];?></p>
		        <p>Directions: <?php echo $item['Directions'];?></p>
	  		<p><a href="photos.php?id=<?php echo $item['SaleId'];?>">CLICK HERE FOR PHOTOS</a></p>
		       <?php echo $item['Listing'];?>
	        <td>
        </tr>
      </table>
     
</body>
</html>
