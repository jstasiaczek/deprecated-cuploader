CKEDITOR.plugins.add('cuploader', {
	init: function( editor )
	{
		editor.addCommand( 'cuploaderDialog', new CKEDITOR.dialogCommand( 'cuploader' ) );
		editor.ui.addButton( 'Cuploader',
		{
			label: 'Cuploader',
			command : 'cuploaderDialog',
			icon: this.path + 'images/archive.png'
		} );
	}
} );

CKEDITOR.dialog.add( 'cuploader', function ( editor )
{
	return {
		title : 'Cuploader',
		minWidth : 820,
		minHeight : 500,
		contents :
		[{
			id:"tab1",
			label:"",
			title:"",
			expand:!0,
			padding:0,
			elements:[{type:"html",html:'<style>td.cke_dialog_contents_body{padding: 0px;}</style><iframe id="cuploader" style="width:820px;height:495px" src="'+prepareUrl()+'"></iframe>'}]
		}],
		resizable: CKEDITOR.DIALOG_RESIZE_NONE,
		buttons:[CKEDITOR.dialog.cancelButton]
	};
} );

function prepareUrl(){
	if(typeof CKEDITOR.currentInstance.config.cuploaderStorage === "undefined")
	{
		CKEDITOR.currentInstance.config.cuploaderStorage = {path: null, type:null};
	}
	var editor_url = '';
	// determine correct cuploader path
	if( typeof CKEDITOR.currentInstance.config.cuploader_url === 'string')
		editor_url += CKEDITOR.currentInstance.config.cuploader_url;
	else
		editor_url += 'root/';
	editor_url += 'manage.php/?target=ckeditor&lang=';
	// determine language
	if(parent.CKEDITOR.currentInstance.config.language !== "")
		editor_url += CKEDITOR.currentInstance.config.language;
	else
		editor_url += CKEDITOR.currentInstance.config.defaultLanguage;
	// set current path
	if(CKEDITOR.currentInstance.config.cuploaderStorage.path != null)
		editor_url += '&path='+CKEDITOR.currentInstance.config.cuploaderStorage.path;
	// set current view
	if(CKEDITOR.currentInstance.config.cuploaderStorage.type != null)
		editor_url += '&path='+CKEDITOR.currentInstance.config.cuploaderStorage.type;
	return editor_url;
}

