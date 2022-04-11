<?php

use Nouvu\Resources\System\BuilderHtml\CreateMap;

use function Nouvu\Resources\System\Helpers\{ config, charset, addFilemtime };

return [
	'head' => [
		'meta-charset' => CreateMap :: create( 'meta' ) -> data( ...[ 'http-equiv' => 'Content-Type', 'charset' => fn() => charset() ] ),
		'meta-viewport' => CreateMap :: create( 'meta' ) -> data( ...[ 'name' => 'viewport', 'content' => 'width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui' ] ),
		
		
		'css-montserrat' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => '//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600', 'rel' => 'stylesheet' ] ),
		'css-vendors' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/vendors.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-bootstrap' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/bootstrap.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-bootstrap-extended' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/bootstrap-extended.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-colors' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/colors.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-components' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/components.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-dark-layout' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/themes/dark-layout.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-bordered-layout' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/themes/bordered-layout.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-semi-dark-layout' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/themes/semi-dark-layout.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-vertical-menu' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/core/menu/menu-types/vertical-menu.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-form-validation' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/plugins/forms/form-validation.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-authentication' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/pages/authentication.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-style' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/assets/css/style.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-select2' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/forms/select/select2.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-dataTables-bootstrap5' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-responsive-bootstrap5' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-buttons-bootstrap5' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-rowGroup-bootstrap5' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-page-misc' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/pages/page-misc.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-ext-component-toastr' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/css/plugins/extensions/ext-component-toastr.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		'css-toastr' => CreateMap :: create( 'link' ) -> data( ...[ 'href' => fn() => addFilemtime( '/app-assets/vendors/css/extensions/toastr.min.css' ), 'rel' => 'stylesheet', 'type' => 'text/css' ] ),
		
		
		
		'js-nouvu' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/assets/js/nouvu.js' ) ] ),
		'js-vendors' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/vendors.min.js' ) ] ),
		'js-validate' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/forms/validation/jquery.validate.min.js' ) ] ),
		'js-app-menu' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/core/app-menu.js' ) ] ),
		'js-app' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/core/app.js' ) ] ),
		'js-auth-register' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/scripts/pages/auth-register.js' ) ] ),
		'js-select2-full' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/forms/select/select2.full.min.js' ) ] ),
		'js-form-select2' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/scripts/forms/form-select2.js' ) ] ),
		'js-jquery-dataTables' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js' ) ] ),
		'js-dataTables-bootstrap5' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js' ) ] ),
		'js-dataTables-responsive' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js' ) ] ),
		'js-responsive-bootstrap5' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js' ) ] ),
		'js-datatables-buttons' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js' ) ] ),
		'js-jszip' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/jszip.min.js' ) ] ),
		'js-pdfmake' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/pdfmake.min.js' ) ] ),
		'js-vfs-fonts' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/vfs_fonts.js' ) ] ),
		'js-buttons-html5' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/buttons.html5.min.js' ) ] ),
		'js-buttons-print' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/buttons.print.min.js' ) ] ),
		'js-dataTables-rowGroup' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js' ) ] ),
		'js-cleave' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/forms/cleave/cleave.min.js' ) ] ),
		'js-cleave-phone' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/forms/cleave/addons/cleave-phone.us.js' ) ] ),
		'js-app-user-list' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/scripts/pages/app-user-list.js' ) ] ),
		'js-ext-component-toastr' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/js/scripts/extensions/ext-component-toastr.js' ) ] ),
		'js-toastr' => CreateMap :: create( 'script' ) -> data( ...[ 'src' => fn() => addFilemtime( '/app-assets/vendors/js/extensions/toastr.min.js' ) ] ),
	],
	
	/*
		- 
	*/
	'extension' => '.php',
	
	/*
		- Замыкание
		- Подключение шаблона с использованием $app внутри.
	*/
	'include' => function ( string $template ) use ( $app )
	{
		include $template . config( 'viewer.extension' );
	},
];