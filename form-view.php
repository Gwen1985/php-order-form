<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Order food & drinks</title>
</head>
<body>
<div class="container">
    <h1>Order food in restaurant "the Personal Ham Processors"</h1>
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    <form method="post" action="<?php echo($_SERVER["PHP_SELF"]); ?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="text" id="email" name="email" class="form-control"/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="streetNr">Street number:</label>
                    <input type="text" id="streetNr" name="streetNr" class="form-control">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control">
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <input type="checkbox" value="1" name="product[<?php echo $i ?>]"/> <?php echo $product['name'] ?>
                    -
                    &euro; <?php echo number_format($product['price'], 2) ?></label><br/>
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" class="btn btn-primary">Order!</button>
    </form>

    <?php

    //-----------------------------FORM-VALIDATION----------------------------------------------------------------------
    //set variables
    $nameFirst = $nameLast = $email = "";

    $addressStreet = (isset($_SESSION["address-street"])) ? $_SESSION['address-street'] : '';
    $addressNumber = (isset($_SESSION["address-number"])) ? $_SESSION['address-number'] : '';
    $addressZip = (isset($_SESSION["address-zip"])) ? $_SESSION['address-zip'] : '';
    $addressCity = (isset($_SESSION["address-city"])) ? $_SESSION['address-city'] : '';

    $nameFirstError = $nameLastError = $emailError = $addressStreetError = $addressNumberError = $addressZipError = $addressCityError = $productError = "";

    $errorPrefix = '<p class="text-red-500 text-xs italic" >';
    $errorSuffix = '</p >';
    $errorRequiredText = 'This field is required.';
    $errorRequiredProductText = 'Please select at least 1 product to order.';
    $errorMailText = 'Please enter a valid e-mail address.';
    $isFormValid = true;

    //------------------------------------------------EMAIL-------------------------------------------------------------

    if (!empty($_POST['email'])) {
        // CHECK IF EMAIL IS VALID
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $isFormValid = false;
            $emailError = $errorPrefix . $errorMailText . $errorSuffix;
        }
    } else {
        $isFormValid = false;
        $emailError = $errorPrefix . $errorRequiredText . $errorSuffix;
    }
    //---------------------------------------------STREET---------------------------------------------------------------

    if (!empty($_POST['address-street'])) {
        $addressStreet = sanitizeData($_POST['address-street']);
    } else {
        $isFormValid = false;
        $addressStreetError = $errorPrefix . $errorRequiredText . $errorSuffix;
    }
    //----------------------------------------------STREETNR------------------------------------------------------------

    if (!empty($_POST['address-number'])) {
        $addressNumber = sanitizeData($_POST['address-number']);
    } else {
        $isFormValid = false;
        $addressNumberError = $errorPrefix . $errorRequiredText . $errorSuffix;
    }
    //----------------------------------------------CITY----------------------------------------------------------------

    if (!empty($_POST['address-city'])) {
        $addressCity = sanitizeData($_POST['address-city']);
    } else {
        $isFormValid = false;
        $addressCityError = $errorPrefix . $errorRequiredText . $errorSuffix;
    }
    //-----------------------------------------------ZIPCODE------------------------------------------------------------

    if (!empty($_POST['address-zip'])) {
        $addressZip = sanitizeData($_POST['address-zip']);
    } else {
        $isFormValid = false;
        $addressZipError = $errorPrefix . $errorRequiredText . $errorSuffix;

        //--------------------------------------PRODUCTS--------------------------------------------------------------------

        if (!empty($_POST['product'])) {
            $orderedProducts = $_POST['product'];
        } else {
            $isFormValid = false;
            $productError = $errorPrefix . $errorRequiredProductText . $errorSuffix;
        }

        if ($isFormValid) {
//            echo 'Name first: ' . $nameFirst . '<br />';
//            echo 'Name last: ' . $nameLast . '<br />';
//            echo 'Email: ' . $email . '<br />';
//            echo 'Address street: ' . $addressStreet . '<br />';
//            echo 'Address number: ' . $addressNumber . '<br />';
//            echo 'Address zip: ' . $addressZip . '<br />';
//            echo 'Address city: ' . $addressCity . '<br />';
            $orderAmount = calculateOrderAmount($products, $orderedProducts);
            //echo 'Order amount: ' . $orderAmount . '<br />';
            storeOrderAmount($orderAmount);

            //------------------------------------------------------------------------------------------------------------------
            // ADD FIELDS TO SESSION
            $_SESSION["address-street"] = $addressStreet;
            $_SESSION["address-number"] = $addressNumber;
            $_SESSION["address-zip"] = $addressZip;
            $_SESSION["address-city"] = $addressCity;

            // DELIVERY TIME AND DATE
            $date = new DateTime("now", new DateTimeZone('Europe/Brussels'));
            $timeNormalDelivery = date("H:i:s", strtotime('+2 hours', strtotime($date->format('H:i'))));
            $timeExpressDelivery = date("H:i:s", strtotime('+45 minutes', strtotime($date->format('H:i'))));
            $timeDelivery = $timeNormalDelivery;

            $productsText = '';
            foreach ($orderedProducts as $orderedProduct) {
                $productsText .= $orderedProduct . '<br />';
            }

            $productsText1 = createOrderTable($products, $orderedProducts);

            $bodyText = '<p>Hello, </p>';
            $bodyText .= '<p>You ordered the following at The shop:</p><p>' . $productsText1 . '</p>';
            $bodyText .= '<p>The order address is ' . $addressStreet . ' ' . $addressNumber . ', ' . $addressZip . ' ' . $addressCity . '</p>';
            $bodyText .= '<p>Your order wil be ready at <strong>' . $timeDelivery . '</strong> . The total amount is <strong>' . $orderAmount . 'eur</strong></p>';
            $bodyText .= '<p>Thanks for your order.</p>';

            //SEND MAIL
            $mailArray = [
                'toAddress' => 'gwen.ellegeest@outlook.com',
                'toName' => 'Gwen Ellegeest',
                'subject' => 'Your order from the restaurant ',
                'body' => $bodyText,
            ];

            try {
                $mail = new Mailer(true, $mailArray);
                $mail->send();
            } catch (Exception $e) {
                //Note that this is catching the PHPMailer Exception class, not the global \Exception type!
                echo 'Caught a ' . get_class($e) . ': ' . $e->getMessage();
            }

            // RESET FORM FIELDS
            $nameFirst = $nameLast = $email = $addressStreet = $addressNumber = $addressZip = $addressCity = "";
        }

    }

    function sanitizeData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //-----------------------------------------GET--SERVER--INFO--------------------------------------------------------

    //get server info
    //    $server = [
    //        'Server Name' => $_SERVER['SERVER_NAME'],
    //        'Host Header' => $_SERVER['HTTP_HOST'],
    //        'Server Software' => $_SERVER['SERVER_SOFTWARE'],
    //        'Document Root' => $_SERVER['DOCUMENT_ROOT'],
    //        'Current Page' => $_SERVER['PHP_SELF'],
    //        'Script Name' => $_SERVER['SCRIPT_NAME'],
    //        'Absolute Path' => $_SERVER['SCRIPT_FILENAME']
    //    ];
    //
    //    print_r($server);
    //-----------------------------------------------------------------------------
    require('product.php');
    ?>

    <footer>You already ordered <strong>&euro; <?php echo $totalValue ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>