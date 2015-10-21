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
        background-color: white;
        height: 25px;
        text-align: center;
        border: 1px solid;
        margin-right: 2px;
    }
    .event_button:hover {
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
    .link {
        font-size: 14px;
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
                                            onDayClick : function( $el, $contentEl, dateProperties ) {

                                                    if( $contentEl.length > 0 ) {
                                                            showEvents( $contentEl, dateProperties );
                                                    }
                                                    <?php if($data["rights"]): ?>
                                                    else {
                                                        date = dateProperties.month + "-" + dateProperties.day + "-" + dateProperties.year;
                                                        window.location.replace("/admin/create_event/" + date);
                                                    }
                                                    <?php endif; ?>


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

                                    <?php if($data["rights"]): ?>
                                        date = dateProperties.year + '.' + dateProperties.month + '.' + dateProperties.day;
                                        $(".ca_container").append("<div class='col-md-2 event_button'><a style='font-size: 14px;padding: 0' href='/admin/delete_event/"+date+"'>Удалить</a></div>" +
                                            "<div class='col-md-3 event_button'><a style='font-size: 14px;padding: 0' href=''>Редактировать</a></div>");
                                    <?php endif; ?>
                                }
                                function hideEvents() {


                                        var $events = $( '#custom-content-reveal' );
                                        if( $events.length > 0 ) {

                                                $events.css( 'top', '100%' );
                                                Modernizr.csstransitions ? $events.on( transEndEventName, function() { $( this ).remove(); } ) : $events.remove();

                                        }

                                }

                        });

                }
        });

</script>
