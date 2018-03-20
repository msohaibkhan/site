<?php  if( function_exists('get_field') && get_field('video_type') && ( ( get_field('video_type')=='external' && get_field('external_video_url') ) || ( get_field('video_type')=='self' && get_field('self_hosted_video') ) || ( get_field('video_type')=='remote' && get_field('mp4_file_url') ) || ( get_field('video_type')=='custom' && get_field('custom_embed_code') ) ) ):
	?>
	<div class="videotrailer-course embed-responsive embed-responsive-<?php echo (get_field('aspect_ratio') ? get_field('aspect_ratio') : '16by9'); ?>">
		<?php switch (get_field('video_type')):
			case 'external':
				if (get_field('external_video_url')):
					echo wp_oembed_get( get_field('external_video_url') );
				endif;
				break;
			case 'self':
				if (get_field('self_hosted_video')):
					$att = explode('/', get_field('self_hosted_video')['mime_type']);
					if ($att[0]=='video'):
						echo wp_video_shortcode(array('src'=>get_field('self_hosted_video')['url']));
					elseif ($att[0]=='audio'):
						echo wp_audio_shortcode(array('src'=>get_field('self_hosted_video')['url']));
					endif;
				endif;
				break;
			case 'remote':
				if (get_field('mp4_file_url')):
					$type = wp_check_filetype(get_field('mp4_file_url'));
					$att = explode('/', $type['type']);
					if ($att[0]=='video'):
						echo wp_video_shortcode(array('src'=>get_field('mp4_file_url')));
					elseif ($att[0]=='audio'):
						echo wp_audio_shortcode(array('src'=>get_field('mp4_file_url')));
					endif;
				endif;
				break;
			case 'custom':
				if (get_field('custom_embed_code')):
					echo get_field('custom_embed_code');
				endif;
				break;
		endswitch; ?>
	</div>
<?php endif; ?>