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
function CTypeImage(){
	this.getHtml = function(url, width, height, attributes){
		var imgTag = '<img src="';
		imgTag += url+'"';
		if(width != null)
			imgTag += ' width="'+width+'" ';
		if(height != null)
			imgTag += ' height="'+height+'" ';
		if(attributes != null)
			imgTag += ' style="'+attributes+'" ';
		if($('#image-input-title').length > 0)
			imgTag += ' title="'+$('#image-input-title').val()+'" ';
		if($('#image-input-alt').length > 0)
			imgTag += ' alt="'+$('#image-input-alt').val()+'" ';
		imgTag += ' />';
		return imgTag;
	};

	this.createThumb = function(path_add, id, imageName)
	{
		$.ajax({
			url: uploader.urls.createThumb, 
			async: false,
			data: {'thumb_id': id, 'imageName':imageName, 'path_add': path_add}, 
			type: 'POST',
			success: function(data){
				var json = $.parseJSON(data);
				if(json.success)
				{
					targetObj.insert(typeImage.getHtml(json.url, json.attributes[0],json.attributes[1], 'width: '+json.attributes[0]+'px; height: '+json.attributes[1]+'px;'));
				}
				else
					alert(json.error);
		}});
	};
}
var typeImage = new CTypeImage();