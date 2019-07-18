<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Code Hacking Test App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        @if (session('success_message'))
            <div class="alert alert-success">
                {{ session('success_message') }}
            </div>
        @endif

        @if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="checkout container">
                <form method="post" id="payment-form" action="{{ url('/checkout') }}">
                    @csrf
                    <section>
                        <label for="amount">
                            <span class="input-label">Amount</span>
                            <div class="input-wrapper amount-wrapper">
                                <input id="amount" name="amount" type="tel" min="1" placeholder="Amount" value="10">
                            </div>
                        </label>

                        <div id="customer-name">
                            <label for="first name">
                                <span class="input-label">First Name</span>
                                <div class="input-wrapper first-name-wrapper">
                                    <input id="first-name" name="firstName" type="text" placeholder="First Name">
                                </div>
                            </label>

                            <label for="last name">
                                <span class="input-label">Last Name</span>
                                <div class="input-wrapper last-name-wrapper">
                                    <input id="last-name" name="lastName" type="text" placeholder="Last Name">
                                </div>
                            </label>
                        </div>

                        <label for="email">
                            <span class="input-label">Email</span>
                            <div class="input-wrapper email-wrapper">
                                <input id="email" name="email" type="text" placeholder="Email">
                            </div>
                        </label>

                        <div id="billing-address">
                            <label for="country">
                                <span class="input-label">Country</span>
                                <div class="input-wrapper country-wrapper">
                                    <select name="country">
                                        <option value="United States">United States</option>
                                        <option value="">Other</option>
                                    </select>
                                </div>
                            </label>
                            <div>
                                <label for="street address">
                                    <span class="input-label">Street Address</span>
                                    <div class="input-wrapper street-address-wrapper">
                                        <input id="street-address-input" name="streetAddress" type="text" placeholder="Street Address">
                                    </div>
                                </label>

                                <label for="city">
                                    <span class="input-label">City</span>
                                    <div class="input-wrapper city-wrapper">
                                        <input id="city-input" name="city" type="text" placeholder="City">
                                    </div>
                                </label>
                            </div>
                            <div>
                                <label for="state">
                                    <span class="input-label">State</span>
                                    <div class="input-wrapper state-wrapper">
                                        <input id="state-input" name="state" type="text" placeholder="State">
                                    </div>
                                </label>

                                <label for="postal code">
                                    <span class="input-label">Postal Code</span>
                                    <div class="input-wrapper postal-code-wrapper">
                                        <input id="postal-code-input" name="postalCode" type="text" placeholder="Postal/Zip Code">
                                    </div>
                                </label>
                            </div>

                        </div>

                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>
                    </section>

                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                    <button class="button" type="submit"><span>Test Transaction</span></button>
                </form>
            </div>
        </div>
    <script src="https://js.braintreegateway.com/web/dropin/1.18.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{$token}}";

        braintree.dropin.create({
            authorization: client_token,
            selector: '#bt-dropin',
            // paypal: {
            // flow: 'vault'
            // }
        }, function (createErr, instance) {
            if (createErr) {
            console.log('Create Error', createErr);
            return;
            }
            form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                console.log('Request Payment Method Error', err);
                return;
                }

                // Add the nonce to the form and submit
                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
            });
        });
    </script>
    </body>
</html>
