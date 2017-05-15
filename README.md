!DEPRECATED! CUploader
=========

CUploader is standalone application that can be used with CKEditor, Tinymce or as popup.
It is allowing users to manage their uploaded images/pdfs/text files and allow to upload new files.

This software is released under the MIT License.

Some features:
* Allow to upload file by AJAX.
* It looks nice and clean. Use Twitter Bootstrap.
* You can select between few view types.
* It have many configuration options.
* It have simple security options. You can set for example user upload dir or deny uploading files for user.
* It take care about filenames, and change then to browser safe.
* It can create thumbnails. Thumbnail is created only when user want to use it.
* It provide simple directory managment.

Installation (version 3.x)
------

### Directory structure

After downloading CUploader you will see two dirs:
* root - contains cuploader itself as standalone app
* target - contains plugins for each supported platform
 
### Installing standalone CUploader

Inside dir root/app/Config you can find main.php, edit it, to run application you need to fill few config values:
* image_upload_dir - path to directory where images are saved 
* image_upload_url - url to directory where images are saved 
* thumb_dir - path to dir where thumbnails are created, different from image_upload_dir!
* thumb_url - url to thumbnails dir
 
It's good idea to edit also Secure.php in root/app/Config and extends method:
* can_access - you need to write here code that will let only trusted users, in other case all users can upload images!
 
### Installing in "editor"

After installing standalone app ypu can use one of provided plugins:
* popup - it is very simple pice of code, that allow you to run CUploader in popup and inser files in any place in the site.
* tinymce - allow to use CUploader in TinyMCE
* tinymce4 - allow to use CUploader in TinyMCE 4
* ckeditor - allow to run in CKEditor

#### PopUp

It dont need mutch attention, in standard dir configuration it should just work, in other case you need to edit index.html
```popup.init('../../root/', 'pl', 'grid');```
and change '../../root/' to correct path

#### TinyMCE

* Copy cuploader dir from /target/tinymce to TinyMCE plugins dir
* In configuration you should add cuploader to plugins list 
* In configuration you should add cuploader to toolbar
* Create new option cuploader_url in configuration with url to CUploader to file manage.php, but it will be added automatically to url

#### TinyMCE 4

It is very similar to TinyMCE installation but you don't need to add CUploader button to toolbar

#### CKEditor

In config.js add:
* ``` config.cuploader_url = '/cuploader/root/'; ``` with correct path to cuploader
* add ``` { name: 'Cuploader' } ``` and end of array config.toolbarGroups


Installation (under version 3.0.0)
------

* Download latest tag for version 2.x
* Put it in TinyMCE plugin directory, it should be named cuploader.
* Add it to TinyMCE configuration:

```javascript
plugins : "cuploader,...",
...
theme_advanced_buttons1 : 'cuploader,...',
```
* Edit configuration of plugin, go to <TinyMCE root dir>/plugin/cuploader/app/Config/main.php
and edit

```php
  // orginal size upload dir and url 
	'image_upload_dir' => '',
	'image_upload_url' => '',
	// thumbnail dir
	'thumb_dir' => '',
	'thumb_url' => '',
```
* Now plugin should start working, it is highly recomended to edit also 
<TinyMCE root dir>/plugin/cuploader/app/Config/Secure.php and extend can_access() method. You can also see
<TinyMCE root dir>/plugin/cuploader/app/Config/Base/Secure.php for more methods.

For more informations please read wiki: https://github.com/siidhighwind/cuploader/wiki

