<footer>

    <div class="container">
        <div class="row footer-top">

            <div class="col-md-5 contact-us">
                <h3>Contact Us</h3>
                <h4>Booking Info</h4>
                <p>
                    {{ @$bookingInfo->phone }}
                    @if (@$bookingInfo->add_phone)
                    <br>{{ @$bookingInfo->add_phone }}
                    @endif
                </p>
                <p>{{ @$bookingInfo->visitsname }}<br>
                {{ @$bookingInfo->address }}<br>
                {{ @$bookingInfo->city }}</p>
            </div>

            <div class="col-md-4 visits">
                <h3>Visits</h3>
                <ul>
                    <li>{{ link_to_route('about', 'About') }}</li>
                    <li>{{ link_to_route('advice', 'Tourism Advice') }}</li>
                    <li>{{ link_to_route('faq', "FAQ's") }}</li>
                    <li>{{ link_to_route('terms', 'Terms &amp; Conditions') }}</li>
                </ul>
            </div>

            <div class="col-md-3 cert-search">
                <div class="eco-cert">Eco Certified Advanced Ecotourism</div>

                <form role="search" action="/search" method="GET">
                    <input type="text" class="search-field" placeholder="Search..." name="query">
                </form>
            </div>

        </div>

        <div class="row footer-bottom">

            <div class="col-md-5 follow-us">
                <ul class="social-icons">
                    <li class="facebook"><a href="{{@$social->facebook}}">Facebook</a></li>
                    <li class="twitter"><a href="{{@$social->twitter}}">Twitter</a></li>
                    <li class="googleplus"><a href="{{@$social->googleplus}}">Google+</a></li>
                    <li class="youtube"><a href="{{@$social->youtube}}">Youtube</a></li>
                </ul>
            </div>

            <div class="col-md-4 email">
                <a class="email-link" href="mailto:{{ @$bookingInfo->email }}">{{ @$bookingInfo->email }}</a>
            </div>

            <div class="col-md-3 copyright">
                <p class="copyright">&copy; {{{ date('Y') }}} Visits Tours</p>
            </div>

        </div>

    </div>

</footer>


