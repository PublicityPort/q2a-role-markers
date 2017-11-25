<?php

        if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
			header('Location: ../../');
			exit;
	}
	
	qa_register_plugin_layer('qa-marker-layer.php', 'Marker Layer');	
	
	qa_register_plugin_module('module', 'qa-marker-admin.php', 'qa_marker_admin', 'Role Markers');

/*
	Omit PHP closing tag to help avoid accidental output
*/
