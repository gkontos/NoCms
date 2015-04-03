Copyright 2015
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


*** NoCms  ****

NoCms is a set of utility classes written in php which make it easy to add dynamic 
content to small community or personal websites.  Content is added to the site using 
a spreadsheet saved in .csv format.  All you or your client needs to do is update the 
spreadsheet and upload it to the site.  This functionality works great for situations 
where a full blown CMS is overkill and adds a lot of extra features.  Those extra features 
add training time or need to be locked down.  If you find yourself on a server where jdbc 
has been blocked or where you cannot install a database, this tool will help.

Using NoCms content can be displayed as lists, sorted lists, or individual page views.  
NoCms also contains an image tool which will display all images within a directory -- and 
allow navigation around image directories.  This is another commonly requested feature 
for community and personal sites.  Be careful, however, there is not much security around 
the image display -- if you have private information that you want to keep, make sure that you
modify the code so that only your image directories are accessible.

If you find this useful, consider sending me a nice email to gregkontos#gmail
or, send some money to my paypal account at the same address.


** Install & Usage **
- Add the include directory to your site
- Add a directory called 'resources' to your site, place .csv files within this directory.
- Pulling content from a file takes two or lines of code : 
For example : 

$sales = new file_data('./resources/sales_info.csv',array("SaleId","SortDate", "DateTeaser","SaleType","LocationTeaser","SaleTitle","SaleTimes","Address","Directions","Listing"),true);

The new file_data constructor takes three arguements and returns an array of all the content.
The first argument to the function is the relative location of the .csv file.  
The second arguement is an array of all the data columns in the file.  
The third arguement indicates that headers are present in the file.  

Once you have all the content, you can find a specific record or display several of the records.

If you have a specific id from a $_GET request you can pull up that one record with :
$items = $sales->get_by('SaleId',$id);

If you would like to display all or some of the records something like the following will work:
$sales->display_all_records('SortDate','','','include/teaser_view.php'); 

There are several functions for sorting or filtering records to include partial content.  
Also, the last variable in the above line contains a template file.  This is nothing fancy, just regular php,
but it will allow you to format the display without changing the functions in include/file_data.php


** Examples **
In the examples folder, there are some specific examples of how NoCms can be used to quickly and easily generate
dynamic content on your site.




