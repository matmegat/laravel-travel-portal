$(function () {
    $('#dp1').datepicker();
    $('#dp2').datepicker();

});
$(function () {
    $('#infoTab a:first').tab('show')
})

$(function(){
    $('.typeahead').typeahead({
            highlight: true
        },
        {
            source: function (query, process) {
                return $.get('/search/tours', { query: query }, function (data) {
                    return process(JSON.parse(data).tours);
                });
            },
            displayKey: 'title',
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'unable to find any tours that match the current query',
                    '</div>'
                ].join('\n'),
                header: '<h3 class="league-name">TOURS</h3>',
                suggestion: Handlebars.compile('<a href="/tours/products/{{id}}"><strong>{{title}}</strong></a>')

            }
        },
        {
            source: function (query, process) {
                return $.get('/search/blogs', { query: query }, function (data) {
                    return process(JSON.parse(data).blogs);
                });
            },
            displayKey: 'title',
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'unable to find any blog posts that match the current query',
                    '</div>'
                ].join('\n'),
                header: '<h3 class="league-name">BLOGS</h3>',
                suggestion: Handlebars.compile('<a href="/news/details/{{id}}"><strong>{{title}}</strong></a>')

            }
        },
        {
            source: function (query, process) {
                return $.get('/search/pages', { query: query }, function (data) {
                    return process(JSON.parse(data).page);
                });
            },
            displayKey: 'title',
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'unable to find any pages that match the current query',
                    '</div>'
                ].join('\n'),
                header: '<h3 class="league-name">PAGES</h3>',
                suggestion: Handlebars.compile('<a href="/page/redirect/{{id}}"><strong>{{title}}</strong></a>')

            }
        }).on('typeahead:selected', function (obj, datum) {
            if(datum.type == 'tour')
                window.location = "/tours/products/" + datum.id;
            if(datum.type == 'blog')
                window.location = "/news/details/" + datum.id;
            if(datum.type == 'page')
                window.location = "/page/redirect/" + datum.id;
        });

    $('.tt-dropdown-menu').append('<a href="/search?query=" id="show-link">Show all results</a>')
});


$(function(){
    $('.typeahead').keyup(function(){
        var text = $(this).val();
        $('#show-link').prop('href', "/search?query=" + text);
    });
});
