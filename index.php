<!DOCTYPE html>
<html>
<head>
	<title>Programmer's Calculator</title>
	<link href="style.css" type="text/css" rel="stylesheet"/>
</head>

<body>
	<div id="form_wrapper">
		<form id="formone" name="calc">
			<input id="display" type="text" name="display" value="" disabled contenteditable="false" placeholder="0">
			<div class="buttonGrid">
				<div class="grid__col left">
					<button class="button" type="button" value="C" onClick="clearDisplay(this.form)">C</button>
					<button class="button" type="button" value="&larr;" onClick="backspace(this.form)">&larr;</button>
					<button class="button" type="button" value="=" onClick="calculateResult(this.form)">=</button>
					<button class="button number" type="button" value="1" onClick="calc.display.value+=1">1</button>
					<button class="button number" type="button" value="2" onClick="calc.display.value+=2">2</button>
					<button class="button number" type="button" value="3" onClick="calc.display.value+=3">3</button>
					<button class="button number" type="button" value="4" onClick="calc.display.value+=4">4</button>
					<button class="button number" type="button" value="5" onClick="calc.display.value+=5">5</button>
					<button class="button number" type="button" value="6" onClick="calc.display.value+=6">6</button>
					<button class="button number" type="button" value="7" onClick="calc.display.value+=7">7</button>
					<button class="button number" type="button" value="8" onClick="calc.display.value+=8">8</button>
					<button class="button number" type="button" value="9" onClick="calc.display.value+=9">9</button>
					<button class="button number" type="button" value="0" onClick="calc.display.value+=0" style="grid-column:1/4;">0</button>
				</div>

				<div class="grid__col right">
					<button class="button opps" type="button" value="/" onClick="calc.display.value+='/'">/</button>
					<button class="button opps" type="button" value="*" onClick="calc.display.value+='*'">*</button>
					<button class="button opps" type="button" value="+" onClick="calc.display.value+='+'">+</button>
					<button class="button opps" type="button" value="-" onClick="calc.display.value+='-'">-</button>
					<button class="button opps" type="button" value="%" onClick="calc.display.value+='%'">%</button>
					<button class="button fn" type="button" value="." onClick="calc.display.value+='.'">.</button>						
					<button class="button fn" type="button" value="(" onClick="parentheses(this.value)">(</button>
					<button class="button fn" type="button" value=")" onClick="parentheses(this.value)">)</button>
					<button class="button fn" type="button" value="sqrt" onClick="specialFn('sqrt')">&Sqrt;</button>
					<button class="button fn" type="button" value="LN2" onClick="calc.display.value+=0.693">ln<sub>2</sub></button>
					<button class="button fn" type="button" value="LN10" onClick="calc.display.value+=2.302">ln<sub>10</sub></button>
					<button class="button fn" type="button" value="log2E" onClick="calc.display.value+=1.442">log<sub>2</sub>e</button>
					<button class="button fn" type="button" value="log10E" onClick="calc.display.value+=0.434">log<sub>10</sub>e</button>
					<button class="button fn" type="button" value="EXP" onClick="specialFn('exp')">exp</button>
					<button class="button fn" type="button" value="sin" onClick="specialFn('sin')">sin</button>
					<button class="button fn" type="button" value="cos" onClick="specialFn('cos')">cos</button>
					<button class="button fn" type="button" value="tan" onClick="specialFn('tan')">tan</button>
					<button class="button fn" type="button" value="E" onClick="calc.display.value+=2.718">e</button>
					<button class="button fn" type="button" value="pi" onClick="calc.display.value+=3.141">&pi;</button>
					<button class="button fn" type="button" value="x^y" onClick="specialFn('pow')">x<sup>y</sup></button>
					<button class="button fn" type="button" value="log" onClick="specialFn('log')">log</button>
					<button class="button fn" type="button" value="n!" onClick="specialFn('fact')" style="grid-column:1/4;">n!</button>
				</div>
			</div>
		</form>
		<p style="color: white; margin-top: 30px; font-size: 13px;">Programmer's Calculator</p>
		<p style="color: white; margin-top: 10px; font-size: 11px;">by Abdush Shakoor</p>
	</div>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="script.js" type="text/javascript"></script>
</body>
</html>