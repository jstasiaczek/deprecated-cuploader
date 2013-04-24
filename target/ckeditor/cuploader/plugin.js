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
	CKEDITOR.currentInstance = editor;
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
			elements:[{type:"html",html:'<style>td.cke_dialog_contents_body{padding: 0px;}</style><iframe id="cuploader" style="width:820px;height:495px" src="'+prepareUrl(editor)+'"></iframe>'}]
		}],
		resizable: CKEDITOR.DIALOG_RESIZE_NONE,
		buttons:[CKEDITOR.dialog.cancelButton]
	};
} );

function prepareUrl(editor){
	if(typeof editor.config.cuploaderStorage === "undefined")
	{
		editor.config.cuploaderStorage = {path: null, type:null};
	}
	var editor_url = '';
	// determine correct cuploader path
	if( typeof editor.config.cuploader_url === 'string')
		editor_url += editor.config.cuploader_url;
	else
		editor_url += 'root/';
	editor_url += 'manage.php/?target=ckeditor&lang=';
	// determine language
	if(editor.config.language !== "")
		editor_url += editor.config.language;
	else
		editor_url += editor.config.defaultLanguage;
	// set current path
	if(editor.config.cuploaderStorage.path != null)
		editor_url += '&path='+editor.config.cuploaderStorage.path;
	// set current view
	if(editor.config.cuploaderStorage.type != null)
		editor_url += '&path='+editor.config.cuploaderStorage.type;
	return editor_url;
}

