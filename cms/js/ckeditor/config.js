/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.language = 'pt-br';
	config.toolbar = 'MyToolbar';
    config.toolbar_MyToolbar =
    [
        ['NewPage','Preview'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['TextColor','BGColor'],
        '/',
        ['Styles','Format','Font','FontSize'],
        ['Bold','Italic','Strike'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Maximize','-','Source']
    ];

};