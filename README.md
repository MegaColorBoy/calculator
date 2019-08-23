# Programmer's Calculator

A simple scientific calculator that's built using PHP, Javascript and MySQL.

The application uses a API Backend as a Service to perform all calculations and reporting.

## Dependencies
Please make sure that you have XAMPP Server installed in your system in order to use PHP and MySQL.

Create a Database named `calc_db` in your DBMS and later, copy-paste the MySQL query from tables.sql.

## How to use the application
In your browser, just type: `http://localhost/calc` and you should be able to use the application.

## API Documentation

### Calculated result:
Get result from mathematical expression
@Params: {mathexpr} => The mathematical expression
```
http://localhost/calc/api/v1/calculate/{mathexpr}
```

You can do all kinds of mathmetical expressions and get the final result.
Also, you can perform special operations such as:

- Trignometric (sin(x), cos(x), tan(x))
- Logarithms (log10e, log2e, ln2, ln10)
- Pi (pi)
- Power (pow(x,y))
- Exponents (exp(x))
- Factorial (fact(x))

Example:
```
http://localhost/calc/api/v1/calculate/pow(2,2)%2B20*100-20
http://localhost/calc/api/v1/calculate/fact(3)
```

**Note for developers:**
When you're performing calculations on the API directly, please make sure the math operators are URL friendly.

**URL Friendly operators:**

- '*' can be replaced by '%2A'
- '+' can be replaced by '%2B'
- '-' can be replaced by '%2D'
- '.' can be replaced by '%2E'
- '/' can be replaced by '%2F'

### Reports

#### Daily
Fetch data transactions of the day
```
http://localhost/calc/api/v1/logs/today
```

#### Weekly
Fetch data transactions of the week
```
http://localhost/calc/api/v1/logs/week
```

#### Monthly
Fetch data transactions of the month
@Params: monthname => Name of the month
```
http://localhost/calc/api/v1/logs/month/{monthname}
```

## Conclusion
Hope you like it!