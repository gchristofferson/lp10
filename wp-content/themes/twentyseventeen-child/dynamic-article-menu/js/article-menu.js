$(document).ready(function () {
    /*---------- Scroll to top button ----------*/
    $(window).bind("scroll", function () {
        // fade button out if user is at top and in if not
        if ($(this).scrollTop() > $(window).height() - 25) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    // add event click handler for scroll to top button:
    $('.scrollup').click(function () {
        $("html, body").animate({scrollTop: 0}, 500);
        return false;
    });

    /*-------------- sidemenu functions for generating links ---------------*/
    // generate links from headers in article for sidebar menu
    // array to hold link titles
    let titles = [];

    // select all h2 and h3's
    $("h2, h3").each(function () {

        // generate random number for id
        let randomNum = Math.floor(Math.random() * 100000);

        // html to append to unordered list after links are generated
        const content = "<li><a class='link' href='#" + randomNum.toString() + "'/></a></li>";

        // add unique id to each h2 or h3
        $(this).attr("id", randomNum.toString());

        /* unless h2 or h3 has class of ignore and does not have data-alt-title, set title to 
         text of header element */
        if (!$(this).hasClass("ignore") && !$(this).data("alt-title")) {
            let title = $(this).html();

            // add title to array
            titles.push(title);

            // insert the anchor tag
            $("ul.links").append(content);
        }

        // otherwise, set title to the data-alt-title attribute text
        else if ($(this).data("alt-title")) {
            let title = $(this).data("alt-title");

            // add title to array
            titles.push(title);

            // insert the anchor tag
            $("ul.links").append(content);
        }
    });

    // add the link titles to the anchor tags
    let index = 0;
    $("a.link").each(function () {
        $(this).text(titles[index]);
        index++;
    });

    /*-------------- sidemenu css ---------------*/
    let opened = false;
    let headerWidth;
    let measuredWidth = false;
    let mobile = false;
    
    // get navigation position
    function getNavPos() {
        let navPos = $(".navigation-top").position();
        let navTop = navPos["top"];
        let navHeight = $(".navigation-top").height();
        return {top: navTop, height: navHeight + 2};
    }
    console.log(getNavPos());
    let res = getNavPos();
    console.log(res["height"]);
    
    // get header position
    function getHeaderPos() {
        let headerHeight = $(".entry-header").height();
        let res = getNavPos();
        let headerTop = res["height"] - res["top"];
        console.log(headerTop);
        return {top: headerTop, height: headerHeight + 6};
    }
    console.log(getHeaderPos());
    

    /* smooth scroll to anchor
     https://stackoverflow.com/questions/7717527/smooth-scrolling-when-clicking-an-anchor-link */
    $('a[href^="#"]').click(function () {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 200
        }, 500);

        // if on mobile, close menu after clicking link
        if (mobile === true) {
            window.setTimeout(function () {
                closeNav();
            }, 50);

            // remember we closed the menu
            opened = false;
        }
        return false;
    });

    // function to open sidemenu navigation
    function openNav() {

        // if we haven't measured article title header div width, set it
        if (!measuredWidth) {
            headerWidth = headerWidth + 55;
        }
        measuredWidth = true;
        $("#mySidenav").css("width", "340px");
        $(".sidenav").css("padding", "60px 20px 130px 30px");
        $(".sidebar").css("width", "100%");
        $("#closebtn").css("display", "block");
        $("#open-menu").html("Contents ");
        $("#open-menu").css("margin-right", "60px");
    }

    // function to close sidemenu navigation
    function closeNav() {
        $("#mySidenav").css("width", "0");
        $(".sidenav").css("padding", "0");
        $(".sidebar").css("background-color", "#222");
        $(".entry-header").css("background-color", "#222");
        $("#closebtn").css("display", "none");
        $("#open-menu").html("Contents &#9776;");
        $("#open-menu").css("margin-right", "25px");
    }

    // event handlers for menu open and close buttons 
    $("#open-menu").click(function () {
        openNav();
        
        // remember that the menu is opened
        opened = true;
    });

    $("#closebtn").click(function () {
        closeNav();
        
        // remeber that the menu is closed
        opened = false;
    });

    // display the menu and set css if user has scrolled to or past #main
    let distance = $('#main').offset().top,
            $window = $(window);
            
    // get page url protocal
    let protocol = window.location.protocol;
    
    // build url string with the correct protocol
    const url = protocol + "//www.kennethjcaseynewsletters.com/";
    const testURL = protocol + "//www.kennethjcaseynewsletters.test/";
    
    $window.scroll(function () {
        if ($window.scrollTop() >= distance) {
            
            // don't set the following on homepage
            if (window.location.href !== url && window.location.href !== testURL) {
                console.log(getHeaderPos());
                $(".entry-title").css("float", "right");
                $(".entry-header").css("position", "fixed");
                $(".entry-header").css("background-color", "#222");
                $(".entry-header").css("width", "100%");
                $(".entry-header").css("right", "0");
                $(".entry-header").css("z-index", "9");
                $(".entry-header").css("padding", "10px 25px 0 0");
                $(".sidebar").css("display", "block");
                $(".sidebar").css("width", "100%");

                // adjust layout for mobile
                if (mobile !== true) {
                    $(".entry-header").css("top", "120px");
                    $(".sidebar").css("top", "148px");
                    $(".sidenav").css("top", "152px");
                }

                // if we haven't measured article title header div width, measure it
                if (!measuredWidth) {
                    headerWidth = $(".entry-header").width();
                }

                // if menu was open, open it again as scrolls to or past #main
                if (opened === true) {
                    openNav();
                }
            }
        }

        // if user hasn't scrolled past #main, or is above it, close sidemenu
        else {
            $(".entry-title").css("float", "");
            $(".sidebar").css("display", "none");
            $(".entry-header").css("position", "");
            $(".sidebar").css("width", headerWidth - 17);
            if ($("#mySidenav").width() !== 0) {
                closeNav();
            }
        }
    });

    // add mobile responsiveness
    function checkWidth() {
        let windowsize = $window.width();

        // if window size is less than or equal to 750px, adjust for mobile
        if (windowsize <= 750) {
            $(".entry-header").css("top", "0");
            $(".entry-header").css("right", "0");
            $(".sidebar").css("top", "28px");
            $(".sidebar").css("right", "0");
            $(".sidenav").css("top", "32px");

            // remember screen size is mobile
            mobile = true;
        }

        // otherwise, adjust for desktop
        else {
            $(".entry-header").css("top", "120px");
            $(".entry-header").css("right", "0");
            $(".sidebar").css("top", "148px");
            $(".sidenav").css("top", "152px");

            // remember screen size is not mobile
            mobile = false;
        }
    }

    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);
});