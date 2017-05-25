jQuery( document ).ready( function( $ ) {

    'use strict';

    var AnvaShortcodes = {

        init: function() {
            var shortcodeEle = $( '#shortcode-select' );

            AnvaShortcodes.checkCurrent( shortcodeEle );

            shortcodeEle.change( function() {
                AnvaShortcodes.checkCurrent( $( this ) );
            });

            AnvaShortcodes.showHide();
        },

        checkCurrent: function( target ) {
            var shortcodeEle = $( '#anva-shcg-' + target.val() ),
                shortcodeSec = $( '.anva-shcg-section' );
            shortcodeSec.removeClass( 'active' );
            shortcodeEle.addClass( 'active' );
            setTimeout(function() {
                shortcodeEle.find( 'button' ).trigger( 'click' );
            }, 50);
        },

        showHide: function() {
            $( '.button-shortcode' ).click( function() {
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
                $( '#' + shortcodeEle + '-code' ).html( shortcodeGen );

                return false;
            });
        }
    };

    AnvaShortcodes.init();
});
