PHP Sample Payment Pages
------------------------

To get the sample pages working
-------------------------------
In the file Config.php, you need to edit the following variables:

1) MerchantID & Password - these need to be set to the MerchantID & Password for your gateway account (you would have been created a test gateway account during initial registration) - the details of all your gateway accounts (both test and production) are sent out to you on creation, in a New Gateway Account email.

2) SiteSecureBaseURL - this needs to be the base URL of the payment pages for your environment - e.g. "https://www.yoursite.com/Pages/". This path can also be a local path if you are testing the sample payment form in a local development environment (e.g. "http://localhost:4512/MySite/"). This path MUST include the trailing slash "/". 

3) PaymentProcessorDomain & PaymentProcessorPort - these need to be set to the domain and port for your payment processor entry points
   e.g. if your payment processor has entry points of the form "https://gwX.paymentprocessor.net:4430/", then             
           PaymentProcessorDomain = "paymentprocessor.net" 
           PaymentProcessorPort = "4430"
        if your payment processor has entry points of the form "https://gwX.thepaymentgateway.net/", then                         
           PaymentProcessorDomain = "thepaymentgateway.net"
           PaymentProcessorPort = "443" 

4) SecretKey - this is a secret key that is known ONLY to your system. It is used to generate the hash keys that "sign" the data that is transmitted between the various pages (e.g. StartHere.php page and PaymentForm.php). The reason that this data is "signed" is because it the mechanism by which it is transmitted is the customer's browser. The use of has keys means that if the customer tampers with this data in any way (e.g. lowering the amount down from £100.00 to £1.00) then this tampering is detectable. The payment form will work with the secret key supplied, but it is STRONGLY recommended that you change this to something else before using the payment form in a production environment.

|-------------------------------------------------------|
| The entry point for the sample pages is StartHere.php |
|-------------------------------------------------------|

Integrating the payment form into your system
---------------------------------------------
How you use the sample code will depend on your shopping cart package, and what it allows you to do. Generally, there will be 2 types of integration scenarios:

1) You are writing your own bespoke shopping cart package, and have complete freedom to implement the payment page in its entirety (this will be more likely if the shopping cart that you have written doesn't yet have a payment page, or plug into any other payment providers)

2) You are using a pre-written shopping cart, or have a bespoke shopping cart that is already integrated into other payment providers and already has a generalised payment form system that works with all of the other processors

Scenario 1
----------
Scenario 1 would allow you to use the sample payment form in its entirety. You would only manage the passing of data to the payment form, which would then basically handle the payment and the displaying of the transaction results to the customer. There is an empty "hook" function that is available in the PaymentFormHelper class - "ReportTransactionResults()", that allows you to run any updates to your system/database based on the results of the transaction that has just been processed. This function is called by the payment form when the transaction status changes, and all you would need to do is put your system-specific code in here to perform whatever post-processing tasks you need to. TIP: We recommend that you minimise the amount of actual lines of code that goes into this function (by using calls to sub functions in *your* files) - that means that the actual difference between your modified version of this file and the original is minimised (which will be extremely helpful if you ever need to update your versions of our files with any newer versions - e.g. to implement bugfixes etc).

Scenario 2
----------
Scenario 2 means that you would not be able just drop the payment form into your system as a complete and functioning form. Even though, this means that most of the sample payment form code will not of much interest (apart from as an example of a fully functioning payment form), there are some part of it that will be of great interest:

1) /ThePaymentGateway/TPG_Common.php, /ThePaymentGateway/PaymentSystem.php and /ThePaymentGateway/SOAP.php - these files are what we consider to be the "Integration Library" and they contains PHP native classes that handle ALL of the communications with the gateway. ALL the other PHP files in this example are what we consider to be the "Sample Payment Form", which is an example of an application that USES the "Integration Library". Understanding the separation between these 2 ideas will be key to maximising full use of the "Integration Library"

2) ProcessPayment.php and ThreeDSecureAuthentication.php - these files contain code that will demonstrate how to use the "Integration Library" classes to speak to the gateway. You can use these as a guide when contructing your own integration.

IMPORTANT THINGS TO NOTE
------------------------
- When you receive your production gateway account details (MerchantID and Password), you only need to change these details in your system to switch from your test account to your production account. You won't need to change ANY other details of the transaction messages, or where they get routed to.
- The gateway entry points will be included as part of the "New Gateway Account" email that you would have received from our system when this account was created. If you are developer who is NOT the merchant, then this email will have been sent to the merchant - in this case, you could get this information by requesting a copy of the "New Gateway Account" email from the merchant directly.
- Our test gateway accounts will ONLY work with the test card details that are in the back of the integration documents. You will not be able to process any "real" credit cards through your test account, just as you will not be able to process any test credit cards through your production account. This is intended to stop merchants accidently going live with their test account, and sending out real good based on what they think are real transactions (but are actually test ones)

=======================================================================
!! SUPER IMPORTANT - IF YOU DON'T READ ANYTHING ELSE, THEN READ THIS !!
=======================================================================
- The "Integration Library" makes the process of developing custom integrations MUCH easier - the classes contained do 95% of the heavy lifting of the integration. Using them can MASSIVELY reduce the amount of time it takes to complete (and so reduce the cost of) the integration process. They are also very mature and stable, and are in use by many of our existing merchants. If you find that you have to contract a developer to write a custom module for you, then we would STRONGLY recommend that you ask them to use the "Integration Library" files as a basis for their integration.