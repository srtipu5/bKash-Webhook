
# bKash Webhook
```
bKash merchant user will notify instant payment notification from bKash through shared webhook endpoint. bKash will notify subscription payload once but will notify payment payload after every successful transactions.Both payload format is text.
```
# Web.php Setup
```
Route::post('/bkash-webhook', [App\Http\Controllers\WebhookController::class, 'webhookListener'])->name('bkash-webhook');
```
# Add Controller
```
Create a new Controller named 'WebhookController'
Controller Location --- App\Http\Controllers\WebhookController
You can now copy paste whole code from this project 'WebhookController.php'
```

# Sample Subscription Confirmation Payload
```
{
"Type" : "SubscriptionConfirmation",
"MessageId" : "165545c9-2a5c-472c-8df2-7ff2be2b3b1b",
"Token" : "2336412f37fb687f5d51e6e241d09c805a5a57b30d712f794cc5f6a988666d92768dd60a747ba6f3beb71854e285d6ad02428b09ceece29417f1f02d609c582afbacc99c583a916b9981dd2728f4ae6fdb82efd087cc3b7849e05798d2d2785c03b0879594eeac82c01f235d0e717736",
"TopicArn" : "arn:aws:sns:us-west-2:123456789012:MyTopic",
"Message" : "You have chosen to subscribe to the topic arn:aws:sns:us-west-2:123456789012:MyTopic.\nTo confirm the subscription, visit the SubscribeURL included in this message.",
"SubscribeURL" : "https://sns.us-west-2.amazonaws.com/?Action=ConfirmSubscription&TopicArn=arn:aws:sns:us-west-2:123456789012:MyTopic&Token=2336412f37fb687f5d51e6e241d09c805a5a57b30d712f794cc5f6a988666d92768dd60a747ba6f3beb71854e285d6ad02428b09ceece29417f1f02d609c582afbacc99c583a916b9981dd2728f4ae6fdb82efd087cc3b7849e05798d2d2785c03b0879594eeac82c01f235d0e717736",
"Timestamp" : "2012-04-26T20:45:04.751Z",
"SignatureVersion" : "1",
"Signature" : "EXAMPLEpH+DcEwjAPg8O9mY8dReBSwksfg2S7WKQcikcNKWLQjwu6A4VbeS0QHVCkhRS7fUQvi2egU3N858fiTDN6bkkOxYDVrY0Ad8L10Hs3zH81mtnPk5uvvolIC1CXGu43obcgFxeL3khZl8IKvO61GWB6jI9b5+gLPoBc1Q=",
"SigningCertURL" : "https://sns.us-west-2.amazonaws.com/SimpleNotificationService-f3ecfb7224c7233fe7bb5f59f96de52f.pem"
}
```

# Sample Payment Payload
```
{
  "Type" : "Notification",
  "MessageId" : "20d48143-6af4-571d-b7cb-d211e6a2ac69",
  "TopicArn" : "arn:aws:sns:ap-southeast-1:354285753755:bpt_01823072645",
  "Message" :
       {
       "dateTime":"20180419122246",
       "debitMSISDN":"8801700000001",
       "creditOrganizationName":"Org 01",
       "creditShortCode":"01929918***",
       "trxID":"4J420ANOXC",
       "transactionStatus":"Completed",
       "transactionType":"1003",
       "amount":"100",
       "currency":"BDT",
       "transactionReference":"User inputed reference value",
       "merchantInvoiceNumber": "orderId1233"
       },
  "Timestamp" : "2018-04-19T12:22:46.236Z",
  "SignatureVersion" : "1",
  "Signature" : "jZBoouSuStaUqYZY+mruc3r3ST58CPkzjOu8i65dDIReWDcNAvPGUpNDSCBBMVLLA6UIJ9KtvTmop+JefiAd/8+YOxR738j0AXDcWc0A4u1EaMWqnmLvFufC0rAkEQuHdzn+XpHSET8Vn9SsnDJMsmdnWIiqH6JDsuPImuzP6V4Fh9/EKOYVOSks5aNChD1fwPQ1Z6DmtpEVaEXKagWXO8yPPAgs5meDArV7qIm93devI3DzfJboF1DOqHL9JkIrj5S9+ZqybCNKl3ay1JkgY9BXPoRe3XCzUSd4zTXa6GDbH7+3KZ3wmsiaa2zfwYCmrFNvzuE5o6OkeNHE/mqyCA==",
  "SigningCertURL" : "https://sns.ap-southeast-1.amazonaws.com/SimpleNotificationService-ac565b8b1a6c5d002d285f9598aa1d9b.pem",
  "UnsubscribeURL" : "https://sns.ap-southeast-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:ap-southeast-1:354285753755:bpt_01823072645:ddc1093b-2885-4179-ae8f-961577b564bd"
}
```
# bKash Requirement
```
(1) Merchant Name
(2) Merchant wallet Number(s)
(3) Notification channel email address
(4) Webhook Endpoint
```
# Note
```
bKash will send payload as text format
```
