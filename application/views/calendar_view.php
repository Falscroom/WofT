<style>
    .ca_container {
        margin-top: -29px;
        height: 25px;
        /*background-color: red;*/
    }
    .select_container {
        margin-right: 2px;
        padding: 0;
    }
    .event_button {
        cursor: pointer;
        background-color: white;
        height: 25px;
        text-align: center;
        border: 1px solid;
        margin-right: 2px;
    }
    .event_button:hover {
        overflow: hidden;
        border-color: dodgerblue;
    }
    .select {
        padding: 0;
        height: 25px;
        font-size: 14px;
        border-radius: 0;
    }
    .select:focus {
        box-shadow: none;
    }
    #link {
        color: black;
        padding: 0;
        font-size: 14px;
    }
    #link:hover {
        text-decoration: none;
    }
    .event > .ev_professor,.event > .ev_group {
        padding: 0;
        text-align: left;
        font-size: 16px;
    }
</style>
<div class="container">
        <section class="main">
                <div class="custom-calendar-wrap">
                        <div id="custom-inner" class="custom-inner">
                                <div class="custom-header clearfix"> <!-- шапка -->
                                        <nav> <!-- стрелочки влево вправо -->
                                                <span id="custom-prev" class="custom-prev"></span>
                                                <span id="custom-next" class="custom-next"></span>
                                        </nav>
                                        <h2 id="custom-month" class="custom-month"></h2> <!-- месяц в шапке -->
                                        <h3 id="custom-year" class="custom-year"></h3> <!-- год в шапке -->
                                </div>
                                <div id="calendar" class="fc-calendar-container"></div> <!-- тело календаря -->
                        </div>
                </div>
        </section>
</div>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.calendario.js"></script>

<script type="text/javascript">
        $.ajax({
                url: "/calendar/date",
                success: function(codropsEvents){
                    console.log(codropsEvents);
                        $(function() {
                                var transEndEventNames = {
                                            'WebkitTransition' : 'webkitTransitionEnd',
                                            'MozTransition' : 'transitionend',
                                            'OTransition' : 'oTransitionEnd',
                                            'msTransition' : 'MSTransitionEnd',
                                            'transition' : 'transitionend'
                                    },
                                    transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
                                    $wrapper = $( '#custom-inner' ),
                                    $calendar = $( '#calendar' ),
                                    cal = $calendar.calendario( {
                                            onDayClick : function( $el, $contentEl, dateProperties, rights ) {

                                                    if( $contentEl.length > 0 ) {
                                                            showEvents( $contentEl, dateProperties );
                                                    }
                                                    else if(rights) {
                                                        date = dateProperties.month + "-" + dateProperties.day + "-" + dateProperties.year;
                                                        window.location.replace("/admin/create_event/" + date);
                                                    }


                                            },
                                            caldata : codropsEvents,
                                            displayWeekAbbr : true
                                    } ),
                                    $month = $( '#custom-month' ).html( cal.getMonthName() ),
                                    $year = $( '#custom-year' ).html( cal.getYear() );

                                $( '#custom-next' ).on( 'click', function() {
                                        cal.gotoNextMonth( updateMonthYear );
                                } );
                                $( '#custom-prev' ).on( 'click', function() {
                                        cal.gotoPreviousMonth( updateMonthYear );
                                } );

                                function updateMonthYear() {
                                        $month.html( cal.getMonthName() );
                                        $year.html( cal.getYear() );
                                }

                                function showEvents( $contentEl, dateProperties ) {
                                        hideEvents();

                                        var $events = $( '<div id="custom-content-reveal" class="custom-content-reveal"><h4>Событие на ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4>' +
                                                '<div class="ca_container"></div></div>' ),
                                            $close = $( '<span class="custom-content-close"></span>' ).on( 'click', hideEvents );

                                        $events.append( $contentEl.html() , $close ).insertAfter( $wrapper );

                                        setTimeout( function() {
                                                $events.css( 'top', '0%' );
                                        }, 25 );

                                    $.getScript("js/several_events.js");

                                    $.ajax({
                                        url: "/admin/get_rights",
                                        success: function(rights){
                                            if(rights) {
                                                delete_button = $("<div class='col-md-2 event_button'><a id='link' >Удалить</a></div>");
                                                delete_button.bind("click",function() {
                                                    $.ajax({
                                                        url: "/admin/delete_event/" + $(".custom-content-reveal").find("span.event").data()['id'],
                                                        success: function() {
                                                            window.location.replace("/calendar");
                                                        }
                                                    });
                                                });
                                                update_button = $("<div class='col-md-3 event_button'><a id='link' >Редактировать</a></div>");
                                                update_button.bind("click",function() {
                                                    window.location.replace("/admin/update_event/" + $(".custom-content-reveal").find("span.event").data()['id']);
                                                });
                                                $(".ca_container").append(delete_button,update_button);
                                            }
                                        }});
                                }
                                function hideEvents() {


                                        var $events = $( '#custom-content-reveal' );
                                        if( $events.length > 0 ) {

                                                $events.css( 'top', '100%' );
                                            $events.animate({'height':0},500,function() {
                                                $events.remove();
                                            });

                                        }

                                }

                        });

                }
        });

</script>
