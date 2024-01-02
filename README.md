
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
# bKash Requirement
```
(1) Merchant Name
(2) Merchant wallet Number(s)
(3) Notification channel email address
(4) Webhook Endpoint
```
