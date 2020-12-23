/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
    
    wp.customize( 'theme_background_color', function( value ) {
		value.bind( function( to ) {
			$('body').css('background-color', to );
		} );
	} );
    wp.customize( 'theme_text_color', function( value ) {
		value.bind( function( to ) {
			$('body p').css('color', to );
		} );
	} );
    wp.customize( 'theme_link_color', function( value ) {
		value.bind( function( to ) {
			$('body a').css('color', to );
		} );
	} );
    wp.customize( 'theme_link_hover_color', function( value ) {
		value.bind( function( to ) {
			$('body a:hover, body a:focus, body a:active').css('color', to );
		} );
	} );
    
    //------ Footer ------//
    
    wp.customize( 'header_footer_background_color', function( value ) {
		value.bind( function( to ) {
			$('#site-footer').css('background-color', to );
		} );
	} );
    
    // Copyright text
    wp.customize('kaspweb_footer_copyright_text', function( value ) {
        value.bind( function( newval ) {
            $( '#copyright' ).html( newval );
        });
    });
    

    // Footer bottom visibility
    wp.customize('kaspweb_bottom_footer_visibility', function( value ) {
        value.bind( function( newval ) {
            var footerBottom = $( '#footer-bottom' );
            if ( footerBottom.length ) {
                $.each( visibility, function( i, v ) {
                    footerBottom.removeClass( v );
                });
                footerBottom.addClass( newval );
            }
        });
    });
    
    // Kaspweb Bottom Footer Background
    wp.customize( 'kaspweb_bottom_footer_background', function( value ) {
		value.bind( function( to ) {
			$('#footer-bottom').css('background-color', to );
		} );
	} );
    
    // Kaspweb Bottom Footer Color
    wp.customize( 'kaspweb_bottom_footer_background', function( value ) {
		value.bind( function( to ) {
			$('#footer-bottom').css('color', to );
		} );
	} );
    
    // Kaspweb Bottom Footer Padding Top
    wp.customize( 'kaspweb_bottom_footer_top_padding', function( value ) {
		value.bind( function( to ) {
			$('#footer-bottom').css('padding-top', to );
		} );
	} );
    
    // Kaspweb Bottom Footer Padding Bottom
    wp.customize( 'kaspweb_bottom_footer_bottom_padding', function( value ) {
		value.bind( function( to ) {
			$('#footer-bottom').css('padding-bottom', to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
} )( jQuery );