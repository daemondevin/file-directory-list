<?php
/* 

Free PHP File Directory Listing Script - Version 1.9

The MIT License (MIT)

Copyright (c) 2015 Hal Gatewood

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.


*** OPTIONS ***/

	// TITLE OF PAGE
	$title = "Demo Script of dirListing";
	
	// ADD SPECIFIC FILES YOU WANT TO IGNORE HERE
	$ignore_file_list = array( ".htaccess", "Thumbs.db", ".DS_Store", "index.php" );
	
	// ADD SPECIFIC FILE EXTENSIONS YOU WANT TO IGNORE HERE, EXAMPLE: array('psd','jpg','jpeg')
	$ignore_ext_list = array( );
		
	// SPECIFY WEB FILE EXTENSIONS HERE, EXAMPLE: array('htm','html','xhtml')
	$web_ext_list = array('htm','html','xhtml','php','js','css');
			
	// SPECIFY ARCHIVE FILE EXTENSIONS HERE, EXAMPLE: array('zip','rar','7z')
	$zip_ext_list = array('7z','rar','zip');
				
	// SPECIFY DOCUMENT FILE EXTENSIONS HERE, EXAMPLE: array('doc','txt','rtf')
	$doc_ext_list = array('doc','rtf','txt');
					
	// SPECIFY AUDIO FILE EXTENSIONS HERE, EXAMPLE: array('mp3','m4a','wma')
	$audio_ext_list = array('mp3','m4a','wma');
						
	// SPECIFY VIDEO FILE EXTENSIONS HERE, EXAMPLE: array('avi','mp4','wmv')
	$video_ext_list = array('avi','mp4','wmv');
							
	// SPECIFY IMAGE FILE EXTENSIONS HERE, EXAMPLE: array('bmp','jpg','png','gif')
	$image_ext_list = array('bmp','jpg','png','gif','ico');
	
	// SORT BY
	$sort_by = "name_asc"; // options: name_asc, name_desc, date_asc, date_desc
	
	// ICON URL
	//$icon_url = "https://www.dropbox.com/s/bu63n8nm5ylexsi/icons.png?dl=0"; // OLD SCHOOL
	//$icon_url = "https://www.dropbox.com/s/lzxi5abx2gaj84q/flat.png?dl=0"; // DIRECT LINK
	
	// TOGGLE SUB FOLDERS, SET TO false IF YOU WANT OFF
	$toggle_sub_folders = true;
	
	// FORCE DOWNLOAD ATTRIBUTE
	$force_download = true;
	
	// IGNORE EMPTY FOLDERS
	$ignore_empty_folders = true;

	
