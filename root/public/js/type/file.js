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
function CTypeFile(){
	this.getHtml = function(){
		var htmlTag = '<a href="';
		htmlTag += $('#file-input-url').val()+'"';
		if($('#file-input-window').is(':checked'))
			htmlTag += ' target="_blank" ';
		if($('#file-input-title').length > 0)
			htmlTag += ' title="'+$('#file-input-title').val()+'" ';
		htmlTag += ' >'+$('#file-input-text').val()+'</a>';
		return htmlTag;
	};
	this.getContent = function()
	{
		var val = $('#file-input-wrap').val();
		var content = $('#file-content').val();
		if(val != '0')
		{
			return "<"+val+">"+content+"</"+val+">";
		}
		return content;
	}
}
var typeFile = new CTypeFile();