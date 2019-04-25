jQuery(function ($) {

    //Init DataTable
    var tag = 'view-all-research';
    var date = '';
    ajax_query(tag, date);

    $('#nav-tab-ivydb, #nav-tab-optigraph').on('click', function () {
        if ($(this).attr('name') == 'ivy') {
            if ($(window).innerWidth() < 768) {
                $('.CO-body-mobile').removeClass('d-none');
            }
            $('.CO-body > div.__i').addClass('d-md-block');
            $('.optigraph-image').addClass('d-none');

            // Reseting nav item country to US
            $('.nav-item-country').removeClass('active');
            $('#nav-tab-country-us').addClass('active');
        } else {
            $('.CO-body-mobile').addClass('d-none');
            $('.CO-body > div.__i').removeClass('d-md-block');
            $('.optigraph-image').removeClass('d-none');

            // On click optigraph renders US map
            $('img.map').addClass('d-none');
            $('img.map.us').removeClass('d-none')
        }
    });


    $('p.timeline-year').on('click', function (event) {
        // Prevent default action - opening tag page
        event.preventDefault();
        // Get tag slug from title attirbute
        var tag = 'view-all-research';
        date = $(this).attr('data-year');

        $('.timeline-year').removeClass('active');
        $('.entry').removeClass('active');
        $(this).addClass('active');
        $(this).parent().addClass('active');

        ajax_query(tag, date);
    });




    $('#type-of-research-select').on('change', function () {
        var optionSelected = $("option:selected", this);
        alert(optionSelected);

        switch (optionSelected.val()) {

            case 'view-all':
                var tag = 'view-all-research';
                break;
            case 'optionmetrics':
                var tag = 'optionmetrics-research';
                break;
            case 'academics':
                var tag = 'academics-research';
                break;
            case 'institutional':
                var tag = 'institutional-research';
                break;

        }

        ajax_query(tag, date);
    });

    $('.btn-optionmetrics').on('click', function(event){
        event.preventDefault();
        var tag = 'optionmetrics';
        ajax_query(tag, '');

    });

    $('#nav-tab .nav-item').on('click', function (event) {
        // Prevent default action - opening tag page
        event.preventDefault();
        // Get tag slug from title attirbute
        var tag = $(this).attr('name');
        ajax_query(tag, date);
    });

    $('a#view-our-research-papers').bind('click', function(event){
        event.preventDefault();
        $('.nav-tabs').find('a#nav-tab-optionmetrics').trigger('click');
    }) ;
/*
    $('#nav-tab-optionmetrics').on('click', function (event) {
        // Prevent default action - opening tag page
        event.preventDefault();
        // Get tag slug from title attirbute
        var tag = 'optionmetrics-research';
        ajax_query(tag, date);
    });


    $('#nav-tab-academics').on('click', function (event) {
        // Prevent default action - opening tag page
        event.preventDefault();
        // Get tag slug from title attirbute
        var tag = 'academics-research';
        ajax_query(tag, date);
    });

    $('#nav-tab-institutional').on('click', function (event) {
        // Prevent default action - opening tag page
        event.preventDefault();
        // Get tag slug from title attirbute
        var tag = 'institutional-research';
        ajax_query(tag, date);
    });
*/


    function ajax_query(tag, date) {
        data = {
            action: 'filter_posts',
            afp_nonce: afp_vars.afp_nonce,
            taxonomy: 'research',
            ajax: true,
            stuff: tag,
            date: date,
            dataType: 'json'
        };
        $.post(afp_vars.afp_ajax_url, data, function (response) {
            $('#research-posts').DataTable({
                data: JSON.parse(response),
                ordering: true,
                order: [[1, "desc"]],
                bDestroy: true,
                search: true,
                responsive: true,
                pageLength: 4,
                lengthChange: false,
                bInfo: false,
                language: {
                    searchPlaceholder: "Search...",
                    search: "",
                    paginate: {
                        next: "<span class=\"fa fa-chevron-right\"></span>",
                        previous: "<span class=\"fa fa-chevron-left\"></span>",
                    }
                },
                "aoColumns": [
                    {title: "Posts"},
                    {"sType": "date-uk", "visible": false}
                ]
            });
        });
    }


    $('#events-year-filter').on('change', function () {
        var date = $("option:selected", this).val();
        ajax_query_events('events', date, '#news');
    });

    ajax_query_events('events', date, '#news');

    function ajax_query_events(tag, date, elem) {
        data = {
            action: 'filter_posts',
            afp_nonce: afp_vars.afp_nonce,
            taxonomy: 'news-events',
            ajax: true,
            stuff: tag,
            date: date,
            dataType: 'json'
        };
        $.post(afp_vars.afp_ajax_url, data, function (response) {
            $(elem).DataTable({
                data: JSON.parse(response),
                ordering: true,
                order: [[1, "desc"]],
                bDestroy: true,
                search: true,
                responsive: true,
                pageLength: 4,
                lengthChange: false,
                bInfo: false,
                language: {
                    searchPlaceholder: "Search News...",
                    search: "",
                    paginate: {
                        next: "<span class=\"fa fa-chevron-right\"></span>",
                        previous: "<span class=\"fa fa-chevron-left\"></span>",
                    }
                },
                "aoColumns": [
                    {title: "Posts"},
                    {"sType": "date-uk", "visible": false}
                ]
            });
        });
    }


    $.extend($.fn.dataTableExt.oSort, {
        "date-uk-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var ukDatea = a.split('/');
            return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
        },

        "date-uk-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });

});