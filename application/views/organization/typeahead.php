<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jquery-typeahead-2.6.1/src/jquery.typeahead.css">

    <script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
    <!--script src="../dist/jquery.typeahead.min.js"></script-->
    <script src="<?php echo base_url(); ?>assets/jquery-typeahead-2.6.1/src/jquery.typeahead.js"></script>

</head>
<body>

<div style="width: 100%; max-width: 800px; margin: 0 auto;">

    <h1>Country_v2 Demo</h1>

    <ul>
        <li>
            <a href="http://www.runningcoder.org/jquerytypeahead/documentation/">Documentation</a>
        </li>
        <li>
            <a href="http://www.runningcoder.org/jquerytypeahead/demo/">Demos</a>
        </li>
    </ul>

    <div class="js-result-container"></div>

    <var id="result-container" class="result-container"></var>
 
	<form id="form-country_v2" name="form-country_v2">
	    <div class="typeahead__container">
	        <div class="typeahead__field">
	 
	            <span class="typeahead__query">
	                <input class="js-typeahead-country_v2" name="country_v2[query]" placeholder="Search" autocomplete="off" type="search">
	            </span>
	            <span class="typeahead__button">
	                <button type="submit">
	                    <i class="typeahead__search-icon"></i>
	                </button>
	            </span>
	 
	        </div>
	    </div>
	</form>

    <script>

    	$.typeahead({
			input: '.js-typeahead-country_v2',
		    minLength: 1,
		    maxItem: 20,
		    order: "asc",
		    href: "https://en.wikipedia.org/?title={{display}}",
		    template: "{{display}} <small style='color:#999;'>{{group}}</small>",
		    source: {
		        country: {
		            ajax: {
		                url: "http://localhost:8000/projects/voyager-med/organization/get_countries",
		                path: "data.country"
		            }
		        },
		        capital: {
		            ajax: {
		                type: "POST",
		                url: "http://localhost:8000/projects/voyager-med/organization/get_capitals",
		                path: "data.capital",
		                data: {myKey: "myValue"}
		            }
		        }
		    },
		    callback: {
		        onNavigateAfter: function (node, lis, a, item, query, event) {
		            if (~[38,40].indexOf(event.keyCode)) {
		                var resultList = node.closest("form").find("ul.typeahead__list"),
		                    activeLi = lis.filter("li.active"),
		                    offsetTop = activeLi[0] && activeLi[0].offsetTop - (resultList.height() / 2) || 0;
		 
		                resultList.scrollTop(offsetTop);
		            }
		 
		        },
		        onClickAfter: function (node, a, item, event) {
		 
		            event.preventDefault();
		 
		            var r = confirm("You will be redirected to:\n" + item.href + "\n\nContinue?");
		            if (r == true) {
		                window.open(item.href);
		            }
		 
		            $('#result-container').text('');
		 
		        },
		        onResult: function (node, query, result, resultCount) {
		            if (query === "") return;
		 
		            var text = "";
		            if (result.length > 0 && result.length < resultCount) {
		                text = "Showing <strong>" + result.length + "</strong> of <strong>" + resultCount + '</strong> elements matching "' + query + '"';
		            } else if (result.length > 0) {
		                text = 'Showing <strong>' + result.length + '</strong> elements matching "' + query + '"';
		            } else {
		                text = 'No results matching "' + query + '"';
		            }
		            $('#result-container').html(text);
		 
		        },
		        onMouseEnter: function (node, a, item, event) {
		 
		            if (item.group === "country") {
		                $(a).append('<span class="flag-chart flag-' + item.display.replace(' ', '-').toLowerCase() + '"></span>')
		            }
		 
		        },
		        onMouseLeave: function (node, a, item, event) {
		 
		            $(a).find('.flag-chart').remove();
		 
		        }
		    }
		});

    </script>

</div>

</body>
</html>