/*Copyright (C) 2012 Jarosław Stasiaczek
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

function UrlsContainer(){
	this.moreFiles = '';
	this.getFolderActions = '';
	this.getAbout = '';
	this.getOptions = '';
	this.uploadManyDialog = '';
	this.uploadFileXHR = '';
	this.createThumb = '';
}
var urls = new UrlsContainer();


var more_files = function(path,sender){
	window['current_upload_many_iter'] += 1;
	$.ajax({
		type: "GET",
		url: urls.moreFiles+'&path='+path+'&iter='+window['current_upload_many_iter']
		//url: baseUrl+'/upload/?lang='+lang+'&path='+path+'&action=add_field'+'&iter='+window['current_upload_many_iter']
	  }).done(function( msg ) {
		$(sender).parent().before(msg);
	  });
}

var set_overlay = function(){
	var height = $(window).height();
	if($('body').height() > height)
		height = $('body').height();
	$('#overlay').css('display', 'block').css('height', height+'px');
}

var uploadManyFiles = function()
{
	$('#upload_many_dlg').modal('hide');
	window.setTimeout('please_wait();', 50);
	window.setTimeout('$(\'#upload_many_form\').submit();', 300);
}

var close_overlay = function(){
	$('#overlay').css('display', 'none');
}

var get_folder_actions = function(path){
	$.post(urls.getFolderActions, {'path':path}, function(data){
		$('#folder_actions').html(data).modal('show');
	});
	
}
var get_about = function(){
	$.post(urls.getAbout, function(data){
		$('#about').html(data).modal('show');
	});
	
}

var get_options = function(path){
	var file = path.substring(path.lastIndexOf('/')+1, path.length);
	path = path.substring(0, path.lastIndexOf('/')+1);
	$.post(urls.getOptions, {'file': file, 'path':path}, function(data){
		$('#options').html(data).modal('show');
	});
	
}

var close_options = function()
{
	$('#options').css('display', 'none');
	close_overlay();
}
var close_folder_actions = function()
{
	$('#folder_actions').css('display', 'none');
	close_overlay();
}
var close_xhr_info = function()
{
	$('#xhr_info').modal('hide');
}

var upload_many_dialog = function(path)
{
	$.ajax({
		type: "GET",
		url: urls.uploadManyDialog+'&path='+path
	  }).done(function( msg ) {
		$('#upload_many_dlg').html(msg).modal('show');
	  });
}

var show_errors = function(errors, warnings)
{
	var html = '';
	if(errors != undefined)
	{
		html += show_errors_render_array(errors, 'alert-error');
	}
	if(warnings != undefined)
	{
		html += show_errors_render_array(warnings, '');
	}
	$('#errors .modal-body').html(html);
	$('#errors').modal('show');
}

var show_errors_render_array = function(data, cssclass)
{
	var html = '';
	var i = 0;
	for(i;i < data.length; i++)
	{
		html += '<div class="alert alert-smaller '+cssclass+'"><strong>'+data[i].file+'</strong>: '+data[i].message+'</div>';
	}
	return html;
}

var validate_folder_name = function(field_id)
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

var please_wait = function()
{
	$('#wait').modal({'backdrop': 'static', 'keyboard': false});
	$('#wait').find('.bar').css('width', '100%');
	$('#wait').find('span').html('');
}
var hide_wait = function()
{
	$('#wait').modal('hide');
}

var delete_image = function(message)
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

var createThumb = function(path_add, id, imageName)
{
	$.ajax({
		url: urls.createThumb, 
		async: false,
		data: {'thumb_id': id, 'imageName':imageName, 'path_add': path_add}, 
		type: 'POST',
		success: function(data){
			var json = $.parseJSON(data);
			if(json.success)
				parent.CUploaderDialog.insert(json.url, json.attributes[0],json.attributes[1], 'width: '+json.attributes[0]+'px; height: '+json.attributes[1]+'px;');
			else
				alert(json.error);
	}});
}



// XHR upload part =========================================================================

function supportAjaxUploadWithProgress() {
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



function initCorrectUploader(forceNormal)
{
	if(forceNormal == undefined || forceNormal == null)
		forceNormal = false;
	if (!supportAjaxUploadWithProgress() || forceNormal) {
		$('#normal-upload-button').css('display', 'inline');
		$('#xhr-upload-button').css('display', 'none');
	}
	else
	{
		$('#normal-upload-button').css('display', 'none');
		$('#xhr-upload-button').css('display', 'inline');
	}
}

function uploadFileXHR(params)
{
	window['upload_file_counter'] = 0;
	var formData = new FormData();

    // Since this is the file only, we send it to a specific location
    var action = urls.uploadFileXHR+params;

    // FormData only has the file
    var fileInput = document.getElementById('single-upload-file');
    var file = fileInput.files[0];
    formData.append('single-upload-file', file);

    // Code common to both variants
    sendXHRequest(formData, action);
}

// Once the FormData instance is ready and we know
// where to send the data, the code is the same
// for both variants of this technique
function sendXHRequest(formData, uri) {
  // Get an XMLHttpRequest instance
  var xhr = new XMLHttpRequest();
  // Set up events
  xhr.upload.addEventListener('loadstart', onloadstartHandler, false);
  xhr.upload.addEventListener('progress', onprogressHandler, false);
  xhr.addEventListener('readystatechange', onreadystatechangeHandler, false);
  window['file_rendered'] = false;
  // Set up request
  xhr.open('POST', uri, true);

  // Fire!
  xhr.send(formData);

}

// Handle the start of the transmission
function onloadstartHandler(evt) {
	please_wait();
	$('#wait .bar').css('width', '0%');
	$('#wait span').html('0%');
}

// Handle the progress
function onprogressHandler(evt) {
	var percent = evt.loaded/evt.total*100;
	var val = Math.floor(percent) + '%';
	$('#wait .bar').css('width', val);
	$('#wait span').html(val);
}

// Handle the response from the server
function onreadystatechangeHandler(evt) {
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
	hide_wait();
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
			show_errors(json.errors, json.warnings);
		}
		window['file_rendered'] = true;
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
