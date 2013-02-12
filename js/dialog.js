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

tinyMCEPopup.requireLangPack();

var CUploaderDialog = {
	init : function() {
		if(typeof tinyMCEPopup.editor.settings.cuploaderSettings == 'undefined')
		{
			tinyMCEPopup.editor.settings.cuploaderSettings = {
				'type' : null,
				'path' : null
			};
		}
		var val = tinyMCEPopup.editor.getParam('language');
		var iframeUrl = 'root/manage.php/index/?lang='+val;
		if(this.getViewType() != null)
			iframeUrl += '&type='+this.getViewType();
		if(this.getCurrentPath() != null)
			iframeUrl += '&path='+this.getCurrentPath();
		document.getElementById('cuploader').src = iframeUrl;
		function getCorrectSize(){
		var myWidth = 0, myHeight = 0;
		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}
		myHeight -= 5;
		document.getElementById('cuploader').style.width = myWidth+'px';
		document.getElementById('cuploader').style.height = myHeight+'px';
		};
		getCorrectSize();
		window.onresize = getCorrectSize;
	},
	
	getViewType : function(){
		return tinyMCEPopup.editor.settings.cuploaderSettings.type;
	},

	setViewType : function(type){
		tinyMCEPopup.editor.settings.cuploaderSettings.type = type;
	},
	
	getCurrentPath : function(){
		return tinyMCEPopup.editor.settings.cuploaderSettings.path;
	},
	setCurrentPath : function(path){
		tinyMCEPopup.editor.settings.cuploaderSettings.path = path;
	},

	insert : function(image, width, height, styles) {
		// Insert the contents from the input into the document
		if(width != null)
			width = 'width="'+width+'"';
		else
			width = '';
			
		if(height != null)
			height = 'height="'+height+'"';
		else
			height = '';
		if(styles != null)
			styles = 'style="'+styles+'"';
		else
			styles = '';
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, '<img '+width+' '+height+' '+styles+' src="'+image+'" />');
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(CUploaderDialog.init, CUploaderDialog);
