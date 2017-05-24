'use strict';

function nl2br( str, is_xhtml ) {
    var breakTag = ( is_xhtml || typeof is_xhtml === 'undefined' ) ? '<br />' : '<br>';
    return ( str + '' ).replace( /([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2' );
}

jQuery( document ).ready( function( $ ) {

    $( '#shortcode-select' ).on( 'change', function() {
        var shortcodeEle = $( this ).val();
        $( '.anva-shcg-section' ).hide();
        $( '#anva-shcg-' + shortcodeEle ).fadeIn();
    });

    $( '.anva-shcg-codearea' ).on( 'click', function() {
        document.getElementById( $( this ).attr( 'id' ) ).focus();
        document.getElementById( $( this ).attr( 'id' ) ).select();
    });

    $( '.button-shortcode' ).on( 'click', function() {
        var shortcodeEle  = $( this ).data( 'id' ),
            shortcodeGen  = '',
            shortcodeAttr = $( '#' + shortcodeEle + '-attr-option .anva-shcg-attr' ),
            shortcodeCont = $( '#' + shortcodeEle +  '-content' );

        // Init shortcode
        shortcodeGen += '[' + shortcodeEle;

        if ( shortcodeAttr.length > 0 ) {
            shortcodeAttr.each( function() {
                shortcodeGen += ' ' + $( this ).data( 'attr' ) + '="' + $( this ).val() + '"';
            });
        }

        // End shortcode
        shortcodeGen += ']';

        if ( shortcodeCont.length > 0 ) {

            shortcodeGen += shortcodeCont.val() + '[/' + shortcodeEle + ']';
            shortcodeGen += '\n';

            var shortcodeRepeat = $( '#' + shortcodeEle + '-content-repeat' ).val();

            for ( var count = 1; count <= shortcodeRepeat; count = count + 1 ) {
                if ( count < shortcodeRepeat ) {
                    shortcodeGen += '[' + shortcodeEle + ']';
                    shortcodeGen += shortcodeCont.val() + '[/' + shortcodeEle + ']';
                    shortcodeGen += '\n';
                } else {
                    shortcodeGen += '[' + shortcodeEle + '_last]';
                    shortcodeGen += shortcodeCont.val() + '[/' + shortcodeEle + '_last]';
                    shortcodeGen += '\n';
                }
            }
        }

        $( '#' + shortcodeEle + '-code' ).val( shortcodeGen );
    });
});
