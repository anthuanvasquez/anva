var $ = jQuery.noConflict();

$.fn.inlineStyle = function( prop ) {
    return this.prop( 'style' )[$.camelCase( prop )];
};

$.fn.doOnce = function( func ) {
    this.length && func.apply( this );
    return this;
};

if ( $().infinitescroll ) {

    $.extend( $.infinitescroll.prototype, {
        _setup_portfolioinfiniteitemsloader: function infscr_setup_portfolioinfiniteitemsloader() {
            var opts = this.options,
                instance = this;

            // Bind nextSelector link to retrieve
            $( opts.nextSelector ).click( function( e ) {
                if ( e.which === 1 && ! e.metaKey && ! e.shiftKey ) {
                    e.preventDefault();
                    instance.retrieve();
                }
            });

            // Define loadingStart to never hide pager
            instance.options.loading.start = function( opts ) {
                opts.loading.msg
                    .appendTo( opts.loading.selector )
                    .show( opts.loading.speed, function() {
                        instance.beginAjax( opts );
                    });
            };
        },
        _showdonemsg_portfolioinfiniteitemsloader: function infscr_showdonemsg_portfolioinfiniteitemsloader() {
            var opts = this.options,
                instance = this;
            //Do all the usual stuff
            opts.loading.msg
                .find( 'img' )
                .hide()
                .parent()
                .find( 'div' ).html(opts.loading.finishedMsg).animate({ opacity: 1 }, 2000, function () {
                    $(this).parent().fadeOut( 'normal' );
                });
            //And also hide the navSelector
            $(opts.navSelector).fadeOut( 'normal' );
            // user provided callback when done
            opts.errorCallback.call($(opts.contentSelector)[0],'done' );
        }
    });

} else {
    console.log( 'Infinite Scroll not defined.' );
}

(function() {
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };
    }

    if (!window.cancelAnimationFrame) {
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
    }
}());

function debounce( func, wait, immediate ) {
    var timeout, args, context, timestamp, result;
    return function() {
        context = this;
        args = arguments;
        timestamp = new Date();
        var later = function() {
            var last = (new Date()) - timestamp;
            if (last < wait) {
                timeout = setTimeout(later, wait - last);
            } else {
                timeout = null;
                if (!immediate) {
                    result = func.apply(context, args);
                }
            }
        };
        var callNow = immediate && !timeout;
        if (!timeout) {
            timeout = setTimeout(later, wait);
        }
        if (callNow) {
            result = func.apply(context, args);
        }
        return result;
    };
}

/**
 * Helps with accessibility for keyboard only users.
 */
(function() {
    var isIe = /(trident|msie)/i.test( navigator.userAgent );

    if ( isIe && document.getElementById && window.addEventListener ) {
        window.addEventListener( 'hashchange', function() {
            var id = location.hash.substring( 1 ),
                element;

            if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                return;
            }

            element = document.getElementById( id );

            if ( element ) {
                if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false );
    }
})();

;(function() {

    'use strict';

    function buildUrl( url, parameters ) {
        var qs = '',
            key;

        for ( key in parameters ) {
            if ( parameters.hasOwnProperty( key ) ) {
                var value = parameters[ key ];

                if ( ! value ) {
                    continue;
                }

                value = value.toString().split( '\"' ).join( '"' );
                qs += key + '=' + encodeURIComponent( value ) + '&';
            }
        }

        if ( qs.length > 0 ) {
            qs  = qs.substring( 0, qs.length - 1 );
            url = url + '?' + qs;
        }

        return url;
    }

    function bindButton( network, button ) {
        var url = '';
        switch ( network ) {
            case 'facebook':
                url = buildUrl( 'https://www.facebook.com/sharer.php', {
                    'p[url]': button.getAttribute( 'data-url' )
                });

                button.onclick = function() {
                    var win = window.open( url, '_blank', 'width=500,height=500' );
                    win.focus();
                };

                break;

            case 'twitter':
                url = buildUrl( 'https://twitter.com/intent/tweet', {
                    'text': button.getAttribute( 'data-text' ),
                    'via': button.getAttribute( 'data-via' ),
                    'hashtags': button.getAttribute( 'data-hashtags' )
                });

                button.onclick = function() {
                    var win = window.open( url, '_blank', 'width=500,height=500' );
                    win.focus();
                };

                break;

            case 'pinterest':
                url = buildUrl( 'https://www.pinterest.com/pin/create/button/', {
                    'url': button.getAttribute( 'data-url' ),
                    'media': button.getAttribute( 'data-media' ),
                    'description': button.getAttribute( 'data-description' )
                });
                button.onclick = function() {
                    var win = window.open( url, '_blank', 'width=500,height=500' );
                    win.focus();
                };
                break;

            case 'googleplus':
                url = buildUrl( 'https://plus.google.com/share', {
                    'url': button.getAttribute( 'data-url' ),
                    'media': button.getAttribute( 'data-media' ),
                    'description': button.getAttribute( 'data-description' )
                });
                button.onclick = function() {
                    var win = window.open( url, '_blank', 'width=500,height=500' );
                    win.focus();
                };
                break;

            default:
                break;
        }
    }

    var buttons = document.getElementsByClassName( 'si-share-button' );
    var i = 0;

    for ( i; i < buttons.length; i++ ) {
        var item = buttons[ i ];

        if ( item.hasAttribute( 'data-binded' ) ) {
            continue;
        }

        item.setAttribute( 'data-binded', 'true' );
        bindButton( item.getAttribute( 'data-network' ), item );
    }
})();

