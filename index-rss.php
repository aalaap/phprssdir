<?

/*
	PHP RSS Dir
	Aalaap Ghag
	http://www.aalaap.com
	aalaap@gmail.com
	2007

	This script, when run from a directory containing files, will provide an
	RSS 2.0 feed that contains the list and modification times for all the
	files.

	If you have a folder on your server with files that you want to share, you
	can use this script to provide an RSS feed to your users instead of a plain
	simple directory listing. Being an RSS feed with modification times, it
	also allows users to be notified of new items as and when you put them.

	The script is based on a simple directory listing script I found on the
	web. It had no owner info, so I don't know who to credit.

	This is just the first release of the script. I will be adding new features to it.

	This script is provided under the MIT license.

*/

$feedName = "Index of /movies";
$feedDesc = "This is a list of all the movies available for download in this folder.";
$feedURL = "http://localhost/movies";
$feedBaseURL = "http://localhost/movies/"; // must end in trailing forward slash (/).

$allowed_ext = ".MPG,.AVI,.RMVB,.MOV";


if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla' ) {
	$header = 'Content-Type: text/xml;'
} else {
	$header = 'Content-Type: application/rss+xml;'
}

header($header . ' charset=UTF-8;')

?><<?= '?'; ?>xml version="1.0"<?= '?'; ?> encoding="utf-8">
<rss version="2.0">
	<channel>
		<title><?=$feedName?></title>
		<link><?=$feedURL?></link>
		<description><?=$feedDesc?></description>
<?
$files = array();
$dir=opendir("./");

while(($file = readdir($dir)) !== false)  
{  
	$path_info = pathinfo($file);
	$ext = strtoupper($path_info['extension']);

	if($file !== '.' && $file !== '..' && !is_dir($file) && strpos($allowed_ext, $ext)>0)  
	{  
		$files[]['name'] = $file;  
		$files[]['timestamp'] = filemtime($file);  
	}  
}  
closedir($dir);
// natcasesort($files); - we will use dates and times to sort the list.

for($i=0; $i<count($files); $i++) {
	if($files[$i] != "index.php") {
		// echo "<li><a href=\"".$files[$i]."\">"  . substr($files[$i], 0, strrpos($files[$i], ".")) . "</a></li>\n";
		echo "	<item>\n";
		echo "		<title>". $files[$i]['name'] ."</title>\n";
		echo "		<link>". $feedBaseURL . $files[$i]['name'] . "</link>\n";
		echo "		<pubDate>". date("D M j G:i:s T Y", $files[$i]['timestamp']) ."</pubDate>\n";
		echo '		<guid isPermalink="true">'. $feedBaseURL . $files[$i]['name'] . '</guid>\n';
		echo "    </item>\n";
	}
}
?>
	</channel>
</rss>
