<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('sendIdForPayment' , $responseData->id) }}" class="paymentWidgets">VISA MASTER AMEX</form>
    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $responseData->id }}"></script>
</body>
</html>
