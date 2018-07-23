$(document).ready(function(){
    $('.carousel').find('.carousel-indicators li:first-of-type').addClass('active');
    $('.carousel').find('.carousel-item:first-of-type').addClass('active');
    $('.carousel').find('.carousel-item:first-of-type').addClass('active');
    $('.carousel').each(function(){
        var slide = 0;
        $(this).find('.carousel-indicators li').each(function(){
            $(this).attr('data-slide-to', slide);
            console.log(slide);
            slide++;
        });
    });
});

$(document).ready(function(){
    $('.carousel').addClass('carousel-fade');
});

$(document).ready(function(){
    jQuery('script').detach().appendTo('footer');
    jQuery('style').detach().appendTo('head');
    jQuery('link').detach().appendTo('head');
    /*$('*').contents().each(function() {
        if(this.nodeType === Node.COMMENT_NODE) {
            $(this).remove();
        }
    });*/
});

$(document).ready(function(){
    $('.map .overlay').click(function(){
        $(this).css('display','none');
    });
});

$(document).ready(function() {
    $('#animate-btn').click(function() {
        $(this).toggleClass('open');
    });
});

var windowWidth = $(window).width();
if (windowWidth < 1200) {
    $('.dropdown > a').removeAttr('role');
    $('.dropdown > a').removeAttr('aria-expanded');
    $('.dropdown > a').removeAttr('aria-haspopup');
    $('.dropdown > a > .fa').attr({
        "role":"button",
        "aria-expanded":"false",
        "aria-haspopup":"true",
        "data-target": ".dropdown-parent",
        "data-toggle":"dropdown"
    });
    $('.dropdown > a > .fa').detach().appendTo($('.dropdown'));
}

$(document).ready(function(){
    $('img').each(function(){
        $(this).attr('alt', $(this).attr('alt') + ' | Walden Realty ')
    });
});

$('.nav > .first a').prepend('<i class="fa fa-search" aria-hidden="true"></i>');


$(document).ready(function(){
    // click a property type
    $('.search.property-type a').each(function(index) {
        $(this).on('click', function(event){
            event.preventDefault();
            $(this).toggleClass('selected');
            // 'property types' are going to be added to input with attribute "query", comma separated in an array to later use in SQL statement
            var query_property = $('input[name="query"]');
            // checks all property types that are selected to build query
            var property = [];
            $('.search.property-type .selected').each(function(){
                property.push($(this).prop('text').toLowerCase().replace(' ', "-").replace(',', "-").replace('\'', ""));
            });
            $(query_property).attr('property-type', property);
        });
    });
    // click a neighborhood
    $('.search.neighborhood a').each(function(index) {
        $(this).on('click', function(event){
            event.preventDefault();
            $(this).toggleClass('selected');
            // 'neighborhoods' are going to be added to input with attribute "query", comma separated in an array to later use in SQL statement
            var query_neighborhood = $('input[name="query"]');
            // checks all neighborhoods that are selected to build query
            var neighborhood = [];
            $('.search.neighborhood .selected').each(function(){
                neighborhood.push($(this).prop('text').toLowerCase().replace(' ', "-").replace(',', "-").replace('\'', ""));
            });
            $(query_neighborhood).attr('neighborhood', neighborhood);
        });
    });
});

$(function () {
    var availableTags = [
        
    ];
    function split(val) {
        return val.split(/,\s*/);
    }
    function extractLast(term) {
        return split(term).pop();
    }

    $("#neighborhoods_select")
            // don't navigate away from the field on tab when selecting an item
            .bind("keydown", function (event) {
                if (event.keyCode === $.ui.keyCode.TAB &&
                        $(this).autocomplete("instance").menu.active) {
                    event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function (request, response) {
                    // delegate back to autocomplete, but extract the last term
                    response($.ui.autocomplete.filter(
                            availableTags, extractLast(request.term)));
                },
                focus: function () {
                    // prevent value inserted on focus
                    return false;
                },
                select: function (event, ui) {
                    var terms = split(this.value);
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push(ui.item.value);
                    // add placeholder to get the comma-and-space at the end
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }
            });
});
