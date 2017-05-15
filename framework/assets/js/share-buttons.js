;(function( $ ) {

    "use strict";

    function buildUrl(url, parameters) {
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
            qs  = qs.substring( 0, qs.length - 1 ); // chop off last "&"
            url = url + '?' + qs;
        }

        return url;
    }

    function bindButton( network, button ) {
        var url = '';
        switch ( network ) {
            case 'facebook':
                url = buildUrl( 'http://www.facebook.com/sharer.php', {
                    'p[url]': button.getAttribute( 'data-url' )
                });

                button.onclick = function() {
                    var win = window.open( url, '_blank' );
                    win.focus();
                };

                break;

            case 'twitter':
                url = buildUrl( 'http://twitter.com/intent/tweet', {
                    'text': button.getAttribute( 'data-text' ),
                    'via': button.getAttribute( 'data-via' ),
                    'hashtags': button.getAttribute('data-hashtags')
                });

                button.onclick = function() {
                    var win = window.open( url, '_blank' );
                    win.focus();
                };

                break;

            case 'pinterest':
                url = buildUrl('http://www.pinterest.com/pin/create/button/', {
                    'url': button.getAttribute('data-url'),
                    'media': button.getAttribute('data-media'),
                    'description': button.getAttribute('data-description')
                });
                button.onclick = function() {
                    var win = window.open(url, '_blank');
                    win.focus();
                };
                break;

            case 'googleplus':
                url = buildUrl('https://plus.google.com/share', {
                    'url': button.getAttribute('data-url'),
                    'media': button.getAttribute('data-media'),
                    'description': button.getAttribute('data-description')
                });
                button.onclick = function() {
                    var win = window.open(url, '_blank');
                    win.focus();
                };
                break;

            default:
                break;
        }
    }

    var buttons = document.getElementsByClassName('si-share-button');

    for ( var i = 0; i < buttons.length; i++ ) {
        var item = buttons[ i ];

        if ( item.hasAttribute( 'data-binded' ) ) {
            continue;
        }

        item.setAttribute( 'data-binded', 'true' );
        bindButton( item.getAttribute( 'data-network' ), item );
    }
})( jQuery );
