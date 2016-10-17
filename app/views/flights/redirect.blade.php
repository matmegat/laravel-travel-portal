@extends('layouts.travel')

@section('title')
Flights | Visits
@stop

@section('content')

<div class="page-background" style="background-image: url(/img/header-bg/flights.jpg)">
    <div class="container">
        <h1>{{ $info->title; }}</h1>
        <p>{{ $info->content; }}</p>
    </div>
</div>

<div class="main-body">

    <div class="container home-tab-content page-tab-content">
        <div class="row">
            <div class="col-xs-12 flight-filter tab active">

                @include('forms.flights.search_menu')

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 flight-result-filter">
                <p>
                    <h5>Please wait, {{Config::get('site.title')}} is redirecting you to the destination site...</h5>
                </p>
            </div>


        </div>
    </div>

</div>

{{--<div class="flights">
    <div
            class="index flights"
    @if ($pageInfo['backgroundUrl'])
    style="background: url('{{$pageInfo['backgroundUrl']}}') no-repeat; background-size: 100%;"
    @endif
    >
    <div class="container">
        <header>
            <h2>{{ $info->title; }}</h2>
            <div>{{ $info->content; }}</div>
        </header>
    </div>
</div>
<div class="content_results">
    <div class="container">
        <div class="section_results">
            @include('forms.flights.search_menu')
            @include('flights.sidebar')
            <div class ="flights_results">
                <div id="result-box">
                    <div class="results_header" style="min-height: 650px;"><h2>Please wait, {{Config::get('site.title')}} is redirecting you to the destination site..</h2></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>--}}

<script>
    (function() {
        var container = document.getElementById('container');
        var deeplink = {{ json_encode($deeplink) }};

        function run_requests(requests) {
            requests_count = requests.length

            for (count = 0; count < requests_count; count++) {
                request = requests[count]

                if (requests_count == (count + 1)) {
                    // Don't use hidden iframe for the last request
                    setTimeout(function() { make_request(window.document, request); }, 1000);
                } else {
                    var iframe = document.createElement('iframe');
                    iframe.setAttribute('id', 'deep-linker' + count);
                    iframe.style.border = '0px';
                    iframe.style.width = '0px';
                    iframe.style.height = '0px';
                    document.body.appendChild(iframe);

                    // Get the document object.
                    var doc = null;
                    if (iframe.contentDocument && iframe.contentDocument.location) {
                        // For DOM2-compliant browsers.
                        doc = iframe.contentDocument;
                    } else if (iframe.contentWindow) {
                        // For IE5.5 and IE6.
                        doc = iframe.contentWindow.document;
                    } else if (window.frames) {
                        // For Safari.
                        doc = window.frames['deep-linker'].document;
                    }

                    // Clear the iframe document content if making a POST.
                    if (request.method.toUpperCase() === "POST") {
                        doc.open();
                        doc.write('');
                        doc.close();
                    }

                    make_request(doc, request);
                }
            }
        }

        function make_request(doc, request) {
            var url = request.url;
            var post_params = request.post_params;

            var delay = 200;
            if (request.delay) {
                delay = request.delay;
            }

            if (request.method.toUpperCase() === "POST") {
                // HTTP POST.
                var form_html = '';
                form_html += '<html><body>';

                // Create a <form> and have it auto-submit.
                form_html += '<form id="ninjaForm" name="ninjaForm" method="post" action="' + url + '">';

                if (post_params) {
                    Object.keys(post_params).map(function(key) {
                        form_html += '<input name="' + key + '" value="' + post_params[key] + '" type="hidden" />';
                    });
                }

                form_html += '</form><script type="text/javascript">setTimeout("submitme()", ' + delay + ');function submitme() { document.ninjaForm.submit(); }';
                form_html += '<' + '/script>';
                form_html += '</body></html>';

                doc.open();
                doc.write(form_html);
                doc.close();
            } else {
                doc.location.href = url;
            }
        }

        run_requests(deeplink.requests)
    }());
</script>

@stop