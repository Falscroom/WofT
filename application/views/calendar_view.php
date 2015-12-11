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
        border-radius: 4px;
    }
    .event_button:hover {
        overflow: hidden;
        border-color: dodgerblue;
    }
    .select {
        border: 1px solid;
        padding: 0;
        height: 25px;
        font-size: 14px;
        border-radius: 4px;
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
    .event > .ev_professor,.event > .ev_group,#group,#professor {
        padding: 0;
        text-align: left;
        font-size: 16px;
    }
    #group,#professor {
        display: inline;
    }
    .menu {
        position: absolute;
        border: 1px solid grey;
        background-color: white;
        padding: 5px 0 5px 0;
    }
    .menu > span {
        font-size: 12px;
        cursor: context-menu;
        padding: 0 10px 0 10px;
        display: block;
    }
    .menu > span:hover {
        background-color: #2a6496;
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
<script type="text/javascript" src="js/jquery.calendario.js"></script>

<script type="text/javascript">


    function Menu() {
        this.init = function(menu_class) {
            this.element = $("<div class='" + menu_class + " menu" + "' oncontextmenu='return false'></div>");
        };
        this.get = function() {
            return this.element;
        };
        this.draw = function(x,y) {

            this.x = x;
            this.y = y;

            this.element.css({
                "left": x + "px",
                "top": y + "px",
                "display": "block"
            });
            $("body").append(this.element);
        };
        this.hide = function() {
            this.element.css({
                "display": "none"
            });
        };
        this.count = function() {
            return this.element.find("span").length;
        };
        this.width = function() {
            return this.element.width();
        };
        this.span_height = function() {
            return this.element.find("span:first").height();
        };

    }

    main_menu = new Menu();
    main_menu.init('main_menu');

    child_menu = new Menu();
    child_menu.init('child_menu');


    $("body").bind("click",function(){
        main_menu.hide();
    });
/*    function get_Menu(event) {
        element = $('.menu');
        if(element.length == 0) {
            menu = $("<div class='menu' oncontextmenu='return false'></div>");
            x = event.pageX;
            y = event.pageY;
            menu.css({
                "left": x + "px",
                "top": y + "px"
            });
            /!*        menu.append("<span>Delete</span>");
             menu.append("<span>Create</span>");*!/
            $("body").append(menu);
            return menu;
        }
        else {
            return element;
        }
    }*/

    /// RIGHTS
    const U_EDIT = 1 << 1;
    /// RIGHTS
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
                                            onDayClick : function( $el, $contentEl, dateProperties, rights, event ) {
                                                events = $contentEl.find(".event");
                                                if(event.button == 2) {
                                                    if (rights & U_EDIT) {
                                                        url = "/admin/create_event/" + dateProperties.month + "-" + dateProperties.day + "-" + dateProperties.year;
                                                        if (main_menu.count() < 1)
                                                            main_menu.element = main_menu.get().append("<span onclick='(function(){ window.location.replace(url); }())'>Добавить новое</span>");
                                                        main_menu.draw(event.pageX, event.pageY);
                                                        if (main_menu.count() < 2) {

                                                            span = $("<span>Удалить текущее</span>").bind("mouseover", function() {

                                                                child_menu.draw(main_menu.x + main_menu.width() + 1,main_menu.y + main_menu.span_height() + 6);

                                                                events.each(function(item,element) {
                                                                    span = $("<span>"+$(element).find("#group").text()+ " | " + $(element).find("#professor").text() + "</span>")
                                                                        .bind("click", function() {
                                                                            $.ajax({
                                                                                url: "/admin/delete_event/" + $(element).data()["id"],
                                                                                success: function() {
                                                                                    window.location.replace("/calendar");
                                                                                }
                                                                            });
                                                                        });
                                                                    child_menu.element = child_menu.get().append(span);
                                                                });


                                                            });
                                                            main_menu.element = main_menu.get().append(span);
                                                        }
                                                    }
                                                  /*  events = $contentEl.find(".event");
                                                    if (rights & U_EDIT) {
                                                        url = "/admin/create_event/" + dateProperties.month + "-" + dateProperties.day + "-" + dateProperties.year;
                                                        event_create = $('<span onclick="(function() { window.location.replace(url); }())">Создать новое</span>');
                                                        get_menu(event).append(event_create);
                                                    }
                                                    if(events.length > 0) {

                                                        /!*event_update = $('<span>Обновить текущее</span>').bind('mouseover' , function(event){
                                                            events = $contentEl.find(".event");
                                                            if(events.length > 1) {
                                                                alert(1);
                                                            }
                                                        });*!/
                                                        event_delete = $('<span>Удалить текущее</span>').bind('mouseover' , function(event){
                                                            child_menu = $("<div class='menu child_menu'><span> 1 </span></div>");
                                                            x = get_menu(null).css("left");
                                                            x = x.substr(0, x.length - 2);
                                                            y = get_menu(null).css("top");
                                                            y = y.substr(0, y.length - 2);
                                                            alert(y);

                                                            shift = $(".menu").find("span:first").height();
                                                            alert(shift);

                                                            child_menu.css({
                                                                "top": y + "px",
                                                                "left":x + "px"
                                                            });
                                                            $("body").append(child_menu);



                                                            events.each(function(item,element) {
                                                                console.log($(element).data()["id"]);
                                                            });
                                                  /!*          $.ajax({
                                                                url: "/admin/delete_event/" + events.find("span.event").data()['id'],
                                                                success: function() {
                                                                    window.location.replace("/calendar");
                                                                }
                                                            });*!/
                                                        });
                                                        get_menu(event).append(event_delete);*/
                                                  /*  }*/




                                                       /* if( $contentEl.length > 0 ) {

                                                            event_update = $('<span>Обновить текущее</span>').bind('mouseover' , function(event){
                                                                events = $contentEl.find(".event");
                                                                if(events.length > 1) {
                                                                    alert(1);
                                                                }
                                                            });
                                                            get_menu(event).append(event_update);

                                                            event_delete = $('<span>Удалить текущее</span>').bind('click' , function(event){
                                                                event.stopPropagation();
                                                                $.ajax({
                                                                    url: "/admin/delete_event/" + $(".custom-content-reveal").find("span.event").data()['id'],
                                                                    success: function() {
                                                                        window.location.replace("/calendar");
                                                                    }
                                                                });
                                                            });
                                                            get_menu(event).append(event_delete);
                                                        }*/
                                                    }
                                                    else
                                                        if( $contentEl.length > 0 ) {
                                                                showEvents( $contentEl, dateProperties );
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

                                    journal_button = $("<div class='col-md-3 event_button'><a id='link' >Журнал</a></div>");
                                    journal_button.bind("click",function() {
                                        window.location.replace("/book/fromCalendar/" + $(".custom-content-reveal").find("span.event").data()['id']);
                                    });
                                    $(".ca_container").append(journal_button);

                                    $.ajax({
                                        url: "/admin/get_rights",
                                        success: function(rights){
                                            if(rights & U_EDIT) {
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
