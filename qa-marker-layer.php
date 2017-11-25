<?php
	class qa_html_theme_layer extends qa_html_theme_base
	{
		function head_custom()
		{
			
			$this->output('<style>'.qa_opt('marker_plugin_css_2').'</style>');
			$this-> output('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">');
		
			parent::head_css();

		}

		/*function post_avatar($post, $class, $prefix=null)
		{
			if(isset($post['avatar']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_w_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_w_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_w_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_w_c')))) {
				$uid = $post['raw']['userid'];
				$image = $this->get_role_marker($uid,1);
				$post['avatar'] = $image.@$post['avatar'];
			}
			qa_html_theme_base::post_avatar($post, $class, $prefix);
		}*/
		function post_meta($post, $class, $prefix=null, $separator='<BR/>')
		{
			if(isset($post['who']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_w_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_w_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_w_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_w_c')))) {
				$handle = strip_tags($post['who']['data']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$post['who']['data'] = $post['who']['data'].$image;
				
			}
			if(isset($post['who_2']) && (($class == 'qa-q-view' && qa_opt('marker_plugin_w_qv')) || ($class == 'qa-q-item' && qa_opt('marker_plugin_w_qi')) || ($class == 'qa-a-item' && qa_opt('marker_plugin_w_a')) || ($class == 'qa-c-item' && qa_opt('marker_plugin_w_c')))) {
				$handle = strip_tags($post['who_2']['data']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$post['who_2']['data'] = $post['who_2']['data'].$image;
			}

			qa_html_theme_base::post_meta($post, $class, $prefix, $separator);
		}
		function ranking_label($item, $class)
		{
			if(qa_opt('marker_plugin_w_users') && $class == 'qa-top-users') {
				$handle = strip_tags($item['label']);
				$uid = $this->getuserfromhandle($handle);
				$image = $this->get_role_marker($uid,2);
				$item['label'] = $item['label'].$image;
			}
			qa_html_theme_base::ranking_label($item, $class);
		}
				
	// worker
		
		function get_role_marker($uid,$switch) {
			if (QA_FINAL_EXTERNAL_USERS) {
				$user = get_userdata( $uid );
				if (isset($user->wp_capabilities['administrator']) || isset($user->caps['administrator']) || isset($user->allcaps['administrator'])) {
					$level=qa_lang('users/level_admin');
					$img = 'admin';
				}
				elseif (isset($user->wp_capabilities['moderator']) || isset($user->caps['moderator'])) {
					$level=qa_lang('users/level_moderator');
					$img = 'moderator';
				}
				elseif (isset($user->wp_capabilities['editor']) || isset($user->caps['editor'])) {
					$level=qa_lang('users/level_editor');
					$img = 'editor';
				}
				elseif (isset($user->wp_capabilities['contributor']) || isset($user->caps['contributor'])) {
					$level=qa_lang('users/level_expert');
					$img = 'expert';
				}
				else
					return;
			} 
			else {
				$levelno = qa_db_read_one_value(
					qa_db_query_sub(
						'SELECT level FROM ^users WHERE userid=#',
						$uid
					),
					true
				);
				$level = qa_user_level_string($levelno);
				switch ($level) {
				case ($level == qa_lang('users/level_admin') || $level == qa_lang('users/level_super')):
					return '<span class="qa-who-marker qa-who-marker-admin" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_admin').'</span>';
				case ($level == qa_lang('users/level_moderator')):
					return '<span class="qa-who-marker qa-who-marker-moderator" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_moderator').'</i></span>';
				case ($level == qa_lang('users/level_editor')):
					return '<span class="qa-who-marker qa-who-marker-editor" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_editor').'</span>';
				case ($level == qa_lang('users/level_expert')):
					return '<span class="qa-who-marker qa-who-marker-expert" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_expert').'</span>';
		
				default:
					return null; }
			}

				/*return '<span class="qa-who-marker qa-who-marker-'.$img_admin.'" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_admin').'</span>';
				return '<span class="qa-who-marker qa-who-marker-'.$img_moderator.'" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_moderator').'</span>';
				return '<span class="qa-who-marker qa-who-marker-'.$img_editor.'" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_editor').'</span>';
				return '<span class="qa-who-marker qa-who-marker-'.$img_expert.'" title="'.qa_html($level).'">'.qa_opt('marker_plugin_who_text_expert').'</span>';*/
		}
		function getuserfromhandle($handle) {
			require_once QA_INCLUDE_DIR.'qa-app-users.php';
			
			if (QA_FINAL_EXTERNAL_USERS) {
				$publictouserid=qa_get_userids_from_public(array($handle));
				$userid=@$publictouserid[$handle];
				
			} 
			else {
				$userid = qa_db_read_one_value(
					qa_db_query_sub(
						'SELECT userid FROM ^users WHERE handle = $',
						$handle
					),
					true
				);
			}
			if (!isset($userid)) return;
			return $userid;
		}
	}