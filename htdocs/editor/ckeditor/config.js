/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function(config) {
    
	config.height = '60%';
	config.allowedContent = true;

    config.toolbarGroups = [
        { name: 'document', groups: ['mode', 'document', 'doctools'] },
        { name: 'clipboard', groups: ['clipboard', 'undo'] },
        { name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
        { name: 'forms', groups: ['forms'] },
        '/',
        { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
        { name: 'paragraph', groups: ['list', 'indent', 'align', 'bidi', 'blocks', 'paragraph'] },
        { name: 'links', groups: ['links'] },
        { name: 'insert', groups: ['insert'] },
        '/',
        { name: 'styles', groups: ['styles'] },
        { name: 'colors', groups: ['colors'] },
        { name: 'tools', groups: ['tools'] },
        { name: 'others', groups: ['others'] },
        { name: 'about', groups: ['about'] }
    ];

    config.removeButtons = 'NewPage,Save,Select,Button,Checkbox,Form,Radio,ImageButton,HiddenField,TextField,Textarea';

    config.filebrowserBrowseUrl = 'RFM/filemanager/dialog.php?akey=' + $("#idd").text() + '&type=2&editor=ckeditor&fldr=';
    config.filebrowserImageBrowseUrl = 'RFM/filemanager/dialog.php?akey=' + $("#idd").text() + '&type=2&editor=ckeditor&fldr=';

};