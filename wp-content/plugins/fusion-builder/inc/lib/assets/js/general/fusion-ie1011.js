function addStylesForOldIEVersions() {

	// IE10
	if ( '10.0' == cssua.ua.ie ) {
		jQuery( 'head' ).append( '<style type="text/css">.layout-boxed-mode .fusion-footer-parallax { left: auto; right: auto; }.fusion-imageframe,.imageframe-align-center{font-size: 0px; line-height: normal;}.fusion-button.button-pill,.fusion-button.button-pill:hover{filter: none;}.fusion-header-shadow:after, body.side-header-left .header-shadow#side-header:before, body.side-header-right .header-shadow#side-header:before{ display: none }.search input,.searchform input {padding-left:10px;} .avada-select-parent .select-arrow,.select-arrow{height:33px;background-color:' + fusionIe1011Vars.form_bg_color + '}.search input{padding-left:5px;}header .tagline{margin-top:3px;}.star-rating span:before {letter-spacing: 0;}.avada-select-parent .select-arrow,.gravity-select-parent .select-arrow,.wpcf7-select-parent .select-arrow,.select-arrow{background: #fff;}.star-rating{width: 5.2em;}.star-rating span:before {letter-spacing: 0.1em;}</style>' );
	}

	// IE11
	if ( '11.0' == cssua.ua.ie ) {
		jQuery( 'head' ).append( '<style type="text/css">.layout-boxed-mode .fusion-footer-parallax { left: auto; right: auto; }</style>' );
	}
}

jQuery( document ).ready( function( $ ) {
	addStylesForOldIEVersions();
});
