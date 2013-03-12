/*Copyright (C) 2013 Jarosław Stasiaczek
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
 * and associated documentation files (the "Software"), to deal in the Software without restriction, 
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, 
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is 
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR 
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE 
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, 
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE.
 */

// Array Remove - By John Resig (MIT Licensed)
Array.prototype.remove = function(from, to) {
  var rest = this.slice((to || from) + 1 || this.length);
  this.length = from < 0 ? this.length + from : from;
  return this.push.apply(this, rest);
};

function UrlsContainer(){
	this.moreFiles = '';
	this.getFolderActions = '';
	this.getAbout = '';
	this.getOptions = '';
	this.uploadManyDialog = '';
	this.uploadFileXHR = '';
	this.createThumb = '';
	this.currentLocation = '';
}
var urls = new UrlsContainer();

function CUploader(){
	this.urls = null;
	this.inSelectMode = false;
	this.selectedFiles = [];
	this.viewMode = '';
	
	this.moreFiles = function(path,sender){
		window['current_upload_many_iter'] += 1;
		$.ajax({
			type: "GET",
			url: this.urls.moreFiles+'&path='+path+'&iter='+window['current_upload_many_iter']
		  }).done(function( msg ) {
			$(sender).parent().before(msg);
		  });
	};
	
	this.toggleSelectMode = function(obj){
		obj = $(obj);
		this.selectedFiles = [];
		if(obj.hasClass('selectModeOn'))
		{
			obj.removeClass('selectModeOn');
			$('.image-element').removeClass('selectedFile');
			$('#deleteManyButton').css('display', 'none');
			this.inSelectMode = false;
			
		}
		else
		{
			obj.addClass('selectModeOn');
			this.inSelectMode = true;
		}
	};
	
	this.deleteManyImages = function(path, message)
	{
		message = message.replace("#co#", this.selectedFiles.length);
		if(!confirm(message))
			return;
		var files = [];
		for(var i=0;i < this.selectedFiles.length;i++)
		{
			var file = this.selectedFiles[i].substring(this.selectedFiles[i].lastIndexOf('/')+1, this.selectedFiles[i].length);
			path = this.selectedFiles[i].substring(0, this.selectedFiles[i].lastIndexOf('/')+1);
			files.push(file);
		}
		var data = {
			action : 'delete',
			back: path,
			file: files
		};
		$.post(this.urls.getOptions, data, function(){
			window.location.assign(uploader.urls.currentLocation);
		});
	};

	this.uploadManyFiles = function(forceNormal, params)
	{
		if(this.initCorrectUploader(forceNormal, true))
		{
			$('#upload_many_dlg').modal('hide');
			window.setTimeout('uploader.pleaseWait();', 50);
			window.setTimeout('$(\'#upload_many_form\').submit();', 300);
		}
		else
		{
			this.uploadFileXHR(params, true);
			$('#upload_many_dlg').modal('hide');
		}
	}

	this.getFolderActions = function(path){
		$.post(this.urls.getFolderActions, {'path':path}, function(data){
			$('#folder_actions').html(data).modal('show');
		});

	}
	this.getAbout = function(){
		$.post(this.urls.getAbout, function(data){
			$('#about').html(data).modal('show');
		});

	}
	
	this.toggleFile = function(path, obj){
		var selected = false;
		if(this.viewMode == 'view_grid')
			selected = this.toggleFileGrid(path, obj);
		else
			selected = this.toggleFileList(path, obj);
		if(selected)
			this.selectedFiles.push(path);
		else
		{
			var pos = this.selectedFiles.indexOf(path);
			if(pos >= 0)
				this.selectedFiles.remove(pos);
		}
		if(this.selectedFiles.length > 0)
			$('#deleteManyButton').css('display', 'block');
		else
			$('#deleteManyButton').css('display', 'none');
	};
	
	this.toggleFileGrid = function(path, obj){
		obj = $(obj);
		if(obj.hasClass('selectedFile'))
		{
			obj.removeClass('selectedFile');
			return false;
		}
		obj.addClass('selectedFile');
		return true;
	};
	
	this.toggleFileList = function(path, obj){
		obj = $(obj).parents('tr');
		if(obj.hasClass('selectedFile'))
		{
			obj.removeClass('selectedFile');
			return false;
		}
		obj.addClass('selectedFile');
		return true;
	};

	this.getOptions = function(path, obj){
		if(this.inSelectMode)
		{
			this.toggleFile(path, obj);
			return;
		}
		var file = path.substring(path.lastIndexOf('/')+1, path.length);
		path = path.substring(0, path.lastIndexOf('/')+1);
		$.post(urls.getOptions, {'file': file, 'path':path}, function(data){
			$('#options').html(data).modal('show');
		});
	};
	
	this.uploadManyDialog = function(path)
	{
		$.ajax({
			type: "GET",
			url: this.urls.uploadManyDialog+'&path='+path
		  }).done(function( msg ) {
			$('#upload_many_dlg').html(msg).modal('show');
		  });
	};


	this.showErrors = function(errors, warnings)
	{
		var html = '';
		if(errors != undefined)
		{
			html += this.showErrorsRenderArray(errors, 'alert-error');
		}
		if(warnings != undefined)
		{
			html += this.showErrorsRenderArray(warnings, '');
		}
		$('#errors .modal-body').html(html);
		$('#errors').modal('show');
	};

	this.showErrorsRenderArray = function(data, cssclass)
	{
		var html = '';
		var i = 0;
		for(i;i < data.length; i++)
		{
			html += '<div class="alert alert-smaller '+cssclass+'"><strong>'+data[i].file+'</strong>: '+data[i].message+'</div>';
		}
		return html;
	}

	this.validateFolderName = function(field_id)
	{
		var patt = /^[|a-zA-Z0-9_]*$/i;
		var obj = $('#'+field_id);
		if(patt.test(obj.val()) && obj.val() != '___cache')
		{
			return true;
		}
		else
		{
			obj.css('border-color', 'red');
			return false;
		}
	}

	this.pleaseWait = function()
	{
		$('#wait').modal({'backdrop': 'static', 'keyboard': false});
		$('#wait').find('.bar').css('width', '100%');
		$('#wait').find('span').html('');
	}
	
	this.hideWait = function()
	{
		$('#wait').modal('hide');
	}

	this.deleteImage = function(message)
	{
		if(confirm(message))
		{
			$('#delete_form').submit();
			return false;
		} 
		else 
		{
			return false;
		}
	}

	this.createThumb = function(path_add, id, imageName)
	{
		$.ajax({
			url: this.urls.createThumb, 
			async: false,
			data: {'thumb_id': id, 'imageName':imageName, 'path_add': path_add}, 
			type: 'POST',
			success: function(data){
				var json = $.parseJSON(data);
				if(json.success)
				{
					targetObj.insert(json.url, json.attributes[0],json.attributes[1], 'width: '+json.attributes[0]+'px; height: '+json.attributes[1]+'px;');
				}
				else
					alert(json.error);
		}});
	}

	// XHR upload part =========================================================================

	this.supportAjaxUploadWithProgress = function() {
		return supportFileAPI() && supportAjaxUploadProgressEvents() && supportFormData();

	  // Is the File API supported?
	  function supportFileAPI() {
		var fi = document.createElement('INPUT');
		fi.type = 'file';
		return 'files' in fi;
	  };

	  // Are progress events supported?
	  function supportAjaxUploadProgressEvents() {
		var xhr = new XMLHttpRequest();
		return !! (xhr && ('upload' in xhr) && ('onprogress' in xhr.upload));
	  };

	  // Is FormData supported?
	  function supportFormData() {
		return !! window.FormData;
	  }
	}
	
	this.initCorrectUploader = function(forceNormal, returnonly)
	{
		returnonly = (returnonly)? returnonly: false;
		if(forceNormal == undefined || forceNormal == null)
			forceNormal = false;
		if(returnonly)
			return (!this.supportAjaxUploadWithProgress() || forceNormal);
		if (!this.supportAjaxUploadWithProgress() || forceNormal) {
			$('#normal-upload-button').css('display', 'inline');
			$('#xhr-upload-button').css('display', 'none');
		}
		else
		{
			$('#normal-upload-button').css('display', 'none');
			$('#xhr-upload-button').css('display', 'inline');
		}
	}

	this.uploadFileXHR = function(params, multiupload)
	{
		multiupload = (multiupload)? multiupload: false;
		window['upload_file_counter'] = 0;
		var formData = new FormData();

		// Since this is the file only, we send it to a specific location
		var action = urls.uploadFileXHR+params;

		// FormData only has the file
		if(!multiupload)
		{
			var fileInput = document.getElementById('single-upload-file');
			var file = fileInput.files[0];
			formData.append('single-upload-file', file);
		}
		else
		{
			var fileInputs = document.getElementsByClassName('multiupload-files');
			for(var i = 0; i < fileInputs.length; i++)
			{
				formData.append('multiupload-file-'+i, fileInputs[i].files[0]);
			}
		}	

		// Code common to both variants
		this.sendXHRequest(formData, action);
	}

	// Once the FormData instance is ready and we know
	// where to send the data, the code is the same
	// for both variants of this technique
	this.sendXHRequest = function(formData, uri) {
		// Get an XMLHttpRequest instance
		var xhr = new XMLHttpRequest();
		// Set up events
		xhr.upload.addEventListener('loadstart', this.onloadstartHandler, false);
		xhr.upload.addEventListener('progress', this.onprogressHandler, false);
		xhr.addEventListener('readystatechange', this.onreadystatechangeHandler, false);
		window['file_rendered'] = false;
		// Set up request
		xhr.open('POST', uri, true);

		// Fire!
		xhr.send(formData);

	}

	// Handle the start of the transmission
	this.onloadstartHandler = function(evt) {
		uploader.pleaseWait();
		$('#wait .bar').css('width', '0%');
		$('#wait span').html('0%');
	}

	// Handle the progress
	this.onprogressHandler = function(evt) {
		var percent = evt.loaded/evt.total*100;
		var val = Math.floor(percent) + '%';
		$('#wait .bar').css('width', val);
		$('#wait span').html(val);
	}

	// Handle the response from the server
	this.onreadystatechangeHandler = function(evt) {
		// hotfix for firefox 
		if(window['file_rendered'] == true)
			return;
		var status = null;

		try {
			status = evt.target.status;
		}
		catch(e) {
			return;
		}
		uploader.hideWait();
		if (status == '200' && evt.target.responseText.length > 0) {
			var ret = evt.target.responseText;
			var json = $.parseJSON(ret);
			var item = null;
			for(var i = 0; i < json.html.length; i++)
			{
				item = $(".image-element").first();
				if(item.length > 0)
				{
					item.before(json.html[i]);
				}	
				else
				{
					$("#items-list").append(json.html[i]);
				}
			}
			var x = 0;
			if(json.errors.length > 0 || json.warnings.length > 0)
			{
				uploader.showErrors(json.errors, json.warnings);
			}
			window['file_rendered'] = true;
		}
	}
}


function CFakeFileInput(){
	
	this.renderPath = function(trueInput, fakeInput){
		var value = trueInput.val();
		if(value == '')
		{
			fakeInput.val('...');
			return;
		}
		if(value.lastIndexOf('/') != -1)
		{
			value = value.substr(value.lastIndexOf("/")+1)	
		}
		if(value.lastIndexOf("\\") != -1)
		{
			value = value.substr(value.lastIndexOf("\\")+1)
		}
		fakeInput.val(value);
			return;
	};
}
