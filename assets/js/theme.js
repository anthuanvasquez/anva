;(function( $ ) {

    'use strict';

    // --------------------------------------------------
    // Post Reading Feature
    // --------------------------------------------------

    var postReading = $( '#post-reading-wrap' );

    if ( postReading.length > 0 ) {

        var indicator = $( '.post-reading-indicator-bar' ),
            value     = 0,
            width     = 0,
            max       = 0;

        var getMax = function() {
            return $( document ).height() - $( window ).height();
        };

        var getValue = function() {
            return $( window ).scrollTop();
        };

        var getWidth = function() {
            value = getValue();
            width = ( value / max ) * 100 + '%';
            return width;
        };

        var setWidth = function() {
            max = getMax();
            indicator.css({ width: getWidth() });
        };

        $( document ).on( 'scroll', setWidth );
        $( window ).on( 'resize', function() {
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
    // More Stories
    // --------------------------------------------------

    var moreStory = $( '#more-story' );

    if ( moreStory.length > 0 ) {
        $( '#wrapper' ).waypoint(
            function( direction ) {
                moreStory.toggleClass( 'visible' );
            }, {
                offset: Waypoint.viewportHeight() - $( '#wrapper' ).height() + 100
            }
        );

        $( '.more-story-wrap .more-story-close' ).on( 'click', function() {
            $( this ).parent().css( 'right', '-360px' );
        });
    }

    // --------------------------------------------------
    // Instant Search Feature
    // --------------------------------------------------

    var instantSearch = $( '#instantsearch' ),
        searchElement = $( '#s' );
    if ( instantSearch.length > 0 ) {
        searchElement.on( 'input', function() {
            $.ajax({
                url: AnvaThemeJS.ajaxUrl,
                type: 'POST',
                data: 'action=anva_ajax_search&s=' + searchElement.val(),
                beforeSend: function() {
                    instantSearch.addClass( 'loading' );
                    instantSearch.html('');
                },
                success: function( results ) {
                    instantSearch.removeClass( 'loading' );
                    if ( '' !== results ) {
                        instantSearch.html( results );
                        instantSearch.addClass( 'nothidden' );
                        instantSearch.removeClass( 'loading' );
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
            if ( '' !== instantSearch.html() ) {
                instantSearch.addClass( 'nothidden' );
                instantSearch.fadeIn();
            }
        });

        searchElement.blur( function() {
            instantSearch.fadeOut();
        });
    }

})( jQuery );
