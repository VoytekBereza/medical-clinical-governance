function stripslashes(str) {
    return (str + '').replace(/(?:\\[rn])+/g, "", function (s, n1) {
        switch (n1) {
        case '\\':
            return '\\';
        case '0':
            return '\u0000';
        case '':
            return '';
        default:
            return n1;
        }
    });
}//end stripslashes(str)

function date(format, timestamp) {
    var that = this,
        jsdate, f, formatChr = /\\?([a-z])/gi,
        formatChrCb, _pad = function (n, c) {
            if ((n = n + "").length < c) {
                return new Array((++c) - n.length).join("0") + n;
            } else {
                return n;
            }
        },
        txt_words = ["Sun", "Mon", "Tues", "Wednes", "Thurs", "Fri", "Satur", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
        txt_ordin = {
            1: "st",
            2: "nd",
            3: "rd",
            21: "st",
            22: "nd",
            23: "rd",
            31: "st"
        };
    formatChrCb = function (t, s) {
        return f[t] ? f[t]() : s;
    };
    f = {
        d: function () {
            return _pad(f.j(), 2);
        },
        D: function () {
            return f.l().slice(0, 3);
        },
        j: function () {
            return jsdate.getDate();
        },
        l: function () {
            return txt_words[f.w()] + 'day';
        },
        N: function () {
            return f.w() || 7;
        },
        S: function () {
            return txt_ordin[f.j()] || 'th';
        },
        w: function () {
            return jsdate.getDay();
        },
        z: function () {
            var a = new Date(f.Y(), f.n() - 1, f.j()),
                b = new Date(f.Y(), 0, 1);
            return Math.round((a - b) / 864e5) + 1;
        },
        W: function () {
            var a = new Date(f.Y(), f.n() - 1, f.j() - f.N() + 3),
                b = new Date(a.getFullYear(), 0, 4);
            return 1 + Math.round((a - b) / 864e5 / 7);
        },
        F: function () {
            return txt_words[6 + f.n()];
        },
        m: function () {
            return _pad(f.n(), 2);
        },
        M: function () {
            return f.F().slice(0, 3);
        },
        n: function () {
            return jsdate.getMonth() + 1;
        },
        t: function () {
            return (new Date(f.Y(), f.n(), 0)).getDate();
        },
        L: function () {
            var y = f.Y(),
                a = y & 3,
                b = y % 4e2,
                c = y % 1e2;
            return 0 + (!a && (c || !b));
        },
        o: function () {
            var n = f.n(),
                W = f.W(),
                Y = f.Y();
            return Y + (n === 12 && W < 9 ? -1 : n === 1 && W > 9);
        },
        Y: function () {
            return jsdate.getFullYear();
        },
        y: function () {
            return (f.Y() + "").slice(-2);
        },
        a: function () {
            return jsdate.getHours() > 11 ? "pm" : "am";
        },
        A: function () {
            return f.a().toUpperCase();
        },
        B: function () {
            var H = jsdate.getUTCHours() * 36e2,
                i = jsdate.getUTCMinutes() * 60,
                s = jsdate.getUTCSeconds();
            return _pad(Math.floor((H + i + s + 36e2) / 86.4) % 1e3, 3);
        },
        g: function () {
            return f.G() % 12 || 12;
        },
        G: function () {
            return jsdate.getHours();
        },
        h: function () {
            return _pad(f.g(), 2);
        },
        H: function () {
            return _pad(f.G(), 2);
        },
        i: function () {
            return _pad(jsdate.getMinutes(), 2);
        },
        s: function () {
            return _pad(jsdate.getSeconds(), 2);
        },
        u: function () {
            return _pad(jsdate.getMilliseconds() * 1000, 6);
        },
        e: function () {
            return 'UTC';
        },
        I: function () {
            var a = new Date(f.Y(), 0),
                c = Date.UTC(f.Y(), 0),
                b = new Date(f.Y(), 6),
                d = Date.UTC(f.Y(), 6);
            return 0 + ((a - c) !== (b - d));
        },
        O: function () {
            var a = jsdate.getTimezoneOffset();
            return (a > 0 ? "-" : "+") + _pad(Math.abs(a / 60 * 100), 4);
        },
        P: function () {
            var O = f.O();
            return (O.substr(0, 3) + ":" + O.substr(3, 2));
        },
        T: function () {
            return 'UTC';
        },
        Z: function () {
            return -jsdate.getTimezoneOffset() * 60;
        },
        c: function () {
            return 'Y-m-d\\Th:i:sP'.replace(formatChr, formatChrCb);
        },
        r: function () {
            return 'D, d M Y H:i:s O'.replace(formatChr, formatChrCb);
        },
        U: function () {
            return Math.round(jsdate.getTime() / 1000);
        }
    };
    this.date = function (format, timestamp) {
        that = this;
        jsdate = ((typeof timestamp === 'undefined') ? new Date() : (timestamp instanceof Date) ? new Date(timestamp) : new Date(timestamp * 1000));
        return format.replace(formatChr, formatChrCb);
    };
    return this.date(format, timestamp);
}

function generate_random(digit){
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    for( var i=0; i < digit; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

// Use for post code all characters should be uppercase
$(function() {
    $('.my_upper_class').keyup(function() {
        this.value = this.value.toLocaleUpperCase();
		//alert(this.value);
    });
});


$(document).ready(function(){
	
	//Left Nav Toggle
	$('#presc_menu').click(function(){
		$('#presc_menu_cont').toggle();	
	});
	
	$('#clinic_gov_menu').click(function(){
		$('#clinic_gov_menu_cont').toggle();	
	});


	$('.dismiss_message').click(function(){
		
		var organization_id = $(this).attr('data-org');
		var pharmacy_id = $(this).attr('data-pharmacy');
		var message_type = $(this).attr('data-type');
		
		$.ajax({
		
			type: "POST",
			url: SURL + "organization/dismiss-message/",
			data: {'organization_id' : organization_id, 'pharmacy_id' : pharmacy_id, 'message_type' : message_type },
			beforeSend : function(result){
				
			},  
			success: function(result){
			}
		}); 
		
	})

});
	