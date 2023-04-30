let define1 = define(['jquery'], function($) { // Moodle needs this to recognise $ https://docs.moodle.org/dev/jQuery .
    // JQuery is available via $.

    return {
        init: function (namecookie) {
            var t;

            if(document.cookie)
            var sec =parseInt(document.cookie.match(new RegExp("(?:^|; )" + namecookie.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"))[1]);
            timer();

            function timer() {
                t = setTimeout(add, 1000);
            }
            function add() {
                sec++;
                document.cookie = namecookie+"="+sec;
                //$("input[id='quest_time']")[0].value = sec;
                timer();
            }
        }
    }
});