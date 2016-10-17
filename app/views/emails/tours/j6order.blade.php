<html>
<head>
<meta charset="UTF-8">
<title>Your Order</title>
</head>
<body>

    <h2><strong>Congratulations!</strong> You successfully bought {{$product['Title']}}!</h2>

    <p class="place">Your order information: </p>
    <table class="table table-bordered">
        <tr>
            <td>Order ID</td>
            <td>{{{$order['ExternalOrderID']}}}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>PAID</td>
        </tr>
        <tr>
            <td>Total</td>
            <td>${{ $total }}</td>
        </tr>
    </table>

    @foreach ($orderItems as $item)
    <table border="1">
        <tr>
            <td>Name</td>
            <td>{{{ $item['variation']['InternalItemID'] }}}</td>
        </tr>

        <tr>
            <td>Price</td>
            <td>${{{ $item['item']['UnitPrice'] }}} AUD</td>
        </tr>

        <tr>
            <td>Quantity</td>
            <td>{{{ $item['item']['Quantity'] }}}</td>
        </tr>

        @if (!empty($item['variation']['LocalFeeTitle']))
        <tr>
            <td>Local Fee Title </td>
            <td>{{{ $item['variation']['LocalFeeTitle'] }}}</td>
        </tr>

        <tr>
            <td>Local Fee {{{ $item['variation']['LocalFeeAddedToOrder'] ? '(in package)' : '' }}}</td>
            <td>${{{ $item['variation']['LocalFee'] }}} AUD</td>
        </tr>
        @endif

        <tr>
            <td>Date</td>
            <td>{{{ $event['Date'] }}}
                @if( $event['Start'] && $event['End'] )
                    (from {{{$event['Start']}}} to {{{$event['End']}}})
                @endif
            </td>
        </tr>

        @if (!empty($event['Description']))
            <tr>
                <td>Description</td>
                <td>{{{ $event['Description'] }}}</td>
            </tr>
        @endif

    </table>
    @endforeach

    <p>Thank you!</p>

</body>
</html>