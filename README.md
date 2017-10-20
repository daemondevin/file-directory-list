# PHP dirListing Script

Easily display files and folders in a mobile friendly, clean and cool way. Just drop the `index.php` in your folder and you are ready to go.

This was originally a [fork](https://github.com/halgatewood/file-directory-list) of a script made available by [Hal Gatewood](http://www.halgatewood.com/). To see his demo script of his original work, you can visit [this page](https://halgatewood.com/free/file-directory-list/).

In this version, I have changed/added a couple new little features like pure CSS icons instead of using an image in base64/sprite format. I also changed the way directories are listed so you can visibly see folders more so over files now. The icons I have used were created by me using nothing but CSS and Font Awesome. If you like the icons I used in this project, you can find the code I wrote to create them at this [CodePen Project Page](https://codepen.io/demondevin/pen/RLdWRV).

To see a working demo of my version of this script, you can visit [this page](https://c1935.paas2.tx.modxcloud.com/dirListing).

## ToDo

- I'll be changing the icon for directories to support the folders you see in this [CodePen Page](https://codepen.io/demondevin/pen/RLdWRV) as well.
- I'll be adding support for various other filetypes (**_i.e._** `.pdf`, `.psd`, `.docx`, `.swf`, etc.)
- I'm thinking about adding support for maybe editing text files. _Maybe_.
- I might also add support for viewing images with a lightweight, css-only lightbox. _Maybe_.
- Etc. and so on may also come depending on my interest and availability. 

## Options 

At the top of the `index.php` file you have a few settings you can change:

--
`$title = "List of Files";`

This will be the title of your page and also is set to the meta mitle of the document.

--
`$ignore_file_list = array( ".htaccess", "Thumbs.db", ".DS_Store", "index.php" );`

Create an array of files that you do not want to appear in the listing

--
`$ignore_ext_list = array( );`

You can create an array of extensions not to show, for example: 'jpg,png,gif,pdf'

--
`$sort_by = "name_asc";`

This will sort the files, the available options are: name_asc, name_desc, date_asc, date_desc

--
`$icon_url = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+gAAAAyCAYAAADP7vEw....";`

A data sprite of evenly spaced out icons. You can create your own like the one found here: https://www.dropbox.com/s/lzxi5abx2gaj84q/flat.png?dl=0

--
`$toggle_sub_folders = true;`

If a folder is clicked on, it will slide down the sub folder. You can turn this off here.

--
`$force_download = true;`

This will add the html download attribute which forces the download in some browsers.

--
`$ignore_empty_folders = true;`

Ability to hide empty folders.
