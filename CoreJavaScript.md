- 20/12/2024

# JS in nutshell
## Fundamentals

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

#### Arithmetic Operators

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
- The value of the `arguments` object inside the function is the number of actual arguments that you `pass to the function`

```javascript
function add(x, y = 1, z = 2) {
    console.log( arguments.length );
    return x + y + z;
}

add(10); // 1
add(10, 20); // 2
add(10, 20, 30); // 3
```
- Variable hoisting means the JavaScript engine moves the variable declarations to the top of the script, this behave differently for `var` and `let`

 ```javascript
  console.log(counter);// 👉 undefined
  var counter = 1;

  console.log(counter); //"ReferenceError: Cannot access 'counter' before initialization
  let counter = 1;
```
- During the creation phase of the global execution context, the JavaScript engine places the variable `counter` in the memory and initializes its value to `undefined`.
- JavaScript engine hoists the variable declarations that use the `let` keyword. However, it doesn’t initialize the `let` variables.
- The JavaScript engine doesn’t hoist the function expressions, arrow functions and class expressions .
    
- Function hoisting is a mechanism in which the JavaScript engine physically moves function declarations
    to the top of the code before executing them.
- In JavaScript, functions are first-class citizens, meaning they can be stored in variables, passed
    as arguments, and returned from other functions.
- In JS, arguments are passed by value by default, so changes to arguments do not reflect outside,
    like pass by reference; pass by reference is not available in JS.
