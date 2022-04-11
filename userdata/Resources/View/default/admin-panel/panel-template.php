<?php 
	
	/* Дичь:
	{<{head=js-app-user-list}>}
	не юзать, селект2 не работает с ней !!! */

?>
<!DOCTYPE html>
<html class="loading" lang="{<{locale}>}" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <title>{<{title}>}</title>
	{<{head=meta-charset|meta-viewport}>}
	{<{head=css-vendors|css-select2|css-dataTables-bootstrap5|css-responsive-bootstrap5|css-buttons-bootstrap5|css-rowGroup-bootstrap5}>}
	{<{head=css-bootstrap|css-bootstrap-extended|css-colors|css-components|css-dark-layout|css-bordered-layout}>}
	{<{head=css-semi-dark-layout|css-vertical-menu|css-form-validation|css-style}>}
	{<{head=css-montserrat}>}
	{<{head=css-toastr}>}
	{<{head=css-ext-component-toastr}>}
</head>
<!-- END: Head-->
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern navbar-floating footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="">
	<!-- BEGIN: Header-->
	{<{include=admin-panel/blocks/header}>}
	<!-- END: Header-->
	<!-- BEGIN: Main Menu-->
	{<{include=admin-panel/blocks/menu}>}
	<!-- END: Main Menu-->
	<!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <!-- users list start -->
				{<{content}>}
			    <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>
	
    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->
	{<{head=js-vendors}>}
	{<{head=js-toastr}>}
	
	{<{head=js-jquery-dataTables}>}
	{<{head=js-dataTables-bootstrap5}>}
	{<{head=js-dataTables-responsive}>}
	{<{head=js-responsive-bootstrap5}>}
	{<{head=js-datatables-buttons}>}
	{<{head=js-jszip}>}
	{<{head=js-pdfmake}>}
	{<{head=js-vfs-fonts}>}
	{<{head=js-buttons-html5}>}
	{<{head=js-buttons-print}>}
	{<{head=js-dataTables-rowGroup}>}
	{<{head=js-cleave}>}
	{<{head=js-cleave-phone}>}
	{<{head=js-validate}>}
	
	{<{head=js-select2-full}>}
	{<{head=js-form-select2}>}
	{<{head=js-app-menu}>}
	{<{head=js-app}>}
	{<{head=js-nouvu}>}
	
	
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
			
			var currentSkin = localStorage.getItem( 'light-layout-current-skin' );
			
			if ( currentSkin === 'dark-layout' )
			{
				$( '.nav-link-style' ).click();
			}
        })
    </script>
</body>
<!-- END: Body-->
</html>