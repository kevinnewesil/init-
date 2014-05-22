/**
 * Created by roel on 22-05-14.
 */

$( document ).ready( function() {
    setInterval( function() {
        var date = new Date();

        day     = date.getDate();
        month   = date.getMonth();
        year    = date.getFullYear();
        hours   = date.getHours();
        minutes = date.getMinutes();
        seconds = date.getSeconds();



        $(".date").html(digit( day )  + "-" + digit( month )  + "-" + digit( year ) );
        $(".time").html(digit( hours )  + ":" + digit( minutes )  + ":" + digit( seconds ) );

    }, 1000 );

    $( ".sidebar-left" ).on( "mouseenter", function() {
        $(this).animate({
            "left" : "0%"
        }, 1000, function() {
            $( ".clock" ).css( "display", "none" );
            $( ".times" ).css( "display", "block" );
        });

    });

    $( ".sidebar-left" ).on( "mouseleave", function() {
        $(this).animate({
            "left" : "-2.8%"
        }, 1000, function() {
            $( ".clock" ).css( "display", "block" );
            $( ".times" ).css( "display", "none" );
        });
    });

    $( ".sidebar-left-2" ).on( "click", function() {
        $(".phpinfo").slideToggle("slow");
    });

    $(".close").on("click",function(){
        $(this).parent().css("display","none");
    });

    navigator.geolocation.getCurrentPosition( successCallback, errorCallback);

    function successCallback( position ) {
        lat = position.coords.latitude;
        lon = position.coords.longitude;

        url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" + lat + "," + lon + "&sensor=false";

        $.getJSON( url ).done( function( data ) {
            console.log( data.results);
            $( ".location" ).html( data.results[13].formatted_address );
        }).fail( function( jqxhr, textStatus, error ){
                console.log( "Request failed with error:" + error );
            });
    }

    function errorCallback( error ){
        console.log( "Failed to fetch geo location with error:" + error );
    }

    $( ".sidebar-left-3" ).on( "mouseenter", function() {
        $(this).animate({
            "left" : "0%"
        }, 1000, function() {
            $(".map").css("display","none");
            $(".location").css("display","block");
        });

    });

    $( ".sidebar-left-3" ).on( "mouseleave", function() {
        $(this).animate({
            "left" : "-6.2%"
        }, 1000, function() {
            $(".map").css("display","block");
            $(".location").css("display","none");
        });
    });
});

function digit( digit ) {
    return (digit.toString().length) === 1 ? "0" + digit : digit;
}