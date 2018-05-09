'use strict';

( function( $ ) {

    var theme = {

        // --------------------------------------------------
        // Properties
        // --------------------------------------------------

        postReading: $( '#post-reading-wrap' ),
        moreStory: $( '#more-story' ),
        instantSearch: $( '#instantsearch' ),


        // --------------------------------------------------
        // Init Functions
        // --------------------------------------------------

        init: function() {
            theme.thePostReading();
            theme.theMoreStory();
            theme.theInstantSearch();
        },

        // --------------------------------------------------
        // Post Reading Feature
        // --------------------------------------------------

        thePostReading: function() {

            if ( this.postReading.length > 0 ) {

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
                    indicator.css({
                        width: getWidth()
                    });
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
                        this.postReading.addClass( 'visible' );
                    }
                    else {
                        this.postReading.removeClass( 'visible' );
                    }
                });
            }
        },

        // --------------------------------------------------
        // More Stories
        // --------------------------------------------------

        theMoreStory: function() {

            if ( this.moreStory.length > 0 ) {
                $( '#wrapper' ).waypoint(
                    function() {
                        this.moreStory.toggleClass( 'visible' );
                    }, {
                        offset: Waypoint.viewportHeight() - $( '#wrapper' ).height() + 100
                    }
                );

                $( '.more-story-wrap .more-story-close' ).on( 'click', function() {
                    $( this ).parent().css( 'right', '-360px' );
                });
            }
        },

        // --------------------------------------------------
        // Instant Search Feature
        // --------------------------------------------------

        theInstantSearch: function() {

            if ( this.instantSearch.length > 0 ) {
                var searchElement = $( '#s' );
                searchElement.on( 'input', function() {
                    $.ajax({
                        url: AnvaThemeJS.ajaxUrl,
                        type: 'POST',
                        data: 'action=anva_ajax_search&s=' + searchElement.val(),
                        beforeSend: function() {
                            this.instantSearch.addClass( 'loading' );
                            this.instantSearch.html( '' );
                        },
                        success: function( results ) {
                            this.instantSearch.removeClass( 'loading' );
                            if ( '' !== results ) {
                                this.instantSearch.html( results );
                                this.instantSearch.addClass( 'nothidden' );
                                this.instantSearch.removeClass( 'loading' );
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
                    if ( '' !== this.instantSearch.html() ) {
                        this.instantSearch.addClass( 'nothidden' );
                        this.instantSearch.fadeIn();
                    }
                });

                searchElement.blur( function() {
                    this.instantSearch.fadeOut();
                });
            }
        }
    };

    theme.init();

})( jQuery );
