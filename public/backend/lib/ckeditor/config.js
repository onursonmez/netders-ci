/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.allowedContent = true;
	
	config.baseHref = base_url;
	
	config.filebrowserBrowseUrl = base_url+'public/admin/lib/ckeditor/elfinder/elfinder.html';
	config.filebrowserImageWindowWidth = '970';
	config.filebrowserImageWindowHeight = '470';
	config.filebrowserWindowWidth = '970';
	config.filebrowserWindowHeight = '470';
	config.language = 'tr';
	
	config.removePlugins = 'forms, save';
	
	config.toolbarGroups = [
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection' ] },
		{ name: 'links' },
		'/',
		{ name: 'tools' },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'insert' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'colors' },
		{ name: 'styles' }
	];
	
	config.toolbar_Basic =
	[
		['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-']
	];
};

