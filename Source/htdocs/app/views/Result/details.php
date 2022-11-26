<html>
<head>
    <title>Quizlog: Result Details</title>
</head>

<body>
<?php include_once('app/views/header.php'); ?>

<link href="/css/card.css" rel="stylesheet">

<div class="content">
    <h1>'<?= $data['result']->ResultName; ?>' Result Details</h1>

    <div class="choice-cards">
        <div class="banner" >
            <object data="<?= !empty($data['result']->ResultImage) ? '/img/' . $data['result']->ResultImage : '/img/pattern.png'; ?>" type="image/png">
                <img src="/img/pattern.png">
            </object>

            <div class="card-score">
                <h3><?= $data['result']->ResultScore; ?>%</h3>

                <h4><?= "{$data['result']->RightAnswers} out of {$data['result']->QuestionCount} Questions" ?></h4>

                <div class="score-bar">
                    <div style="width: <?= $data['result']->ResultScore; ?>%; background-color: var(--<?= $data['result']->ResultScore < 66 ? ($data['result']->ResultScore < 33 ? 'grey' : 'white') : 'orange'; ?>)"></div>
                </div>
            </div>
        </div>

        <?php $count = 1; ?>

        <?php foreach($data['choices'] as $choice): ?>

        <div class="choice-card">
            <h2>Question <?= $count++; ?></h2>

            <img class="card-image" src="<?= !empty($choice->QuestionImage) ? '/img/' . $choice->QuestionImage : '/img/pattern.png'; ?>">

            <h4><?= $choice->QuestionText; ?></h3>

            <div class="choice-options">
            <?php if ($choice->ChoiceType == 'Multiple Choice'): ?>

                <?php if ($choice->ChoiceText == $choice->CorrectText): ?>

                <div class="correct-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path d="M11.707,15.707C11.512,15.902,11.256,16,11,16s-0.512-0.098-0.707-0.293l-4-4c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0L11,13.586l8.35-8.35C17.523,3.251,14.911,2,12,2C6.477,2,2,6.477,2,12c0,5.523,4.477,10,10,10s10-4.477,10-10 c0-1.885-0.531-3.642-1.438-5.148L11.707,15.707z" fill="#5B5B5B" />
                    </svg>

                    <?= $choice->CorrectText; ?>
                </div>

                <?php else: ?>

                <div class="wrong-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M12,2C6.47,2,2,6.47,2,12c0,5.53,4.47,10,10,10s10-4.47,10-10C22,6.47,17.53,2,12,2z M16.707,15.293 c0.391,0.391,0.391,1.023,0,1.414C16.512,16.902,16.256,17,16,17s-0.512-0.098-0.707-0.293L12,13.414l-3.293,3.293 C8.512,16.902,8.256,17,8,17s-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414L10.586,12L7.293,8.707 c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L12,10.586l3.293-3.293c0.391-0.391,1.023-0.391,1.414,0 s0.391,1.023,0,1.414L13.414,12L16.707,15.293z" fill="#5B5B5B" />
                    </svg>

                    <?= empty($choice->ChoiceText) ? 'No Answer' : $choice->ChoiceText; ?> (Your Answer)
                </div>

                <div class="correct-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M11.707,15.707C11.512,15.902,11.256,16,11,16s-0.512-0.098-0.707-0.293l-4-4c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0L11,13.586l8.35-8.35C17.523,3.251,14.911,2,12,2C6.477,2,2,6.477,2,12c0,5.523,4.477,10,10,10s10-4.477,10-10 c0-1.885-0.531-3.642-1.438-5.148L11.707,15.707z" fill="#5B5B5B" />
                    </svg>

                    <?= $choice->CorrectText; ?>
                </div>

                <?php endif; ?>
            <?php else: ?>
                <?php 
                
                $matches = explode(',', $choice->CorrectText);

                $correct = true;

                foreach ($matches as $match)
                {
                    if (stripos($choice->ChoiceText, $match) === false)
                    {
                        $correct = false;
                        break;
                    }
                }

                ?>

                <?php if ($correct): ?>

                <div class="correct-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M11.707,15.707C11.512,15.902,11.256,16,11,16s-0.512-0.098-0.707-0.293l-4-4c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0L11,13.586l8.35-8.35C17.523,3.251,14.911,2,12,2C6.477,2,2,6.477,2,12c0,5.523,4.477,10,10,10s10-4.477,10-10 c0-1.885-0.531-3.642-1.438-5.148L11.707,15.707z" fill="#5B5B5B" />
                    </svg>

                    <?= $choice->ChoiceText; ?>
                </div>

                <?php else: ?>

                <div class="wrong-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M12,2C6.47,2,2,6.47,2,12c0,5.53,4.47,10,10,10s10-4.47,10-10C22,6.47,17.53,2,12,2z M16.707,15.293 c0.391,0.391,0.391,1.023,0,1.414C16.512,16.902,16.256,17,16,17s-0.512-0.098-0.707-0.293L12,13.414l-3.293,3.293 C8.512,16.902,8.256,17,8,17s-0.512-0.098-0.707-0.293c-0.391-0.391-0.391-1.023,0-1.414L10.586,12L7.293,8.707 c-0.391-0.391-0.391-1.023,0-1.414s1.023-0.391,1.414,0L12,10.586l3.293-3.293c0.391-0.391,1.023-0.391,1.414,0 s0.391,1.023,0,1.414L13.414,12L16.707,15.293z" fill="#5B5B5B" />
                    </svg>

                    <?= empty($choice->ChoiceText) ? 'No Answer' : $choice->ChoiceText; ?> (Your Answer)
                </div>

                <div class="correct-choice">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path d="M11.707,15.707C11.512,15.902,11.256,16,11,16s-0.512-0.098-0.707-0.293l-4-4c-0.391-0.391-0.391-1.023,0-1.414 s1.023-0.391,1.414,0L11,13.586l8.35-8.35C17.523,3.251,14.911,2,12,2C6.477,2,2,6.477,2,12c0,5.523,4.477,10,10,10s10-4.477,10-10 c0-1.885-0.531-3.642-1.438-5.148L11.707,15.707z" fill="#5B5B5B" />
                    </svg>

                    Keywords: <?= $choice->CorrectText; ?>
                </div>

                <?php endif ?>
            <?php endif; ?>
            </div>
        </div>

        <?php endforeach; ?>
    </div>
</div>

<?php include_once('app/views/footer.php'); ?>
</body>
</html>