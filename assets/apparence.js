console.log('apparence');

(function($){

    wp.customize('header_background', function( value ) {
        value.bind( function( newVal ) {
            $('.navbar').attr('style', 'background-color:' + newVal + '!important');
            console.log('en tête change', newVal);
        } );
    } );

})(jQuery)
