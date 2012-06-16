tinyMCE.init({
	// General options
	mode : "exact",
	elements: "cbody",
	theme : "advanced",
	width : "580",
	plugins : "safari,style,,advhr,advimage,advlink,inlinepopups,searchreplace,contextmenu,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,link,unlink,image,|,bullist,numlist,forecolor,|,hr,removeformat,|,cleanup,preview,code",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	
	convert_urls : false,
	remove_script_host: false,
	
	save_callback: "rebuildContent",
	onchange_callback: "changeContetnHandler",

	// Drop lists for link/image/media/template dialogs
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js"
});