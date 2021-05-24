$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'glyphicon-minus-sign';
      var closedClass = 'glyphicon-plus-sign';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews on PGD Certificate Page
$('#pgd_doc').treed({openedClass:'fa fa-folder-open-o', closedClass:'fa fa-folder-o'});

//Initialization of treeviews on Training Certificate Page
$('#course_video_doc').treed({openedClass:'fa fa-folder-open', closedClass:'fa fa-folder'});

//Initialization of treeviews on Organization SOP Page
$('#governance_sop_read_tree').treed({openedClass:'fa fa-minus-square', closedClass:'fa fa-plus-square'});

/*
$('#governance_sop_read_tree').treed({openedClass:'fa fa-folder-o', closedClass:'fa fa-folder-open-o'});
$('#governance_sop_read_tree .branch').each(function(){
	var icon = $(this).children('i:first');
	$(this).children().children().toggle();
});
*/


