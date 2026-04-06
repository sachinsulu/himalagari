 = 'includes\controllers\ajax.subscribers.php'
\ = Get-Content \ -Raw
\ = \ -replace "new MCAPI\('[^']*'\)", "new MCAPI(getenv('MAILCHIMP_API_KEY') ?: 'YOUR_API_KEY')"
Set-Content \ -Value \ -NoNewline
