window.onload = init()

function init()
{
    const questions = document.querySelector('.questions')

    for (let i = 0; i < 3; i++)
    {
        createQuestion(questions)
    }
}

const addQuestion = document.querySelector('.add-que')

addQuestion.addEventListener('click', (event) =>
{
    const questions = document.querySelector('.questions')

    createQuestion(questions)
})

// Create Question Using Questions Container
function createQuestion(questions)
{
    // Get Count of Existing Questions
    let count = questions.querySelectorAll('.que').length;

    // Create Question
    const id = 'q'.concat(count)

    // Create Container
    let container = document.createElement('div')
    container.id = id
    container.className = 'que box pad-16'
    container.draggable = true

    let hidden = document.createElement('input')
    hidden.className = 'id'
    hidden.type = 'hidden'
    hidden.value = 'set'
    hidden.name = id

    container.appendChild(hidden)

    // Create Question Text Field
    let text = document.createElement('div')
    text.className = 'que-txt'

    let textLabel = document.createElement('label')
    textLabel.className = 'lbl-s'
    textLabel.innerHTML = 'Question Text*'

    let textInput = document.createElement('input')
    textInput.className = 'field'
    textInput.type = 'text'
    textInput.name = id.concat('-txt')
    textInput.required = true

    text.appendChild(textLabel)
    text.appendChild(textInput)

    container.appendChild(text)

    // Create Question Image Field
    let image = document.createElement('div')
    image.className = 'que-img'

    let imageLabel = document.createElement('label')
    imageLabel.className = 'lbl-s'
    imageLabel.innerHTML = 'Question Image'

    let imageInput = document.createElement('input')
    imageInput.type = 'file'
    imageInput.name = id.concat('-img')

    image.appendChild(imageLabel)
    image.appendChild(imageInput)

    container.appendChild(image)

    // Create Question Hint Field
    let hint = document.createElement('div')
    hint.className = 'que-hint'

    let hintLabel = document.createElement('label')
    hintLabel.className = 'lbl-s'
    hintLabel.innerHTML = 'Question Hint:'

    let hintInput = document.createElement('input')
    hintInput.className = 'field'
    hintInput.type = 'text'
    hintInput.name = id.concat('-hint')

    hint.appendChild(hintLabel)
    hint.appendChild(hintInput)

    container.appendChild(hint)

    // Create Question Answers Heading
    let heading = document.createElement('div')
    heading.className = 'h-3'
    heading.innerHTML = 'Question Answers'

    container.appendChild(heading)

    // Create Answers Area
    let answersArea = document.createElement('div')

    let typeLabel = document.createElement('div')
    typeLabel.className = 'h-4'
    typeLabel.innerHTML = 'Answers Type:'

    let selectType = document.createElement('select')
    selectType.name = id.concat('-type')
    selectType.className = 'ans-type field'

    let option0 = document.createElement('option')
    option0.value = 'Multiple Choice'
    option0.innerHTML = 'Multiple Choice'
    option0.selected = true

    let option1 = document.createElement('option')
    option1.value = 'Short Answer'
    option1.innerHTML = 'Short Answer'

    selectType.addEventListener('change', (event) =>
    {
        // Get Question Id
        const id = event.target.closest('.que').id

        // Get Answers Container
        var answers = event.target.parentNode.querySelector('.answers')

        // Clear Child Elements
        answers.innerHTML = '';

        // If Multiple Choice Was Selected...
        if (event.target.value == "Multiple Choice")
        {
            // Create 3 Fields
            for (let i = 0; i < 3; i++)
            {
                createAnswer(answers)
            }

            // Create Add Answer Button
            let add = document.createElement('button')
            add.className = 'add-ans btn-l'
            add.type = 'button'
            add.innerHTML = 'Add Answer'
            add.addEventListener('click', (event) =>
            {
                const answers = event.target.closest('.answers')

                createAnswer(answers)
            })

            answers.appendChild(add)
        }

        // If Short Answer Was Selected...
        else
        {
            let container = document.createElement('div')
            container.className = 'ans short-ans'

            let label = document.createElement('div')
            label.className = 'lbl-s'
            label.innerHTML = 'Short Answers Keywords (Seperated by Comma ",")*'

            let textArea = document.createElement('textarea')
            textArea.className = 'ans-txt field'
            textArea.name = id.concat('-a0-txt')
            textArea.required = true

            container.appendChild(label)
            container.appendChild(textArea)

            answers.appendChild(container)
        }
    })

    selectType.appendChild(option0)
    selectType.appendChild(option1)

    let answersBox = document.createElement('div')
    answersBox.className = 'answers box pad-16'

    // Add Add Answer Button
    let addAnswer = document.createElement('button')
    addAnswer.className = 'add-ans btn-l'
    addAnswer.type = 'button'
    addAnswer.innerHTML = 'Add Answer'
    addAnswer.addEventListener('click', (event) =>
    {
        const answers = event.target.closest('.answers')

        createAnswer(answers)
    })

    answersBox.appendChild(addAnswer)

    // Add Components to Answer Area
    answersArea.appendChild(typeLabel)
    answersArea.appendChild(selectType)
    answersArea.appendChild(answersBox)

    // Add Answer Area to Question
    container.appendChild(answersArea)

    // Add Delete Question Button
    let deleteQuestion = document.createElement('button')
    deleteQuestion.className = 'del-que btn-d'
    deleteQuestion.innerHTML = 'Delete Question'
    deleteQuestion.addEventListener('click', (event) =>
    {
        const questions = event.target.closest('.questions')
        event.target.closest('.que').remove()
        calibrateQuestions(questions)
    })

    container.appendChild(deleteQuestion)

    // Add Question to Questions
    questions.appendChild(container)

    // Add Answers to Answers Box
    for (let i = 0; i < 3; i++)
    {
        createAnswer(answersBox)
    }
}

