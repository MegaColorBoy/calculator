//To keep track of parenthesis
pFlag = 0;

const displayLength = calc.display.value.length; 

const parentheses = (val) => {
    calc.display.value += val;
    switch(val) {
        case '(':
            pFlag += 1;
            break;
        case ')':
            pFlag -= 1;
            break;
    }
}

const backspace = (calc) => {
    calc.display.value = calc.display.value.substring(0, displayLength - 1);
}

const clearDisplay = (calc) => {
    calc.display.value = " ";
    pFlag = 0;
}

const fact = (x) => {
    factvar = 1;
    for (i = 1; i <= x; i++) {
        factvar = factvar * i;
    }
    return factvar;
}

//Special Math Functions
const specialFn = (type) => {
    switch(type) {
        case "cos":
        case "sin":
        case "tan":
        case "log":
        case "sqrt":
        case "exp":
        case "fact":
            var x = prompt("Enter number");
            if(x != null) {
                calc.display.value += type + `(` + x + `)`;
            }
            break;

        case "pow":
            var x = prompt("Enter base number");
            var y = prompt("Enter exponent number");
            if(x != null && y != null) {
                calc.display.value += type + `(`+ x +`,`+ y + `)`;            
            }
            break;
    }
}

const calculateResult = (calc) => {
    n = calc.display.value;
    let lastchar = calc.display.value.charAt(displayLength-1)
    console.log(n);
    console.log(lastchar);
    if (isNaN(lastchar) && lastchar != ")" && lastchar != "!") {
        calc.display.value = "syntax error";
    } 
    else if (pFlag != 0) {
        calc.display.value = "error: missing parenthesis";
    } 
    else {
        //Pass this value to AJAX
        $.ajax({
            type: "GET",
            url: "api/v1/calculate/" + convertOpsToHex(n),
            success: function(res) {
                var response = JSON.parse(res);
                calc.display.value=response.Result;
            },
            error: function(err) {
                console.log(err.responseText);
            }
        });
    }
}

/*
    This function would convert any operators into 
    it's Hexadecimal format esp. when it's sent as an expr to the
    API.
*/
const convertOpsToHex = (str) => {
    const spChar = '()*+-./';
    const hexChar = "%28,%29,%2A,%2B,%2D,%2E,%2F".split(',');

    for(let i=0; i<str.length; i++)
    {
        let ch = "" + str[i];
        let pos = spChar.indexOf(ch);
        let ascii = "" + hexChar[pos];

        switch(ch)
        {
            // case "(":
            // case ")":
            case "*":
            case "+":
            case "-":
            case ".":
            case "/":
                str = str.replace(ch, ascii);
                break;
        }
    }
    
    return str.trim();
}