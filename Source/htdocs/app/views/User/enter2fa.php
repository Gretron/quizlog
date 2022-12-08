<html>
<head>
    <title>Quizlog: Enter 2FA</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/user.css" rel="stylesheet">

<div class="content">
    <h1>Enter 2-Factor Authentication</h1>

    <form class="user-form" method="post">
        <div class="form-field">
            <label>Authentication Code</label>

            <input type="text" name="token">
        </div>

        <button class="orange-button" style="margin-bottom: 0;" type="submit" name="submit">Enter</button>
    </form>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>