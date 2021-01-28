<html>

<head>
    <!-- META Tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>LaraDocs | API Docs</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- SEO -->
    <meta name="author" content="Binary Torch Sdn. Bhd.">
    <meta name="description" content="Generate beautiful documentation for your Laravel applications using Annotations">
    <meta name="keywords" content="Laravel, LaraDocs, docs, api docs, documentation">
    <meta name="twitter:card" value="summary">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('ansjabar/laradocs/styles.css') }}">

    <!-- JS -->
    <script src="{{ asset('ansjabar/laradocs/scripts.js') }}"></script>

</head>

<body class="nimbus-is-editor">
    <div id="app">
        <div class="fixed pin-t pin-x z-40">
            <div class="bg-gradient-primary text-white h-1"></div>
            <nav class="flex items-center justify-between text-black bg-navbar shadow-xs h-16">
                <div class="flex items-center flex-no-shrink">
                    <a href="#" class="flex items-center flex-no-shrink text-black mx-4">
                        <p class="inline-block font-semibold mx-1 text-grey-dark">
                            Docs
                        </p>
                    </a>
                    <div class="switch">
                        <input type="checkbox" name="1" id="1" class="switch-checkbox">
                        <label for="1" class="switch-label"></label>
                    </div>
                </div>
            </nav>
        </div>
        <!---->
        <div>
            <div class="sidebar is-hidden">
                <ul>
                    <li>
                        <!-- <h2>Get Started</h2> -->
                        <ul>
                            @foreach($groups as $group)
                                <li><a @if($group_name != $arr::get($group, 'slug')) href="{{ route('laradocs.read', ['group_name'=> $arr::get($group, 'slug')]) }}" @else class="bg-primary" @endif >{{ $arr::get($group, 'title') }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="documentation is-dark expanded">
                <h1>{{ $arr::get($resources, 'group.title') }}</h1>
                <p>{{ $arr::get($resources, 'group.description') }}</p>
                <hr>
                <ul>
                    @foreach($resources->resources' as $resource)
                        <li><a href="#{{ $arr::get($resource, 'slug') }}">{{ $arr::get($resource, 'title') }}</a></li>
                    @endforeach
                </ul>
                <p>
                    <a name="login"></a>
                </p>
                @foreach($resources->resources' as $resource)
                <h2><a id="{{ $arr::get($resource, 'slug') }}">{{ $arr::get($resource, 'title') }}</a></h2>
                <p>{{ $resource->description' }}</p>
                <h3>Endpoint</h3>
                <h4>Live</h4>
                <p class="endpoint"><span class="label label-success">{{ implode($resource->method', '/') }}</span><code>{{ $arr::get($endpoints, 'live') }}/{{ $resource->path' }}</code></p>
                <h4>Sandbox</h4>
                <p class="endpoint"><span class="label label-success">{{ implode($resource->method', '/') }}</span><code>{{ $arr::get($endpoints, 'sandbox') }}/{{ $resource->path' }}</code></p>
                @if(is_array($resource->queryParams'))
                <h3>Query Parameters</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left;">Field</th>
                            <th style="text-align: left;">Type</th>
                            <th style="text-align: left;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resource->queryParams' as $key => $val)
                        <tr>
                            <td style="text-align: left;"><p>{{ $val->name' }}</p>
                                @if($val->required' == "REQUIRED")
                                    <span class="badge badge-danger">REQUIRED</span>
                                @else
                                    <span class="badge badge-success">OPTIONAL</span>
                                @endif
                            </td>
                            <td style="text-align: left;">{{ $val->type' }}</td>
                            <td style="text-align: left;">{{ $val->description' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if(is_array($resource->headers'))
                <h3>Header</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left;">Field</th>
                            <th style="text-align: left;">Value</th>
                            <th style="text-align: left;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resource->headers' as $key => $val)
                        <tr>
                            <td style="text-align: left;"><p>{{ $val->name' }}</p>
                                @if($val->required' == "REQUIRED")
                                    <span class="badge badge-danger">REQUIRED</span>
                                @else
                                    <span class="badge badge-success">OPTIONAL</span>
                                @endif
                            </td>
                            <td style="text-align: left;"><code>{!! $val->type' !!}</code></td>
                            <td style="text-align: left;">{{ $val->description' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if(is_array($resource->dataParams'))
                <h3>Data Parameters</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="text-align: left;">Field</th>
                            <th style="text-align: left;">Type</th>
                            <th style="text-align: left;">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resource->dataParams' as $key => $val)
                        <tr>
                            <td style="text-align: left;"><p>{{ $val->name' }}</p>
                                @if($val->required' == "REQUIRED")
                                    <span class="badge badge-danger">REQUIRED</span>
                                @else
                                    <span class="badge badge-success">OPTIONAL</span>
                                @endif
                            </td>
                            <td style="text-align: left;">{{ $val->type' }}</td>
                            <td style="text-align: left;">{{ $val->description' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                <h3>Response</h3>
                <div class="code-toolbar">
                    <ul class="tabs-nav">
                        <li class="tab tab-active"><a href="#" class="success-a">Success</a></li>
                        <li class="tab"><a href="#" class="failure-a">Failure</a></li>
                    </ul>
                    <pre class="language-json">{!! json_encode($resource->successResponse') !!}</pre>
                    <pre class="language-json hide">{!! json_encode($resource->failureResponse') !!}</pre>
                </div>
                <hr>
                @endforeach
            </div>
        </div>
        <div id="backtotop" class="">
            <a href="#"></a>
        </div>
    </div>
</body>
<script>
    Turbolinks.start(),$(".switch-checkbox").change(function(){this.checked?($(".documentation").removeClass("expanded"),$(".sidebar").removeClass("is-hidden"),sessionStorage.nav="checked"):($(".documentation").addClass("expanded"),$(".sidebar").addClass("is-hidden"),sessionStorage.nav="un-checked")}),$("pre").each(function(){var e=$(this).text();try{var s=JSON.parse(e),t=JSON.stringify(s,null,"\t");$(this).text(t)}catch(e){$(this).text("Not a valid JSON")}}),$(document).ready(function(){new SmoothScroll('a[href*="#"]',{speed:1e3});$(".tabs-nav a").on("click",function(e){e.preventDefault(),$(this).hasClass("success-a")?($(this).closest("ul").closest(".code-toolbar").find("pre:nth(1)").addClass("hide"),$(this).closest("ul").closest(".code-toolbar").find("pre:nth(0)").removeClass("hide")):($(this).closest("ul").closest(".code-toolbar").find("pre:nth(1)").removeClass("hide"),$(this).closest("ul").closest(".code-toolbar").find("pre:nth(0)").addClass("hide")),$(this).closest("ul").closest(".code-toolbar").find("pre:nth(1)").addClass("hello"),$(this).closest("ul").children().removeClass("tab-active"),$(this).parent().addClass("tab-active"),$($(this).attr("href")).show()}),"checked"==sessionStorage.nav?($(".switch-checkbox").prop("checked",!0),$(".documentation").removeClass("expanded"),$(".sidebar").removeClass("is-hidden")):$(".switch-checkbox").prop("checked",!1)});
</script>
</html>