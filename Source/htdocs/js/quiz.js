function elementFromHtml(html)
{
    const template = document.createElement('template');

    template.innerHTML = html.trim();

    return template.content.firstElementChild;
}

const createButton = document.querySelector('.create-question')

createButton.addEventListener('click', (event) =>
{
    createQuestion();
})

function createQuestion()
{
    var question = elementFromHtml(`
    <div class="question">
        <div class="form-field">
            <label>Question Text*</label>

            <input type="text" class="question-text" name="question[][text]" pattern="^.{8,}" required>
        </div>

        <div class="form-field">
            <label>Question Image</label>

            <input type="file" class="question-image" name="question[][image]">
        </div>

        <div class="form-field">
            <label>Question Hint</label>

            <input type="text" class="question-hint" name="question[][hint]">
        </div>

        <h3>Question Answers</h3>

        <div class="form-field">
            <label>Answer Type*</label>

            <select name="question[][type]" class="question-type" required>
                <option value="Multiple Choice">Multiple Choice</option>

                <option value="Short Answer">Short Answer</option>
            </select>
        </div>

        <div class="answers">
            <button class="white-button add-answer" type="button">Add Answer</button>
        </div>

        <button class="grey-button delete-question" type="button">Delete Question</button>
    </div>
    `);
    
    var questions = document.querySelector('.questions');
    var count = questions.childElementCount;

    questions.appendChild(question);

    document.getElementsByName('question[][text]')[0].name = `question[${count}][text]`;
    document.getElementsByName('question[][image]')[0].name = `question[${count}][image]`;
    document.getElementsByName('question[][hint]')[0].name = `question[${count}][hint]`;
    document.getElementsByName('question[][type]')[0].name = `question[${count}][type]`;

    var selectType = question.querySelector('.question-type');
    selectType.addEventListener('change', (event) =>
    {
        var answers = question.querySelector('.answers');

        answers.innerHTML = '';

        if (selectType.value == 'Multiple Choice')
        {
            for (let i = 0; i < 3; i++)
            {
                addAnswer(question);
            }

            var addButton = elementFromHtml(`<button class="white-button add-answer" type="button">Add Answer</button>`);
            addButton.addEventListener('click', (event) =>
            {
                addAnswer(question);
            });

            answers.appendChild(addButton);
        }

        else 
        {
            const index = Array.from(document.querySelector('.questions').children).indexOf(question);

            var answerHeading = elementFromHtml(`
            <h3>Short Answers Keywords (Seperated by Comma ",")*</h3>
            `);

            var shortAnswer = elementFromHtml(`
            <div class="form-field">
                <textarea name="question[${index}][answer][text]"></textarea>
            </div>
            `);

            answers.appendChild(answerHeading);
            answers.appendChild(shortAnswer);
        }
    });

    for (let i = 0; i < 3; i++)
    {
        addAnswer(question);
    }

    var addButton = question.querySelector('.add-answer');
    addButton.addEventListener('click', (event) =>
    {
        addAnswer(question);
    });

    var deleteButton = question.querySelector('.delete-question');
    deleteButton.addEventListener('click', (event) =>
    {
        question.remove();
        calibrateQuestions();
    });
}

function calibrateQuestions()
{
    var questions = document.querySelectorAll('.question');
    var count = 0;

    questions.forEach(question =>
    {
        var text = question.querySelector('.question-text');
        var image = question.querySelector('.question-image');
        var hint = question.querySelector('.question-hint');
        var type = question.querySelector('.question-type');

        text.name = `question[${count}][text]`;
        image.name = `question[${count}][image]`;
        hint.name = `question[${count}][hint]`;
        type.name = `question[${count}][type]`;

        calibrateAnswers(question);

        count++;
    });
}

function addAnswer(question) 
{
    const index = Array.from(document.querySelector('.questions').children).indexOf(question);

    var answer = elementFromHtml(`
    <div class="answer" draggable="true">
        <input type="text" class="answer-text" name="question[][answer][][text]" required>

        <label class="radio">
            <input type="radio" class="answer-radio" name="question[][correct]" required>

            <div class="checkmark"></div>
        </label>

        <button class="grey-button delete-answer" type="button">Delete</button>
    </div>
    `);

    var answers = question.querySelector('.answers');
    var addButton = answers.querySelector('.add-answer');

    const count = answers.querySelectorAll('.answer').length;

    answers.insertBefore(answer, addButton);

    document.getElementsByName('question[][answer][][text]')[0].name = `question[${index}][answer][${count}][text]`;
    document.getElementsByName('question[][correct]')[0].value = count;
    document.getElementsByName('question[][correct]')[0].name = `question[${index}][correct]`;

    var deleteButton = answer.querySelector('.delete-answer');
    deleteButton.addEventListener('click', (event) =>
    {
        answer.remove();
        calibrateAnswers(question);
    });
}

function calibrateAnswers(question)
{
    const index = Array.from(document.querySelector('.questions').children).indexOf(question);
    var answers = question.querySelectorAll('.answer');
    var type = question.querySelector('select').value;

    if (type == 'Multiple Choice')
    {
        var count = 0;

        answers.forEach(answer => 
        {
            var text = answer.querySelector('.answer-text');
            var radio = answer.querySelector('.answer-radio');

            text.name = `question[${index}][answer][${count}][text]`;
            radio.name = `question[${index}][correct]`;
            radio.value = count;

            count++;
        });
    }

    else 
    {

    }
}