- But, if you pass a non-primitive value (object), then it refers to the same value, so changes
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
- In JavaScript, a parameter has a default value of [undefined](https://www.javascripttutorial.net/javascript-data-types/#undefined). (we pass arguments into functions, and functions accept them as parameters)
- In JavaScript, you `cannot directly use named parameters`. instead you have to pass them like `undefined`
`createDiv(undefined, undefined, 'solid 5px blue');`
- The most effective way to handle this type of situation is by passing or accepting the parameters as an object.
`createDiv({ border: 'solid 5px blue' });`

23/12/2024

## Objects & Prototypes
### Constructor functions

```javascript
function Person(firstName, lastName) { //Note Uppercase P
    // this = {}; initially this empty object is created
    this.firstName = firstName;
    this.lastName = lastName;

    this.getFullName = function () {
        return this.firstName + " " + this.lastName;
    };
    // return this; finally this OBJECT is retured
}
let person = new Person("John", "Doe"); //Note the new keyword
console.log(person.getFullName());//John Doe
```
- The problem with the constructor function is that when you create multiple instances of the `Person`, the `this.getFullName()` is duplicated in every instance, which is not memory efficient.
- To resolve this, you can use the [prototype](https://www.javascripttutorial.net/javascript-prototype/) so that all instances of a custom type can share the same methods.
- Constructor function can be called without the new keyword, like
  `let person = Person('John','Doe');` But,
-  the `Person` just executes like a regular function. Therefore, the `this` inside the `Person` function doesn’t bind to the `person` variable but the [global object](https://www.javascripttutorial.net/es-next/javascript-globalthis/).
`console.log(person.firstName); //TypeError: Cannot read property 'firstName' of undefined`

```javascript
function Person(firstName, lastName) {
    if (!new.target) {
        return new Person(firstName, lastName);
    }

    this.firstName = firstName;
    this.lastName = lastName;
}
let person = Person("John", "Doe");
console.log(person.firstName);
```

```javascript
function Person(name) {
    this.name = name;
}
let john = new Person('John');//define type using new keyword and 'this' refers to local context //call as a constructor
console.log(john.name); // john 
Person('Lily'); //this will call Person as a regular function and 'this' refers to globalThis
console.log(globalThis.name);//Lily

//using new.target to ensure Person is called with new keyword.
function Person(name) {
    if (!new.target) { //undefined if called normally, else return a reference to the constructor.
        throw "must use new operator with Person";
    }
    this.name = name;
}
let john = new Person('John');
console.log(john.name); // john
Person('Lily'); //Uncaught must use new operator with Person
```

24-25/12/2024
### Object prototype

- Every object has its own property called a `prototype`, objects can inherit features from one another via `prototypes`
- Because the `prototype` itself is also another object, the `prototype` has its own `prototype`.
- This creates a something called `prototype chain`. The prototype chain ends when a prototype has `null` for its own prototype.
- If you access a property that doesn’t exist in an object, the JavaScript engine will search in the prototype of the object
- If the JavaScript engine cannot find the property in the object’s prototype, it’ll search in the prototype’s prototype until it finds the property or reaches the end of the prototype chain
- Object() is a FUNCTION
- Object.prototype is a OBJECT
- Object.prototype.constructor property references the `Object` function
`console.log(Object.prototype.constructor === Object); // true`

```javascripts
function Person(firstName, lastName) { //A Constructor function
    this.firstName = firstName;
}
console.log(Person.prototype.constructor === Person) //true
let p = Person('Alex'); //if we call without new keyword, the constructor function behaves like a regular function.
```
- JavaScript links the `Person.prototype` object to the `Object.prototype` object via the `[[Prototype]]`, which is
  known as a `prototype linkage`.

  ```javascripts
  Person.prototype.greet = function() {
      return "Hi, I'm " + this.name;
  }
  let p1 = new Person('John');
  let greeting = p1.greet();  
  
  let p2 = new Person('Jane');
  let greetingP2 = p2.greet();
  
  console.log(greeting); //Hi, I'm Jhone
  console.log(greeting); //Hi, I'm Jane

  //In ES6 since we have class keyword, we don't have to do this to define a custom type

  console.log(Person.prototype === Object.getPrototypeOf(p1)); //true
  console.log(Person.prototype === p1.constructor.prototype); // true
  ```

![protoTypeLinkage.png](./protoTypeLinkage.png)

`let person = { name: "John Doe", greet: function () { return "Hi, I'm " + this.name; } };`

- The person object has a link to the anonymous object referenced by the `Object()` function. The `[[Prototype]]` represents the linkage:
- `person` object can call any methods defined in the anonymous object referenced by the `Object.prototype` //`console.log(person.toString());`
- Since JavaScript engine cannot find it on the `person` object. Therefore, it follows the prototype chain and searches for the method in the `Object.prototype` object
- `console.log(person.__proto__ === Object.prototype); // true`

**prototypal inheritance**.

```javascript
let person = { name: "John Doe", greet: function () { return "Hi, I'm " + this.name; } };

let teacher = {
    teach: function (subject) {
        return "I can teach " + subject;
    }
};

teacher.__proto__ = person;
console.log(teacher.greet());
//Since the JavaScript engine cannot find the method in the `teacher` object, it follows the prototype chain and searches for the method in the `person` object. Because the JavaScript engine can find the `greet()` method in the `person` object, it executes the method.
//`teacher` object inherits the methods and properties of the `person` object
//This kind of inheritance is called prototypal inheritance.
```

- prototypal inheritance  in ES5`let teacher = Object.create(person);`
- `console.log(Object.getPrototypeOf(teacher) === person); //true`
- Prototypal inheritance in ES6 is using classes and is the recommended way.
- JavaScript objects have two types of properties: `data` properties and `accessor` properties.
- JavaScript uses internal attributes denoted `[[...]]` to describe the characteristics of properties.
- `data` properties have 4 attributes `[[Configurable]]`, `[[Enumerable]]`, `[[Writable]]`.
- `accessor` properties have 4 attributes  and  `[[Configurable]]`, `[[Enumerable]]`, `[[Get]]`, and `[[Set]]`
- A property can be defined directly on an object or indirectly via the `Object.defineProperty()` or `Object.defineProperties()` methods. These methods can be used to change the attributes of a property.

```javascript
var product = {};

Object.defineProperties(product, {
    name: { value: 'Smartphone', enumerable: true },
    price: { value: 799 },
    tax: { value: 0.1 },
    netPrice: {
        get: function () {
            return this.price * (1 + this.tax);
        }
    }
});

console.log('The net price of a ' + product.name + ' is ' + product.netPrice.toFixed(2) + ' USD');
//The net price of a Smartphone is 878.90 USD
//If you want to loop through using for...in when defining properties using defineProperty/defineProperties,
//you have to manually set enumerable: true 
//above print only name
```
- The `for...in` loop iterates over the `enumerable properties` of an object. It also goes up to the [prototype](https://www.javascripttutorial.net/javascript-prototype/) chain and enumerates inherited properties.
- Avoid using `for...in` loop to iterate over elements of an array, especially when the index order is important.
- A property is enumerable if it has the `enumerable` attribute set to `true`. The `obj.propertyIsEnumerable()` determines whether or not a property is enumerabl
- A property created via a simple assignment or a property initializer is enumerable.
- A property that is directly defined on an object is an own property.
- The `obj.hasOwnProperty()` method determines whether or not a property is own. //`console.log(product.hasOwnProperty('ssn')); // => false`
- Computed properties allow you to use the values of expressions as property names of an object.
```javascript
let propertyName = 'dynamicPropertyName'; 
const obj = { [propertyName] : value }
obj.dynamicPropertyName

const createObject = (key, value) => { 
    return { [key]: value, };
};
const person = createObject('name', 'John'); 
console.log(person); //{ name: 'John' }
```

## Classes (ES6 - 2015)
### private properties/methods static properties/methods

```javascript
class Person {
  static count = 0;
  #firstName; //define private properties
  #lastName;
  constructor(firstName, lastName) {
    Person.count = 1; //or this.constructor.count = 1 to access static properties
    this.#firstName = Person.#validate(firstName); //access static methods
    this.#lastName = Person.#validate(lastName);
  }
  getFullName(format = true) {
    return format ? this.#firstLast() : this.#lastFirst();
  }
  static #validate(name) {
    if (typeof name === 'string') {
      let str = name.trim();
      if (str.length >= 3) {
        return str;
      }
    }
    throw 'The name must be a string with at least 3 characters';
  }

  #firstLast() {
    return `${this.#firstName} ${this.#lastName}`;
  }
  #lastFirst() {
    return `${this.#lastName}, ${this.#firstName}`;
  }
}

let person = new Person('John', 'Doe');
console.log(person.getFullName());
```

## Advanced Functions
- In JavaScript, all functions are objects and  they are instances of the `Function` type




















