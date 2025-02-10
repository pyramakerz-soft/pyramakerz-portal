<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    {{-- calendar --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>


<body class="body__wrapper">

    @include('include.preload')


    <main class="main_wrapper overflow-hidden">
        @include('include.nav')


        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->
        <!-- breadcrumbarea__section__start -->



        <!-- dashboardarea__area__start  -->
        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')

                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>Summary</h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__1.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">27</span>+

                                                    </div>
                                                    <p>Enrolled Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__2.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">08</span>+

                                                    </div>
                                                    <p>Complete Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__3.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">12</span>

                                                    </div>
                                                    <p>Complete Lessons</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- calendar --}}
                            <div class="mobile-header z-depth-1">

                                <div class="row">
                                    <div class="col-2">
                                        <a href="#" data-activates="sidebar" class="button-collapse"
                                            style="">
                                            <i class="material-icons">menu</i>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <h4>Events</h4>
                                    </div>
                                </div>

                            </div>

                            <div class="main-wrapper">

                                <div class="sidebar-wrapper z-depth-2  fixed" id="sidebar">

                                    <div class="sidebar-title">
                                        <h4>Events</h4>
                                        <h5 id="eventDayName">Date</h5>
                                    </div>
                                    <div class="sidebar-events" id="sidebarEvents">
                                        <div class="empty-message">Sorry, no events to selected date</div>
                                    </div>

                                </div>

                                <div class="content-wrapper lighten-3">


                                    <div class="calendar-wrapper z-depth-2">

                                        <div class="header-background">
                                            <div class="calendar-header">

                                                <a class="prev-button" id="prev">
                                                    <i class="material-icons">keyboard_arrow_left</i>
                                                </a>
                                                <a class="next-button" id="next">
                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                </a>

                                                <div class="row header-title">

                                                    <div class="header-text">
                                                        <h3 id="month-name">February</h3>
                                                        <h5 id="todayDayName">Today is Friday 7 Feb</h5>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="calendar-content">
                                            <div id="calendar-table" class="calendar-cells">

                                                <div id="table-header">
                                                    <div class="row">
                                                        <div class="col">Mon</div>
                                                        <div class="col">Tue</div>
                                                        <div class="col">Wed</div>
                                                        <div class="col">Thu</div>
                                                        <div class="col">Fri</div>
                                                        <div class="col">Sat</div>
                                                        <div class="col">Sun</div>
                                                    </div>
                                                </div>

                                                <div id="table-body" class="">

                                                </div>

                                            </div>
                                        </div>

                                        <div class="calendar-footer">
                                            <div class="emptyForm" id="emptyForm">
                                                <h4 id="emptyFormTitle">No events now</h4>
                                                <a class="addEvent" id="changeFormButton">Add new</a>
                                            </div>
                                            <div class="addForm" id="addForm">
                                                <h4>Add new event</h4>

                                                <div class="row">
                                                    <div class="input-field col ">
                                                        <input id="eventTitleInput" type="text" class="validate">
                                                        <label for="eventTitleInput">Title</label>
                                                    </div>
                                                    <div class="input-field col s6">
                                                        <input id="eventDescInput" type="text" class="validate">
                                                        <label for="eventDescInput">Description</label>
                                                    </div>
                                                </div>

                                                <div class="addEventButtons">
                                                    <a class="waves-effect waves-light btn  "
                                                        id="addEventButton">Add</a>
                                                    <a class="waves-effect waves-light btn " id="cancelAdd">Cancel</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </div>



                        </div>


                    </div>
                </div>
            </div>

        </div>
        <!-- dashboardarea__area__end   -->

        <!-- footer__section__start -->
        @include('include.footer')
        <!-- footer__section__end -->


    </main>


    <!-- JS here -->
    <script src="../js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/jquery.meanmenu.min.js"></script>
    <script src="../js/ajax-form.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/jquery.scrollUp.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/swiper-bundle.min.js"></script>
    <script src="../js/main.js"></script>
    {{-- calendar --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    {{-- <script>
        $(".button-collapse").sideNav();
    </script> --}}
    <script>
        var calendar = document.getElementById("calendar-table");
        var gridTable = document.getElementById("table-body");
        var currentDate = new Date();
        var selectedDate = currentDate;
        var selectedDayBlock = null;
        var globalEventObj = {};

        var sidebar = document.getElementById("sidebar");

        function createCalendar(date, side) {
            var currentDate = date;
            var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

            var monthTitle = document.getElementById("month-name");
            var monthName = currentDate.toLocaleString("en-US", {
                month: "long"
            });
            var yearNum = currentDate.toLocaleString("en-US", {
                year: "numeric"
            });
            monthTitle.innerHTML = `${monthName} ${yearNum}`;

            if (side == "left") {
                gridTable.className = "animated fadeOutRight";
            } else {
                gridTable.className = "animated fadeOutLeft";
            }

            setTimeout(() => {
                gridTable.innerHTML = "";

                var newTr = document.createElement("div");
                newTr.className = "row";
                var currentTr = gridTable.appendChild(newTr);

                for (let i = 1; i < (startDate.getDay() || 7); i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                lastDay = lastDay.getDate();

                for (let i = 1; i <= lastDay; i++) {
                    if (currentTr.children.length >= 7) {
                        currentTr = gridTable.appendChild(addNewRow());
                    }
                    let currentDay = document.createElement("div");
                    currentDay.className = "col";
                    if (selectedDayBlock == null && i == currentDate.getDate() || selectedDate.toDateString() ==
                        new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()) {
                        selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);

                        document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
                            month: "long",
                            day: "numeric",
                            year: "numeric"
                        });

                        selectedDayBlock = currentDay;
                        setTimeout(() => {
                            currentDay.classList.add("orange");
                            currentDay.classList.add("lighten-3");
                        }, 900);
                    }
                    currentDay.innerHTML = i;

                    //show marks
                    if (globalEventObj[new Date(currentDate.getFullYear(), currentDate.getMonth(), i)
                            .toDateString()]) {
                        let eventMark = document.createElement("div");
                        eventMark.className = "day-mark";
                        currentDay.appendChild(eventMark);
                    }

                    currentTr.appendChild(currentDay);
                }

                for (let i = currentTr.getElementsByTagName("div").length; i < 7; i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                if (side == "left") {
                    gridTable.className = "animated fadeInLeft";
                } else {
                    gridTable.className = "animated fadeInRight";
                }

                function addNewRow() {
                    let node = document.createElement("div");
                    node.className = "row";
                    return node;
                }

            }, !side ? 0 : 270);
        }

        createCalendar(currentDate);

        var todayDayName = document.getElementById("todayDayName");
        todayDayName.innerHTML = "Today is " + currentDate.toLocaleString("en-US", {
            weekday: "long",
            day: "numeric",
            month: "short"
        });

        var prevButton = document.getElementById("prev");
        var nextButton = document.getElementById("next");

        prevButton.onclick = function changeMonthPrev() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1);
            createCalendar(currentDate, "left");
        }
        nextButton.onclick = function changeMonthNext() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1);
            createCalendar(currentDate, "right");
        }

        function addEvent(title, desc) {
            if (!globalEventObj[selectedDate.toDateString()]) {
                globalEventObj[selectedDate.toDateString()] = {};
            }
            globalEventObj[selectedDate.toDateString()][title] = desc;
        }

        function showEvents() {
            let sidebarEvents = document.getElementById("sidebarEvents");
            let objWithDate = globalEventObj[selectedDate.toDateString()];

            sidebarEvents.innerHTML = "";

            if (objWithDate) {
                let eventsCount = 0;
                for (key in globalEventObj[selectedDate.toDateString()]) {
                    let eventContainer = document.createElement("div");
                    eventContainer.className = "eventCard";

                    let eventHeader = document.createElement("div");
                    eventHeader.className = "eventCard-header";

                    let eventDescription = document.createElement("div");
                    eventDescription.className = "eventCard-description";

                    eventHeader.appendChild(document.createTextNode(key));
                    eventContainer.appendChild(eventHeader);

                    eventDescription.appendChild(document.createTextNode(objWithDate[key]));
                    eventContainer.appendChild(eventDescription);

                    let markWrapper = document.createElement("div");
                    markWrapper.className = "eventCard-mark-wrapper";
                    let mark = document.createElement("div");
                    mark.classList = "eventCard-mark";
                    markWrapper.appendChild(mark);
                    eventContainer.appendChild(markWrapper);

                    sidebarEvents.appendChild(eventContainer);

                    eventsCount++;
                }
                let emptyFormMessage = document.getElementById("emptyFormTitle");
                emptyFormMessage.innerHTML = `${eventsCount} events now`;
            } else {
                let emptyMessage = document.createElement("div");
                emptyMessage.className = "empty-message";
                emptyMessage.innerHTML = "Sorry, no events to selected date";
                sidebarEvents.appendChild(emptyMessage);
                let emptyFormMessage = document.getElementById("emptyFormTitle");
                emptyFormMessage.innerHTML = "No events now";
            }
        }

        gridTable.onclick = function(e) {

            if (!e.target.classList.contains("col") || e.target.classList.contains("empty-day")) {
                return;
            }

            if (selectedDayBlock) {
                if (selectedDayBlock.classList.contains("orange") && selectedDayBlock.classList.contains("lighten-3")) {
                    selectedDayBlock.classList.remove("orange");
                    selectedDayBlock.classList.remove("lighten-3");
                }
            }
            selectedDayBlock = e.target;
            selectedDayBlock.classList.add("orange");
            selectedDayBlock.classList.add("lighten-3");

            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt(e.target.innerHTML));

            showEvents();

            document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric"
            });

        }

        var changeFormButton = document.getElementById("changeFormButton");
        var addForm = document.getElementById("addForm");
        changeFormButton.onclick = function(e) {
            addForm.style.top = 0;
        }

        var cancelAdd = document.getElementById("cancelAdd");
        cancelAdd.onclick = function(e) {
            addForm.style.top = "100%";
            let inputs = addForm.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }
            let labels = addForm.getElementsByTagName("label");
            for (let i = 0; i < labels.length; i++) {
                labels[i].className = "";
            }
        }

        var addEventButton = document.getElementById("addEventButton");
        addEventButton.onclick = function(e) {
            let title = document.getElementById("eventTitleInput").value.trim();
            let desc = document.getElementById("eventDescInput").value.trim();

            if (!title || !desc) {
                document.getElementById("eventTitleInput").value = "";
                document.getElementById("eventDescInput").value = "";
                let labels = addForm.getElementsByTagName("label");
                for (let i = 0; i < labels.length; i++) {
                    labels[i].className = "";
                }
                return;
            }

            addEvent(title, desc);
            showEvents();

            if (!selectedDayBlock.querySelector(".day-mark")) {
                selectedDayBlock.appendChild(document.createElement("div")).className = "day-mark";
            }

            let inputs = addForm.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }
            let labels = addForm.getElementsByTagName("label");
            for (let i = 0; i < labels.length; i++) {
                labels[i].className = "";
            }

        }
    </script>



</body>

</html>
