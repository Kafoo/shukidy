// TINYMCE INITIALISATION
export default function tinymceInit($format){
	if (typeof tinymce !== 'undefined') {
		if ($format == 'desktop') {
			tinymce.init({
			    selector: '.mytextarea',
			    content_css : "/public/css/_shared_/tinymce.css",
			    height: 390,
			    menubar: false,
			    forced_root_block : "",
			    statusbar : false,
			    toolbar_drawer : 'floating',
			    paste_auto_cleanup_on_paste : true,
			    paste_remove_styles: true,
			    paste_remove_styles_if_webkit: true,
			    paste_strip_class_attributes: true,
			    fontsize_formats: "6pt 8pt 11pt 14pt 18pt",
			    toolbar: 'undo redo | bold italic | link image | forecolor backcolor | fontsizeselect | code',
			    plugins: 'code image preview paste'
			});
		}
		if ($format == 'mobile') {
			tinymce.init({
			    selector: '.mytextarea',
			    content_css : "style/_shared_/tinymce.css",
			    height: 184,
			    menubar: false,
			    forced_root_block : "",
			    statusbar : false,
			    toolbar_drawer : 'floating',
			    paste_auto_cleanup_on_paste : true,
			    paste_remove_styles: true,
			    paste_remove_styles_if_webkit: true,
			    paste_strip_class_attributes: true,
			    fontsize_formats: "6pt 8pt 11pt 14pt 18pt",
			    toolbar: 'bold italic | forecolor fontsizeselect',
			    plugins: 'code image preview paste'
			});
		}
	}
}