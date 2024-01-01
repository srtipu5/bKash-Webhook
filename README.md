
# bKash Webhook
```
bKash Merchant user will notify instant payment notification from bKash through shared webhook endpoint.
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
# Test SubscriptionConfirmation (Send Body Data In Text Format)
```

{
  "Type" : "SubscriptionConfirmation",
  "MessageId" : "23e15778-4537-43a0-9463-17deb7c7d45a",
  "Token" : "2336412f37fb687f5d51e6e2425c464dec3a5656dc29c02e8392163baeebaf4b9e192e761a6b6f78ef2b4512a7c69f04382b4f39041d13a7aa49f95ced53d3079f61e479220cbdca5b6eb8bc402211823c1852cf0e4ff14670fcc44de66f4596f66eb3ff1837f1ae883dd8ebc00c1487e1072f444238f586465dca7de74a73c7",
  "TopicArn" : "arn:aws:sns:ap-southeast-1:797962984373:bpt_01953337616_SANDBOX",
  "Message" : "You have chosen to subscribe to the topic arn:aws:sns:ap-southeast-1:797962984373:bpt_01953337616_SANDBOX.\nTo confirm the subscription, visit the SubscribeURL included in this message.",
  "SubscribeURL" : "https://sns.ap-southeast-1.amazonaws.com/?Action=ConfirmSubscription&TopicArn=arn:aws:sns:ap-southeast-1:797962984373:bpt_01953337616_SANDBOX&Token=2336412f37fb687f5d51e6e2425c464dec3a5656dc29c02e8392163baeebaf4b9e192e761a6b6f78ef2b4512a7c69f04382b4f39041d13a7aa49f95ced53d3079f61e479220cbdca5b6eb8bc402211823c1852cf0e4ff14670fcc44de66f4596f66eb3ff1837f1ae883dd8ebc00c1487e1072f444238f586465dca7de74a73c7",
  "Timestamp" : "2023-09-25T06:21:17.211Z",
  "SignatureVersion" : "1",
  "Signature" : "I45oapqRlJ/H6px8jElXvXGe6JTaJDa1AqvSTU9wTV+xRRpFY3+bM5MQacaukvyGosOxhN9rsaVSQASpSbzRl8wKGygB+DXQP85i7GoPUr8/ZzuUQM5TW9HFz5xVcrSv8sqLtumybNLNqqObhwJiD542FYI0amjp0dQbCYNNpzUC0wVO47ASmrSoS0zVltG82/t5BoXfyUkZOdFrkTy7MyzpFpVFBtG4d86//TOKOMsYA+q+j3V1knMu1raB9IcFlv/hHoGvo00jyzrYJn7+icdANVsc1OVnLNUc1LXf3P0tSxzojzbSzv2VK+A/K3/pEoJvLA1n2GKMgwYJty3fGQ==",
  "SigningCertURL" : "https://sns.ap-southeast-1.amazonaws.com/SimpleNotificationService-01d088a6f77103d0fe307c0069e40ed6.pem"
}
```
# Test Notification (Send Body Data In Text Format)
```
{
  "Type" : "Notification",
  "MessageId" : "0a406933-62d3-545e-812c-34bfc8fe280e",
  "TopicArn" : "arn:aws:sns:ap-southeast-1:797962984373:bpt_01953337616",
  "Message" : "{\"debitMSISDN\":\"01708517919\",\"creditOrganizationName\":\"bKash SANDBOX\",\"creditShortCode\":\"01953337616\",\"trxID\":\"AIQ6Q2E1NK\",\"transactionStatus\":\"Completed\",\"transactionType\":\"10002294\",\"amount\":\"1.0\",\"currency\":\"BDT\",\"dateTime\":\"20230926154413\"}",
  "Timestamp" : "2023-09-26T09:44:13.739Z",
  "SignatureVersion" : "1",
  "Signature" : "e9YYu8h0g5ywwNyJGQ+sWh8gm/VSOH9PNUlxH9X++ojPI1xvEgEjhnTfhyeB9LSDwO1kwcTMLpYtpQjY20bQ2t15QromF/99x4cjRaAdMpgpxW712FmROHxzctMcLMWSS1DWmnONDzSa6yJ18pFZa9aM/+ypFIW8MR75g+Fyt/ZEyD9GJh0OCBfz1CqlyvjSGo+ERl3TVOxSQiezzbUrRASSZWNTmEgdSM6WNqGsFWrTapzTGd8EPSh+BMYbllvTHEsLvogv16w4X0aqNK9GpfJ5XIskfkUIqib80WvIAglL2+cNWxDPehBUEJ3BQvogUNQBdn8M5ys/qQA5wAraNg==",
  "SigningCertURL" : "https://sns.ap-southeast-1.amazonaws.com/SimpleNotificationService-01d088a6f77103d0fe307c0069e40ed6.pem",
  "UnsubscribeURL" : "https://sns.ap-southeast-1.amazonaws.com/?Action=Unsubscribe&SubscriptionArn=arn:aws:sns:ap-southeast-1:797962984373:bpt_01953337616:f6c1cafb-6029-4dbf-9003-6ff2b23e9757"
}
```