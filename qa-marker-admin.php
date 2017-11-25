<?php
	class qa_marker_admin {
		
		function allow_template($template)
		{
			return ($template!='admin');
		}

		function option_default($option) {

			switch($option) {
				case 'marker_plugin_who_text_admin':
					return '<i class="fa fa-shield" aria-hidden="true"></i>';
				case 'marker_plugin_who_text_moderator':
					return '<i class="fa fa-bolt" aria-hidden="true"></i>';
				case 'marker_plugin_who_text_editor':
					return '<i class="fa fa-wrench" aria-hidden="true"></i>';
				case 'marker_plugin_who_text_expert':
					return '<i class="fa fa-heart" aria-hidden="true"></i>';
				case 'marker_plugin_css_2':
					return '
.qa-q-item-avatar,.qa-q-view-avatar,.qa-a-item-avatar,.qa-c-item-avatar {
	position:relative;
}
.qa-who-marker i {
	font-size: 110%;
}
.qa-who-marker {
	cursor: pointer;
	margin: 0px 2px;
}
.qa-who-marker{
	vertical-align: middle;
}
.qa-who-marker-expert {
	color: #34495e;
}				
.qa-who-marker-editor {
	color: #34495e;
}				
.qa-who-marker-moderator {
	color: #34495e;
}			
.qa-who-marker-admin {
	color: #34495e;
}	
.qa-avatar-marker {
	left:0;
	bottom:0;
	position:absolute;
}';
				default:
					return null;
			}
			
		}

		function admin_form(&$qa_content)
		{

		//	Process form input

			$ok = null;
			if (qa_clicked('marker_save_button')) {
				qa_opt('marker_plugin_css_2',qa_post_text('marker_plugin_css_2'));
				qa_opt('marker_plugin_who_text_admin',qa_post_text('marker_plugin_who_text_admin'));
				qa_opt('marker_plugin_who_text_moderator',qa_post_text('marker_plugin_who_text_moderator'));
				qa_opt('marker_plugin_who_text_editor',qa_post_text('marker_plugin_who_text_editor'));
				qa_opt('marker_plugin_who_text_expert',qa_post_text('marker_plugin_who_text_expert'));

				qa_opt('marker_plugin_w_users',(bool)qa_post_text('marker_plugin_w_users'));
				qa_opt('marker_plugin_w_qv',(bool)qa_post_text('marker_plugin_w_qv'));
				qa_opt('marker_plugin_w_qi',(bool)qa_post_text('marker_plugin_w_qi'));
				qa_opt('marker_plugin_w_a',(bool)qa_post_text('marker_plugin_w_a'));
				qa_opt('marker_plugin_w_c',(bool)qa_post_text('marker_plugin_w_c'));

				
				$ok = qa_lang('admin/options_saved');
			}
			else if (qa_clicked('marker_reset_button')) {
				foreach($_POST as $i => $v) {
					$def = $this->option_default($i);
					if($def !== null) qa_opt($i,$def);
				}
				$ok = qa_lang('admin/options_reset');
			}			
		//	Create the form for display
			
		
			$fields = array();

			$fields[] = array(
				'label' => 'Marker custom css',
				'tags' => 'NAME="marker_plugin_css_2"',
				'value' => qa_opt('marker_plugin_css_2'),
				'type' => 'textarea',
				'rows' => 20
			);

			$fields[] = array(
				'type' => 'blank',
			);			
			
			$fields[] = array(
				'label' => 'Marker text to show after Admin names',
				'tags' => 'NAME="marker_plugin_who_text_admin"',
				'value' => qa_opt('marker_plugin_who_text_admin'),
				'type' => 'textarea',
				'rows' => 1
			);

			$fields[] = array(
				'label' => 'Marker text to show after Moderator names',
				'tags' => 'NAME="marker_plugin_who_text_moderator"',
				'value' => qa_opt('marker_plugin_who_text_moderator'),
				'type' => 'textarea',
				'rows' => 1
			);

			$fields[] = array(
				'label' => 'Marker text to show after Editor names',
				'tags' => 'NAME="marker_plugin_who_text_editor"',
				'value' => qa_opt('marker_plugin_who_text_editor'),
				'type' => 'textarea',
				'rows' => 1
			);

			$fields[] = array(
				'label' => 'Marker text to show after Expert names',
				'tags' => 'NAME="marker_plugin_who_text_expert"',
				'value' => qa_opt('marker_plugin_who_text_expert'),
				'type' => 'textarea',
				'rows' => 1
			);

			$fields[] = array(
				'label' => 'Show marker after names in questions on pages',
				'tags' => 'NAME="marker_plugin_w_qv"',
				'value' => qa_opt('marker_plugin_w_qv'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show marker after names in questions in lists',
				'tags' => 'NAME="marker_plugin_w_qi"',
				'value' => qa_opt('marker_plugin_w_qi'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show marker after names in answers',
				'tags' => 'NAME="marker_plugin_w_a"',
				'value' => qa_opt('marker_plugin_w_a'),
				'type' => 'checkbox',
			);
			
			$fields[] = array(
				'label' => 'Show marker after names in comments',
				'tags' => 'NAME="marker_plugin_w_c"',
				'value' => qa_opt('marker_plugin_w_c'),
				'type' => 'checkbox',
			);
			$fields[] = array(
				'label' => 'Show marker after names in users list',
				'tags' => 'NAME="marker_plugin_w_users"',
				'value' => qa_opt('marker_plugin_w_users'),
				'type' => 'checkbox',
			);
			
	
			return array(
				'ok' => ($ok && !isset($error)) ? $ok : null,
				
				'fields' => $fields,
				
				'buttons' => array(
					array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'NAME="marker_save_button"',
					),
					array(
					'label' => qa_lang_html('admin/reset_options_button'),
					'tags' => 'NAME="marker_reset_button"',
					),
				),
			);
		}
	}
