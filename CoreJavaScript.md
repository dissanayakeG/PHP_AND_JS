- 20/12/2024

# JS in nutshell

## Fogettable points

### Fundamentals

- Variables cannot start with digit,special characters
- camelCase by convention
- Dynamically typed (don’t need to explicitly specify the variable’s type)
- _Ex_ for static-typed languages -- Java/ C#.
- Accessing undeclared variables gives a ReferenceError
- Declaring and initializing a const must be done in a single statement since const variables holds a value that doesn’t change
- Has 2 data types, Primitive, complex
- Primitive - undefined --> console.log(typeof undeclaredVar); // undefined
    null --> console.log(null == undefined); // true
    NaN --> stands for Not a Number. It is a special numeric value that indicates an invalid number, console.log('a'/2); // NaN;
    NaN does not equal any value, including itself, so NaN == NaN returns false.
    string --> JavaScript strings are immutable, This means that modifying a string always results in a new string,
    leaving the original string unchanged.
    boolean-->
    symbol --> let s1 = Symbol(); //The Symbol function creates a new unique value every time you call it.
    console.log(Symbol() == Symbol()); // false
    bigint -->

- Complex - object --> collection of properties, where each property is defined as a key-value pair.
    //property can be accessed using both don and array notations (. || []), if a property name has whitespace (bad practice)
    //you must access it with array notation
    //Deleting a property --> delete objectName.propertyName;
    //Checking if a property exists --> propertyName in objectName
- Numeric separators ( \_ ) --> let amount = 120_201_123.05; // 120201123.05
    can be used for any number type(integer,factional and exponent, floating, BigInt,binary,octal,hex)
- It’s important to note that all numbers in JavaScript are floating-point numbers.

- Boolean() function casts the values of other types to boolean values:
- Boolean() return true for any of -> (Any non-empty string, Any Non-zero number,Any object)
- Boolean() return false for any of ->(empty string,0, NaN,null,undefined)

template literal and string interpolation --> console.log(`Hi, I'm ${name}.`)

- To access the last character of the string --> console.log(str[str.length -1]) // first --> str[0] OR str.charAt(0)
- Converting values to string --> String(n); | ” + n | n.toString() --> toString() method doesn’t work for undefined and null

#### [Primitive vs. Reference Values](https://www.javascripttutorial.net/javascript-primitive-vs-reference-values/ "JavaScript Primitive vs. Reference Values")

Static data is the data whose size is fixed at compile time

- Primitive values && Reference values that refer to objects (this is not object, but reference).
- Since primitive data types has fixed size, JS store them in stack by allocating fixed amount of memory space
- objects (and functions) on the heap , doesn’t allocate a fixed amount of memory
- When you assign a primitive value from one variable to another, the JavaScript engine
    creates a copy of that value and assigns it to the variable.
    //changing a value of one variable, won’t affect the other.

![stackAndHeapInJs.png](./stackAndHeapInJs.png)

#### Arrays

- Note that if you use the `Array()` constructor to create an array and pass a `single number` into it, you are creating an array with an initial size.
- Appending an element --> array.push
- Adding an element to the beginning --> array.unshift(1)
- Removing an element from the beginning → array.shift();
- Finding an index of an element → array.indexOf(1);
- Check if a value is an array → Array.isArray(seas)

- 21/12/2024

### JavaScript Arithmetic Operators

- in (- , \*, /) If either value is not a number, the JavaScript engine implicitly converts it into a number using the `Number()` function.
- If the value is an object, Js use object”s `valueOf` function, if it is not exists Js use `toString` function of the object.
- If you want to assign a single value to multiple variables, you can chain the ->

```javascript
let a = 10,
	b = 20,
	c = 30;
a = b = c;
// all variables are 30 JavaScript evaluates from right to left
```

- When you apply the unary plus/minus (+ val / -val) operator to a non-numeric value, it performs a number conversion using the `Number()`

```javascript
let s = "10";
console.log(+s); // 10
let f = false,
	t = true;
console.log(+f); // 0 console.log(+t); // 1
```

- if it is an object, it uses`valueOf/toString`
- The prefix increment operator adds one to a value. The value is changed before the statement is evaluated.
- The postfix increment operator adds one to a value. The value is changed after the statement is evaluated.
- The prefix decrement operator subtracts one from a value. The value is changed before the statement is evaluated.
- The postfix decrement operator subtracts one from a value. The value is changed after the statement is evaluated.

`let weight = 90; let newWeight = weight++ + 5; console.log(newWeight); // 95 console.log(weight); // 91`
//Adds one to the value after evaluating the statement

`let weight = 90; let newWeight = ++weight + 5; console.log(newWeight); // 96 console.log(weight); // 91`
//Adds one to the value before evaluating the statement

- 22/12/2024
- Every function in JavaScript implicitly returns `undefined` unless you explicitly
- Inside a function, you can access an object called `arguments` that represents the named arguments of the function.
- The `arguments` object behaves like an [array](https://www.javascripttutorial.net/javascript-array/) though it is not an instance of the [Array](https://www.javascripttutorial.net/javascript-array/) type.
- Function hoisting is a mechanism in which the JavaScript engine physically moves function declarations
    to the top of the code before executing them.
- In JavaScript, functions are first-class citizens, meaning they can be stored in variables, passed
    as arguments, and returned from other functions.
- In JS, arguments are passed by value by default, so changes to arguments do not reflect outside,
    like pass by reference; pass by reference is not available in JS.
    - But, if you pass a non-primitive value (object), then it refers to the same value, so changes
    to that will be reflected outside of the function.

```javascript
let person = {
	name: "John",
	age: 25,
};

function increaseAge(obj) {
	obj.age += 1;

	// reference another object
	obj = { name: "Jane", age: 22 };
	//After the function finishes execution, `obj` (a local variable) is discarded.
}

increaseAge(person);
console.log(person);
console.log(obj); // This returns a ReferenceError, because function execution is completed at this level
```

![passByValue-object.png](./passByValue-object.png) ![passByValue-object-and-change-reference.png](./passByValue-object-and-change-reference.png)

```javascript
const styles = { color: "red" };
function change(styles) {
	styles = { background: "black" }; //Use the same name, but this is a local variable and discard it after the execution.
}
change(styles);
console.log(styles); //{ color: 'red', }
```
