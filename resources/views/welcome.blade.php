<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="app">
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

            input {
                height: 30px;
                font-size: 16px;
                padding-left: 5px;
                width: 98%;
            }

            label {
                padding-top: 10px;
            }

            ::placeholder {
                opacity: .35;
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

            .checkout {
                margin: 0 25px;
                min-width: 480px;
                max-width: 500px;
            }

            .cost {
                display: flex;
                flex-direction: column;
                align-items: flex-end;

            }

            .cost-item {
                padding-bottom: 4px;
            }

            .total {
                font-size: 21px;
                font-weight: bold;
            }

            #email {
                width: 65%;
            }

            #address-form {
                padding: 10px 5px;
                margin-top: 10px;
            }

            #customer-name, #billing-address {
                padding: 12px 0;
            }

            #customer-name, #sub-address {
                display: flex;
                flex-direction: row;
                align-items: stretch;
                width: 98.5%;
            }

            #country {
                padding-bottom: 10px;
            }

            #email {
                width: 60%;
            }

            #last-name, #state, #postal-code {
                margin-left: 22px;
            }

            #city {
                width: 65%;
            }

            #state {
                width: 10%
            }

            #postal-code {
                width: 25%;
            }

            #last-name, #first-name {
                width: 50%;
            }

            #quantity {
                width: 75px;
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
                        <label id="quantity" for="quantity">
                            <span class="input-label">Quantity</span>
                            <div class="input-wrapper quantity-wrapper">
                                <input type="number" id="quantity" name="quantity" ng-model="quantity" placeholder="Quantity">
                            </div>
                        </label>

                        <div id="customer-name">
                                <label id="first-name" for="first name">
                                    <span class="input-label">First Name</span>
                                    <div class="input-wrapper first-name-wrapper">
                                        <input name="firstName" type="text" placeholder="First Name" required>
                                    </div>
                                </label>

                                <label id="last-name" for="last name">
                                    <span class="input-label">Last Name</span>
                                    <div class="input-wrapper last-name-wrapper">
                                        <input name="lastName" type="text" placeholder="Last Name" required>
                                    </div>
                                </label>
                        </div>

                        <div id="email">
                            <label for="email">
                                <span class="input-label">Email</span>
                                <div class="input-wrapper email-wrapper">
                                    <input name="email" type="text" placeholder="Email" required>
                                </div>
                            </label>
                        </div>

                        <div id="billing-address">
                            <label id="country" for="country">
                                <span class="input-label">Country</span>
                                <div class="custom-select" style="width:200px;">
                                    <select required name="country" ng-model="country">
                                        <option value="" disabled>Select Country</option>
                                        <option value="United States">United States</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </label>
                            <div id="address-form" ng-if="country == 'United States'">
                                <label id="street-address" for="street address">
                                    <span class="input-label">Street Address</span>
                                    <div class="input-wrapper street-address-wrapper">
                                        <input name="streetAddress" type="text" placeholder="Street Address">
                                    </div>
                                </label>

                                <div id="sub-address">
                                    <label id="city" for="city">
                                        <span class="input-label">City</span>
                                        <div class="input-wrapper city-wrapper">
                                            <input name="city" type="text" placeholder="City">
                                        </div>
                                    </label>
                                    <label id="state" for="state">
                                        <span class="input-label">State</span>
                                        <div class="input-wrapper state-wrapper">
                                            <input name="state" type="text" placeholder="State">
                                        </div>
                                    </label>

                                    <label id="postal-code" for="postal code">
                                        <span class="input-label">Postal Code</span>
                                        <div class="input-wrapper postal-code-wrapper">
                                            <input name="postalCode" type="text" placeholder="Postal Code">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="bt-drop-in-wrapper">
                            <div id="bt-dropin"></div>
                        </div>

                    <div class="cost">
                        <div class="sales-tax cost-item"><span>Sales tax: </span><span><%(quantity * price) * taxPercentage | currency : '$'%></span></div>
                        <div class="subtotal cost-item"><span>Subtotal: </span><span id="subtotal"><%quantity * price | currency : '$'%></span></div>
                        <div class="total cost-item"><span>Total: </span><span id="total"><%(quantity * price) + ((quantity * price) * taxPercentage) | currency : '$'%></span></div>
                    </div>

                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                    <button class="button" type="submit"><span>Test Transaction</span></button>
                </form>
            </div>
        </div>
    <script src="https://js.braintreegateway.com/web/dropin/1.18.0/js/dropin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.js"></script>
    <script>
        const module = angular.module('app', []);
        module.config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('<%');
            $interpolateProvider.endSymbol('%>');
        });

        module.run(function ($rootScope) {
            $rootScope.quantity = 1;
            $rootScope.taxPercentage = .071;
            $rootScope.price = 29.99;
        });
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
