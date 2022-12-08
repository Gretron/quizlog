<html>
<head>
    <title>Quizlog: Setup 2FA</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/user.css" rel="stylesheet">

<div class="content">
    <h1>Setup 2-Factor Authentication</h1>

    <form class="user-form" method="post">
        <img src="http://localhost/User/makeQrCode?data=<?= $data ?>" /> 

        <div>
            Please scan the QR-code on the screen with your favorite Authenticator software, such as Google Authenticator. The 
            authenticator software will generate codes that are valid for 30 
            seconds only. Enter such a code while and submit it while it is 
            still valid to confirm that the 2-factor authentication can be 
            applied to your account.
        </div>

        <div class="form-field">
            <label>Authentication Code</label>

            <input type="text" name="token">
        </div>

        <button class="orange-button" style="margin-bottom: 0;" type="submit" name="submit">Setup</button>
    </form>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>