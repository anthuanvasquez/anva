(function( $ ) {

    'use strict';

    // --------------------------------------------------
    // Post Reading
    // --------------------------------------------------

    var postReading   = $( '#post-reading-wrap' ),
        instantSearch = $( '#instantsearch' ),
        searchElement = $( '#s' );

    function getMax() {
        return $( document ).height() - $( window ).height();
    }

    function getValue() {
        return $( window ).scrollTop();
    }

    if ( postReading.length > 0 ) {

        var indicator = $( '.post-reading-indicator-bar' ),
            max       = getMax(),
            value     = 0,
            width     = 0;

        // Calculate width in percentage
        function getWidth() {
            value = getValue();
            width = ( value / max ) * 100 + '%';
            return width;
        }

        // Set the width to indicator
        function setWidth() {
            max = getMax();
            indicator.css({ width: getWidth() });
        }

        $( document ).on( 'scroll', setWidth );
        $( window ).on( 'resize', function() {

            // Need to reset the Max attr
            max = getMax();
            setWidth();
        });

        $( document ).on( 'scroll', function() {
            var width      = $( '.post-reading-indicator-bar' ).width(),
                percentage = ( width / max ) * 100;

            if ( percentage > 10 ) {
                postReading.addClass( 'visible' );
            } else {
                postReading.removeClass( 'visible' );
            }
        });
    }

    // --------------------------------------------------
    // Instant Search Extension
    // --------------------------------------------------

    if ( instantSearch.length > 0 ) {
        searchElement.on( 'input', function() {
            $.ajax({
                url: ANVA_VARS.ajaxUrl,
                type: 'POST',
                data: 'action=anva_ajax_search&s=' + searchElement.val(),
                success: function( results ) {
                    instantSearch.html( results );

                    if ( '' !== results ) {
                        instantSearch.addClass( 'nothidden' );
                        instantSearch.show();
                    } else {
                        instantSearch.hide();
                    }
                }
            });
        });

        searchElement.keypress( function( e ) {
            if ( 13 === e.which ) {
                e.preventDefault();
                $( 'form#searchform' ).submit();
            }
        });

        searchElement.focus( function() {
            if (  '' !== instantSearch.html() ) {
                instantSearch.addClass( 'nothidden' );
                instantSearch.fadeIn();
            }
        });

        searchElement.blur( function() {
            instantSearch.fadeOut();
        });
    }

})( jQuery );
