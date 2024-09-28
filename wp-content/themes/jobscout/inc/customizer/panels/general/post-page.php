<?php
/**
 * Post Page Settings
 *
 * @package jobscout
 */

if ( ! function_exists( 'jobscout_customize_register_general_post_page' ) ) :

    function jobscout_customize_register_general_post_page( $wp_customize ) {
        
        /** Posts(Blog) & Pages Settings */
        $wp_customize->add_section(
            'post_page_settings',
            array(
                'title'    => __( 'Posts(Blog) & Pages Settings', 'jobscout' ),
                'priority' => 35,
                'panel'    => 'general_settings',
            )
        );
        
        /** Prefix Archive Page */
        $wp_customize->add_setting( 
            'ed_prefix_archive', 
            array(
                'default'           => false,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_prefix_archive',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Hide Prefix in Archive Page', 'jobscout' ),
                    'description' => __( 'Enable to hide prefix in archive page.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Blog Excerpt */
        $wp_customize->add_setting( 
            'ed_excerpt', 
            array(
                'default'           => true,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_excerpt',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Enable Blog Excerpt', 'jobscout' ),
                    'description' => __( 'Enable to show excerpt or disable to show full post content.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Excerpt Length */
        $wp_customize->add_setting( 
            'excerpt_length', 
            array(
                'default'           => 25,
                'sanitize_callback' => 'jobscout_sanitize_number_absint'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Slider_Control( 
    			$wp_customize,
    			'excerpt_length',
    			array(
    				'section'	  => 'post_page_settings',
    				'label'		  => __( 'Excerpt Length', 'jobscout' ),
    				'description' => __( 'Automatically generated excerpt length (in words).', 'jobscout' ),
                    'choices'	  => array(
    					'min' 	=> 10,
    					'max' 	=> 100,
    					'step'	=> 5,
    				)                 
    			)
    		)
    	);
        
        /** Read More Text */
        $wp_customize->add_setting(
            'read_more_text',
            array(
                'default'           => __( 'Read More', 'jobscout' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage' 
            )
        );
        
        $wp_customize->add_control(
            'read_more_text',
            array(
                'type'    => 'text',
                'section' => 'post_page_settings',
                'label'   => __( 'Read More Text', 'jobscout' ),
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'read_more_text', array(
            'selector' => '.entry-footer .btn-readmore',
            'render_callback' => 'jobscout_get_read_more',
        ) );
        
        /** Note */
        $wp_customize->add_setting(
            'post_note_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new JobScout_Note_Control( 
    			$wp_customize,
    			'post_note_text',
        			array(
        				'section'	  => 'post_page_settings',
                        'description' => sprintf( __( '%s These options affect your individual posts.', 'jobscout' ), '<hr/>' ),
        			)
    		)
        );
        
        /** Hide Author Section */
        $wp_customize->add_setting( 
            'ed_author', 
            array(
                'default'           => false,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_author',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Hide Author Section', 'jobscout' ),
                    'description' => __( 'Enable to hide author section.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Author Section title */
        $wp_customize->add_setting(
            'author_title',
            array(
                'default'           => __( 'About Author', 'jobscout' ),
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage' 
            )
        );
        
        $wp_customize->add_control(
            'author_title',
            array(
                'type'            => 'text',
                'section'         => 'post_page_settings',
                'label'           => __( 'Author Section Title', 'jobscout' ),
                'active_callback' => 'jobscout_post_page_ac'
            )
        );
        
        $wp_customize->selective_refresh->add_partial( 'author_title', array(
            'selector' => '.author-section .title',
            'render_callback' => 'jobscout_get_author_title',
        ) );
    
        
        /** Comments */
        $wp_customize->add_setting(
            'ed_comments',
            array(
                'default'           => true,
                'sanitize_callback' => 'jobscout_sanitize_checkbox',
            )
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_comments',
    			array(
    				'section'     => 'post_page_settings',
    				'label'       => __( 'Show Comments', 'jobscout' ),
                    'description' => __( 'Enable to show Comments in Single Post/Page.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Hide Category */
        $wp_customize->add_setting( 
            'ed_category', 
            array(
                'default'           => false,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_category',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Hide Category', 'jobscout' ),
                    'description' => __( 'Enable to hide category.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Hide Post Author */
        $wp_customize->add_setting( 
            'ed_post_author', 
            array(
                'default'           => false,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_post_author',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Hide Post Author', 'jobscout' ),
                    'description' => __( 'Enable to hide post author.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Hide Posted Date */
        $wp_customize->add_setting( 
            'ed_post_date', 
            array(
                'default'           => false,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_post_date',
    			array(
    				'section'     => 'post_page_settings',
    				'label'	      => __( 'Hide Posted Date', 'jobscout' ),
                    'description' => __( 'Enable to hide posted date.', 'jobscout' ),
    			)
    		)
    	);
        
        /** Show Featured Image */
        $wp_customize->add_setting( 
            'ed_featured_image', 
            array(
                'default'           => true,
                'sanitize_callback' => 'jobscout_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new JobScout_Toggle_Control( 
    			$wp_customize,
    			'ed_featured_image',
    			array(
    				'section'         => 'post_page_settings',
    				'label'	          => __( 'Show Featured Image', 'jobscout' ),
                    'description'     => __( 'Enable to show featured image in post detail (single post).', 'jobscout' ),
                    'active_callback' => 'jobscout_post_page_ac'
    			)
    		)
    	);
        /** Posts(Blog) & Pages Settings Ends */
        
    }
endif;
add_action( 'customize_register', 'jobscout_customize_register_general_post_page' );