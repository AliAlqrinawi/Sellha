<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay</title>
</head>
<body>
    <form action="{{ route('sendIdForPayment' , [$responseData->id , $order->id , $type]) }}" data-brands="{{ $type }}" class="paymentWidgets">VISA MASTER AMEX APPLEPAY</form>
    <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $responseData->id }}"></script>
    <script type="text/javascript">
        var wpwlOptions = {
        paymentTarget:"_top",
        }
        </script>
</body>
</html>
