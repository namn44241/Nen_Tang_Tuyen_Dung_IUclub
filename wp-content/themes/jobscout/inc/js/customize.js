( function( api ) {

    // Extends our custom "example-1" section.
    api.sectionConstructor['pro-section'] = api.Section.extend( {

        // No events for this type of section.
        attachEvents: function () {},

        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );

} )( wp.customize );

jQuery(document).ready(function($){
  
    //Scroll to front page section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    });    
    
    /* Home page preview url */
    wp.customize.panel( 'frontpage_settings', function( section ){
        section.expanded.bind( function( isExpanded ) {
            if( isExpanded ){
                wp.customize.previewer.previewUrl.set( jobscout_cdata.home );
            }
        });
    });

    $('body').on('click', '.flush-it', function(event) {
        $.ajax ({
            url     : jobscout_cdata.ajax_url,  
            type    : 'post',
            data    : 'action=flush_local_google_fonts',    
            nonce   : jobscout_cdata.nonce,
            success : function(results){
                //results can be appended in needed
                $( '.flush-it' ).val(jobscout_cdata.flushit);
            },
        });
    });
});

function scrollToSection( section_id ){
    var preview_section_id = "banner-section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ) {

        case 'accordion-section-header_image':
        preview_section_id = "banner-section";
        break;
        
        case 'accordion-section-job_posting_section':
        preview_section_id = "job-posting-section";
        break;
        
        case 'accordion-section-sidebar-widgets-cta':
        preview_section_id = "cta-section";
        break;

        case 'accordion-section-blog_section':
        preview_section_id = "blog-section";
        break;
        
        case 'accordion-section-sidebar-widgets-testimonial':
        preview_section_id = "testimonial-section";
        break;
        
        case 'accordion-section-sidebar-widgets-client':
        preview_section_id = "client-section";
        break;

    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
}