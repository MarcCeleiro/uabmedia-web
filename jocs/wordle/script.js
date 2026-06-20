import { WORDS } from "./words.js";
// Intentos
const NUMBER_OF_GUESSES = 6;
let guessesRemaining = NUMBER_OF_GUESSES;

let palabraIntroducida = [];

let nextLetter = 0;

let palabraCorrecta = WORDS[Math.floor(Math.random() * WORDS.length)]
console.log(palabraCorrecta)



function initBoard() {
    let board = document.getElementById("game-board");

    for (let i = 0; i < NUMBER_OF_GUESSES; i++) {
        let row = document.createElement("div")
        row.className = "letter-row"

        for (let j = 0; j < 5; j++) {
            let box = document.createElement("div")
            box.className = "letter-box"
            row.appendChild(box)
        }

        board.appendChild(row)
    }
}

initBoard()



document.addEventListener("keyup", (e) => {

    if (guessesRemaining === 0) {
        return
    }
    // Detecta qué has apretado
    let pressedKey = String(e.key)

    // si no es la primera y apretas bckspace, borra
    if (pressedKey === "Backspace" && nextLetter !== 0) {
        deleteLetter()
        return
    }
    // si apretas enter, funcion checkguess
    if (pressedKey === "Enter") {
        checkGuess()
        return
    }

    let found = pressedKey.match(/[a-z]/gi)
    if (!found || found.length > 1) {
        return
    } else {
        // si es una letra minuscula
        insertLetter(pressedKey)
    }
})
document.getElementById("keyboard-cont").addEventListener("click", (e) => {
    const target = e.target
    
    if (!target.classList.contains("keyboard-button")) {
        return
    }
    let key = target.textContent

    if (key === "Del") {
        key = "Backspace"
    } 

    document.dispatchEvent(new KeyboardEvent("keyup", {'key': key}))
})

function insertLetter(pressedKey) {
    if (nextLetter === 5) {
        return
    }
    pressedKey = pressedKey.toLowerCase()

    let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
    let box = row.children[nextLetter]
    animateCSS(box, "pulse")

    box.textContent = pressedKey
    box.classList.add("filled-box")
    palabraIntroducida.push(pressedKey)
    nextLetter += 1
}

function deleteLetter() {
    let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
    let box = row.children[nextLetter - 1]
    box.textContent = ""
    box.classList.remove("filled-box")
    palabraIntroducida.pop()
    nextLetter -= 1
}


function checkGuess() {
    let row = document.getElementsByClassName("letter-row")[6 - guessesRemaining]
    let palabraAnalizar = ''
    let palabraGanadora = Array.from(palabraCorrecta)

    for (const val of palabraIntroducida) {
        palabraAnalizar += val
    }

    if (palabraAnalizar.length != 5) {
        toastr.error("Not enough letters!")
        return
    }

    if (!WORDS.includes(palabraAnalizar)) {
        toastr.error("Word not in list!")
        return
    }


    for (let i = 0; i < 5; i++) {
        let letterColor = ''
        let box = row.children[i]
        let letter = palabraIntroducida[i]

        // te dice donde está la primera vez que encuentra la letra introducida en la palabra buena
        let letterPosition = palabraGanadora.indexOf(palabraIntroducida[i])
        // is letter in the correct guess
        // -1= no la ha encontrado
        if (letterPosition === -1) {
            letterColor = 'grey'
        } else {
            // now, letter is definitely in word
            // if letter index and right guess index are the same
            // letter is in the right position 
            if (palabraIntroducida[i] === palabraGanadora[i]) {
                // shade green 
                letterColor = 'green'
            } else {
                // shade box yellow
                letterColor = 'yellow'
            }

            // Anula la que ya has encontrado
            palabraGanadora[letterPosition] = "#"
        }
        // añade tensión en cada row
        let delay = 250 * i
        setTimeout(() => {
            //flip box
            animateCSS(box, 'flipInX')
            //shade box
            box.style.backgroundColor = letterColor
            shadeKeyBoard(letter, letterColor)
        }, delay)
    }

    if (palabraAnalizar === palabraCorrecta) {
        toastr.success("You guessed right! Game over!")
        guessesRemaining = 0
        return
    } else {
        guessesRemaining -= 1;
        palabraIntroducida = [];
        nextLetter = 0;

        if (guessesRemaining === 0) {
            toastr.error("You've run out of guesses! Game over!")
            toastr.info(`The right word was: "${palabraCorrecta}"`)
        }
    }
}




const animateCSS = (element, animation, prefix = 'animate__') =>
    // We create a Promise and return it
    new Promise((resolve, reject) => {
        const animationName = `${prefix}${animation}`;
        // const node = document.querySelector(element);
        const node = element
        node.style.setProperty('--animate-duration', '0.3s');

        node.classList.add(`${prefix}animated`, animationName);

        // When the animation ends, we clean the classes and resolve the Promise
        function handleAnimationEnd(event) {
            event.stopPropagation();
            node.classList.remove(`${prefix}animated`, animationName);
            resolve('Animation ended');
        }

        node.addEventListener('animationend', handleAnimationEnd, { once: true });
    });