// Calibrate Question Ids Using Questions Container
function calibrateQuestions(questions)
{
    // Get All Answers in Container
    let items = questions.querySelectorAll('.que')

    // Start Count
    let count = 0;

    // For Each Question...
    items.forEach(question =>
    {
        const id = 'q'.concat(count)

        question.id = id

        let identifier = question.querySelector('.id')
        identifier.name = id

        let text = question.querySelector('.que-txt')
        text = text.querySelector('input');
        text.name = id.concat('-txt')

        let image = question.querySelector('.que-img')
        image = image.querySelector('input');
        image.name = id.concat('-img')

        let hint = question.querySelector('.que-hint')
        hint = hint.querySelector('input');
        hint.name = id.concat('-hint')

        let type = question.querySelector('.ans-type')
        type.name = id.concat('-type')

        calibrateAnswers(question.querySelector('.answers'))

        count++;
    })
}

// Create Answer Using Answer Container
function createAnswer(answers)
{
    // Get Question Id
    const id = answers.closest('.que').id

    // Get the Add Answer Button
    const add = answers.querySelector('.add-ans')

    // Get Count of Existing Answers
    const count = answers.querySelectorAll('.ans').length

    if (count >= 6)
        return;

    // Create Answer
    let container = document.createElement('div')
    container.className = 'ans'
    container.draggable = true

    let hidden = document.createElement('input')
    hidden.type = 'hidden'
    hidden.value = 'set'
    hidden.name = id.concat('-a', count)

    let text = document.createElement('input')
    text.className = 'ans-txt field'
    text.type = 'text'
    text.name = id.concat('-a', count, '-txt')
    text.required = true

    let radioContainer = document.createElement('label')
    radioContainer.className = 'radio'

    let radio = document.createElement('input')
    radio.className = 'ans-c'
    radio.type = 'radio'
    radio.name = id.concat('-c')
    radio.value = 'a'.concat(count)
    radio.required = true

    let checkmark = document.createElement('span')
    checkmark.className = 'checkmark'

    radioContainer.appendChild(radio)
    radioContainer.appendChild(checkmark)

    let button = document.createElement('button')
    button.className = 'del-ans btn-d'
    button.innerHTML = 'Delete'
    button.addEventListener('click', (event) =>
    {
        const answers = event.target.closest('.answers')
        event.target.closest('.ans').remove()
        calibrateAnswers(answers)
    })

    container.appendChild(hidden)
    container.appendChild(text)
    container.appendChild(radioContainer)
    container.appendChild(button)

    answers.insertBefore(container, add)

    if (count == 5)
        add.disabled = true
}

// Calibrate Answer Ids Using Answers Container
function calibrateAnswers(answers)
{
    // Get All Answers in Container
    let items = answers.querySelectorAll('.ans')

    // Get Question Id
    const id = answers.closest('.que').id

    const type = answers.closest('.que').querySelector('.ans-type').value;

    if (type == 'Multiple Choice')
    {
        // Start Count
        let count = 0;

        // For Each Answer...
        items.forEach(answer =>
        {
            let hidden = answer.querySelector('input[type="hidden"]')
            hidden.name = id.concat('-a', count)

            let text = answer.querySelector('.ans-txt')
            text.name = id.concat('-a', count, '-txt')

            let radio = answer.querySelector('.ans-c')
            radio.name = id.concat('-c')
            radio.value = 'a'.concat(count)

            // Increment Count
            count++;

            console.log(answer)
        })
    }

    else
    {
        let text = answers.closest('.que').querySelector('.ans-txt')
        text.name = id.concat('-a0', '-txt')
    }
}

