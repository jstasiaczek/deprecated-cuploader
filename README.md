CUploader
=========

This is TinyMCE plugin written in PHP. 
It is allowing users to manage their uploaded images and allow to upload new images.

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


Installation
------

* Download latest tag.
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
