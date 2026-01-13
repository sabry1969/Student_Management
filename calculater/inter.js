const formulaEl = document.getElementById('formula');
const displayEl = document.getElementById('display');

let formulaString = "";
let currentNumber = "";

const numButtons = document.querySelectorAll('.btn.dark');
const opButtons = document.querySelectorAll('.btn.orange:not(:last-of-type)');
const equalButton = document.querySelector('.btn.orange:last-of-type');
const acButton = document.querySelector('.btn.gray.zero');
const delButton = document.querySelectorAll('.btn.gray')[1];

function addNumber(value) {
    if (formulaEl.textContent.includes("=")) {
        currentNumber = "";
        formulaString = "";
        formulaEl.textContent = "";
    }

    currentNumber += value;
    formulaString += value;

    displayEl.textContent = currentNumber;
    formulaEl.textContent = formulaString;
}

function addOperation(op) {
    if (formulaEl.textContent.includes("=")) {
        formulaString = currentNumber;
        formulaEl.textContent = formulaString;
    }

    const lastChar = formulaString[formulaString.length - 1];

    if (lastChar === "+" || lastChar === "-" || lastChar === "×" || lastChar === "÷") {
        formulaString = formulaString.slice(0, -1) + op;
    } else {
        formulaString += op;
    }

    currentNumber = "";
    displayEl.textContent = "0";
    formulaEl.textContent = formulaString;
}

function calculateResult() {
    if (formulaString === "" && currentNumber === "") return;

    const formulaForEval = formulaString.replace(/×/g, "*").replace(/÷/g, "/");
    let result;
    try {
        result = eval(formulaForEval);
        result = parseFloat(result.toFixed(8));
    } catch (e) {
        result = "Error";
    }

    displayEl.textContent = result;
    formulaEl.textContent = formulaString + "=";

    currentNumber = result.toString();
    formulaString = currentNumber;
}

function deleteLast() {
    if (currentNumber !== "") {
        currentNumber = currentNumber.slice(0, -1);
        formulaString = formulaString.slice(0, -1);
    }
    displayEl.textContent = currentNumber === "" ? "0" : currentNumber;
    formulaEl.textContent = formulaString;
}

function clearAll() {
    currentNumber = "";
    formulaString = "";
    displayEl.textContent = "0";
    formulaEl.textContent = "";
}

numButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        const val = btn.textContent.trim();
        if (/^[0-9]$/.test(val) || val === ".") {
            addNumber(val);
        }
    });
});

opButtons.forEach(btn => {
    btn.addEventListener('click', () => {
        addOperation(btn.textContent.trim());
    });
});

equalButton.addEventListener('click', calculateResult);

acButton.addEventListener('click', clearAll);

delButton.addEventListener('click', deleteLast);

document.addEventListener('keydown', (event) => {
    const key = event.key;

    if (key >= "0" && key <= "9") {
        addNumber(key);
    }

    else if (key === ".") {
        addNumber(".");
    }

    else if (key === "+" || key === "-" || key === "*" || key === "/") {
        let op;
        if (key === "*") op = "×";
        else if (key === "/") op = "÷";
        else op = key;
        addOperation(op);
    }

    else if (key === "Enter") {
        calculateResult();
    }

    else if (key === "Backspace") {
        deleteLast();
    }

    else if (key === "Escape") {
        clearAll();
    }
});