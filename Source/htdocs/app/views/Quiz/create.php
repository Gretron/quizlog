<html>
<head>
    <title>Quizlog: Create</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/create.css" rel="stylesheet">

<script type="text/javascript" src="/js/quiz.js" defer></script>
<script type="text/javascript" src="/js/create.js" defer></script>

<div class="content">
    <h1>Create Quiz</h1>

    <?php if (isset($_GET['error'])): ?>

    <div class="error"><?= $_GET['error']; ?></div>

    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="form-field">
            <label>Quiz Name*</label>

            <input type="text" name="quiz-name" pattern="^.{8,128}" required>
        </div>

        <div class="form-field">
            <label>Quiz Banner</label>

            <input type="file" name="quiz-banner">
        </div>

        <div class="form-field">
            <label>Quiz Description</label>

            <textarea name="quiz-description"></textarea>
        </div>

        <div class="form-field">
            <label>Quiz Privacy*</label>

            <select name="quiz-privacy">
                <option value="0">Private</option>
                <option value="1">Public</option>
            </select>
        </div>

        <div class="form-field">
            <label>Quiz Time*</label>

            <div class="form-time">
                <input type="number" name="quiz-hour" value="0" min="0" max="4">

                <label>H</label>
            </div>

            <div class="form-time">
                <input type="number" name="quiz-minute" value="0" min="0" max="59">

                <label>M</label>
            </div>

            <div class="form-time">
                <input type="number" name="quiz-second" value="0" min="0" max="59">

                <label>S</label>
            </div>
        </div>

        <h2>Questions</h2>

        <div class="questions">

        </div>

        <button class="white-button create-question" type="button">Create Question</button>

        <button class="orange-button" type="submit" name="submit">Create Quiz</button>
    </form>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>
