function add_edit_option_fancybox() {
	if( $(this).val() == 'add-edit' ){
		 $(this).fancybox({
            'autoScale': true,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 500,
            'speedOut': 300,
            'autoDimensions': true,
            'centerOnScroll': true
        });
	}
}