// SET TITLE BASED ON FOLDER NAME, IF NOT SET ABOVE
if( !$title ) { $title = cleanTitle(basename(dirname(__FILE__))); }
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
	<link href="//fonts.googleapis.com/css?family=Lato:400" rel="stylesheet" type="text/css"/>
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"/>
	<style>
		*, *:before, *:after { -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
		body { font-family: "Lato", "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 400; font-size: 14px; line-height: 18px; padding: 0; margin: 0; background: #f5f5f5; text-align: center;}
		.wrap { max-width: 600px; margin: 20px auto; background: white; padding: 40px; box-shadow: 0 0 2px #ccc; text-align: left;}
		@media only screen and (max-width: 700px) { .wrap { padding: 15px; } }
		h1 { text-align: center; margin: 40px 0; font-size: 22px; font-weight: bold; color: #666; }
		a { color: #399ae5; text-decoration: none; } a:hover { color: #206ba4; text-decoration: none; }
		.note { padding:  0 5px 25px 0; font-size:80%; color: #666; line-height: 18px; }
		.block { clear: both;  min-height: 50px; border-top: solid 1px #ECE9E9; }
		.block:first-child { border: none; }
		.block .img { width: 48px; height: 58px; display: block; float: left; margin-right: 20px; }
		.block .date { margin-top: 4px; font-size: 70%; color: #666; }
		.block a { display: block; padding: 10px 15px; transition: all 0.35s; }
		.block .name:hover { text-decoration: none; background: #efefef; margin-left: 60px; border-radius: 5px; }
		
		.file-icon {
		  font-family: Arial, Tahoma, sans-serif;
		  font-weight: 300;
		  display: inline-block;
		  width: 24px;
		  height: 32px;
		  background: #a0a0a0;
		  position: relative;
		  border-radius: 2px;
		  text-align: left;
		  -webkit-font-smoothing: antialiased;
		}

		.file-icon::before {
		  display: block;
		  content: "";
		  position: absolute;
		  top: 0;
		  right: 0;
		  width: 0;
		  height: 0;
		  border-bottom-left-radius: 2px;
		  border-width: 5px;
		  border-style: solid;
		  border-color: #fff #fff rgba(255,255,255,.35) rgba(255,255,255,.35);
		}

		.file-icon::after {
		  display: block;
		  content: attr(data-type);
		  position: absolute;
		  bottom: 5px;
		  background-color: rgba(102, 102, 102, 0.75);
		  left: 0;
		  font-size: 15px;
		  text-shadow: 1px 1px 1px #000000;
		  color: #fff;
		  font-family: monospace;
		  font-variant: small-caps;
		  width: 100%;
		  padding-bottom: 3px;
		  margin-bottom: 2px;
		  padding-left: 5px;
		  white-space: nowrap;
		  overflow: hidden;
		}

		.file-icon[data-type=dir] {
			background: #ffb700;
		}

		.file-icon[data-type=zip], 
		.file-icon[data-type=rar] {
			background: #f57f17;
		}

		.file-icon[data-type=txt], 
		.file-icon[data-type=rtf], 
		.file-icon[data-type=doc] {
			background: #5eb533;
		}

		.file-icon[data-type=htm], 
		.file-icon[data-type=html], 
		.file-icon[data-type=xhtml], 
		.file-icon[data-type=dhtml], 
		.file-icon[data-type=php], 
		.file-icon[data-type=asp], 
		.file-icon[data-type=inc], 
		.file-icon[data-type=css], 
		.file-icon[data-type=js] {
			background: #01579b;
		}

		.file-icon[data-type=mp3], 
		.file-icon[data-type=wma], 
		.file-icon[data-type=m4a], 
		.file-icon[data-type=flac] {
			background: #b71c1c;
		}

		.file-icon[data-type=mp4], 
		.file-icon[data-type=wmv], 
		.file-icon[data-type=mov], 
		.file-icon[data-type=avi], 
		.file-icon[data-type=mkv] {
			background: #880e4f;
		}

		.file-icon[data-type=bmp], 
		.file-icon[data-type=jpg], 
		.file-icon[data-type=jpeg], 
		.file-icon[data-type=gif], 
		.file-icon[data-type=png] {
			background: #009688;
		}

		.file-icon[data-type=ini], 
		.file-icon[data-type=cfg],
		.file-icon[data-type=log] {
		  background: #424242;
		}
		
		.block .fa {
		  display: block;
		  position: absolute;
		  color: rgba(102, 102, 102, 0.75);
		  padding: 6px;
		  font-size: 20px;
		  text-shadow: 1px 1px rgba(0, 0, 0, 0.3), -1px 1px rgba(158, 158, 158, 0.25);
		  opacity: 0.75;
		}
		
		.fa[data-type=web] {
			color: #42a5f5;
		}

		.fa[data-type=doc] {
			color: #aed581;
		}

		.fa[data-type=audio] {
			color: #f48fb1;
		}

		.fa[data-type=video] {
			color: #e57373;
		}

		.fa[data-type=image] {
			color: #a5d6a7;
		}

		.fa[data-type=archive] {
			color: #fbc02d;
		}

		.fa[data-type=cfg] {
			color: #212121;
		}

		.fa[data-type=dir] {
			color: #c18b00;
		}
		
		.sub { margin-left: 20px; border-left: solid 1px #ECE9E9; display: none; }
		
		.footer { padding: 10px 10px 40px 10px; }
		
	</style>
</head>
<body>
<h1><?php echo $title ?></h1>
<div class="wrap">
<?php

// FUNCTIONS TO MAKE THE MAGIC HAPPEN, BEST TO LEAVE THESE ALONE
function cleanTitle($title) {
	return ucwords( str_replace( array("-", "_"), " ", $title) );
}

function getFileExt($filename) {
	return substr( strrchr( $filename,'.' ),1 );
}

function format_size($file) {
	$bytes = filesize($file);
	if ($bytes < 1024) return $bytes.'b';
	elseif ($bytes < 1048576) return round($bytes / 1024, 2).'kb';
	elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).'mb';
	elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).'gb';
	else return round($bytes / 1099511627776, 2).'tb';
}


// SHOW THE MEDIA BLOCK
function display_block($file){
	global $ignore_file_list, $ignore_ext_list, $force_download;
	
	$file_ext = is_dir($file) ? "dir" : getFileExt($file);
	if(in_array($file, $ignore_file_list)) return;
	if(in_array($file_ext, $ignore_ext_list)) return;
	
	$download_att = ($force_download AND $file_ext != "dir" ) ? " download='" . basename($file) . "'" : "";
	
	$rtn = "<div class=\"block\">";
	$rtn .= "<a href=\"$file\" class=\"$file_ext\"{$download_att}>";
	$rtn .= "	<div class=\"img file-icon\" data-type=\"$file_ext\">&nbsp;</div>";
	switch ($file_ext) {
		case "zip":
		case "7z":
		case "rar":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"archive\">&#xf187;</i>\n";
			break;
		case "htm":
		case "html":
		case "php":
		case "js":
		case "css":
		case "xhtml":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"web\">&#xf0ac;</i>\n";
			break;
		case "doc":
		case "rtf":
		case "txt":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"doc\">&#xf15c;</i>\n";
			break;
		case "cfg":
		case "ini":
		case "log":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"cfg\">&#xf085;</i>\n";
			break;
		case "mp3":
		case "m4a":
		case "wma":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"audio\">&#xf001;</i>\n";
			break;
		case "mp4":
		case "m4v":
		case "avi":
		case "wmv":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"video\">&#xf008;</i>\n";
			break;
		case "bmp":
		case "jpg":
		case "gif":
		case "ico":
		case "png":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"image\">&#xf03e;</i>\n";
			break;
		case "dir":
			$rtn .= "	<i class=\"fa fa-fw\" data-type=\"dir\">&#xf07b;</i>\n";
			break;
		default:
			$rtn .= "	<i class=\"fa fa-fw\">&#xf15b;</i>\n";
			break;
	}
	$rtn .= "	<div class=\"name\">\n";
	if ($file_ext === "dir") {
		$rtn .= "		<div class=\"file\"><strong>[ " . basename($file) . " ]</strong></div>\n";
	} else {
		$rtn .= "		<div class=\"file\">" . basename($file) . "</div>\n";
	}	
	//$rtn .= "		<div class=\"file\">" . basename($file) . "</div>\n";
	$rtn .= "		<div class=\"date\">Size: " . format_size($file) . "<br />Last modified: " .  date("D. F jS, Y - h:ia", filemtime($file)) . "</div>\n";
	$rtn .= "	</div>\n";
	$rtn .= "	</a>\n";
	$rtn .= "</div>";
	return $rtn;
}


// RECURSIVE FUNCTION TO BUILD THE BLOCKS
function build_blocks($items, $folder){
	global $ignore_file_list, $ignore_ext_list, $sort_by, $toggle_sub_folders, $ignore_empty_folders;
	
	$objects = array();
	$objects['directories'] = array();
	$objects['files'] = array();
	
	foreach($items as $c => $item) {
		if( $item == ".." OR $item == ".") continue;
	
		// IGNORE FILE
		if(in_array($item, $ignore_file_list)) { continue; }
	
		if($folder && $item) {
			$item = "$folder/$item";
		}

		$file_ext = getFileExt($item);
		
		// IGNORE EXT
		if(in_array($file_ext, $ignore_ext_list)) { continue; }
		
		// DIRECTORIES
		if(is_dir($item)) {
			$objects['directories'][] = $item; 
			continue;
		}
		
		// FILE DATE
		$file_time = date("U", filemtime($item));
		
		// FILES
		if($item) {
			$objects['files'][$file_time . "-" . $item] = $item;
		}
	}
	
	foreach($objects['directories'] as $c => $file) {
		$sub_items = (array) scandir( $file );
		
		if($ignore_empty_folders) {
			$has_sub_items = false;
			foreach($sub_items as $sub_item) {
				$sub_fileExt = getFileExt($sub_item);
				if( $sub_item == ".." OR $sub_item == ".") continue;
				if(in_array($sub_item, $ignore_file_list)) continue;
				if(in_array($sub_fileExt, $ignore_ext_list)) continue;
			
				$has_sub_items = true;
				break;	
			}
			
			if($has_sub_items) echo display_block($file);
		} else {
			echo display_block($file);
		}
		
		if($toggle_sub_folders) {
			if($sub_items) {
				echo "<div class='sub' data-folder=\"$file\">";
				build_blocks( $sub_items, $file );
				echo "</div>";
			}
		}
	}
	
	// SORT BEFORE LOOP
	if( $sort_by == "date_asc" ) { ksort($objects['files']); }
	elseif( $sort_by == "date_desc" ) { krsort($objects['files']); }
	elseif( $sort_by == "name_asc" ) { natsort($objects['files']); }
	elseif( $sort_by == "name_desc" ) { arsort($objects['files']); }
	
	foreach($objects['files'] as $t => $file) {
		$fileExt = getFileExt($file);
		if(in_array($file, $ignore_file_list)) { continue; }
		if(in_array($fileExt, $ignore_ext_list)) { continue; }
		echo display_block( $file );
	}
}

// GET THE BLOCKS STARTED, FALSE TO INDICATE MAIN FOLDER
$items = scandir(dirname(__FILE__));
build_blocks($items,false);
?>

<?php if($toggle_sub_folders) { ?>
<script>
	$(document).ready(function() 
	{
		$("a.dir").click(function(e)
		{
		 	$('.sub[data-folder="' + $(this).attr('href') + '"]').slideToggle();
			e.preventDefault();
		});
	});
</script>
<?php } ?>
</div>
<div class="footer"><a href="https://github.com/demondevin/file-directory-list">Script</a> | <a href="https://codepen.io/demondevin/pen/RLdWRV">Icons</a></div>
</body>
</html>
