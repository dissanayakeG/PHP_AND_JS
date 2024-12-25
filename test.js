// let person = {name:'Alex'};
// let obj = Object()
// console.log(person.__proto__ === Object.prototype); // true
//Note that you should never use the __proto__ property in the production code. Please use it for demonstration purposes only.

// console.log(person.__proto__, person.toString() ===  Object.prototype.toString())
// console.log(typeof(person), typeof(obj), Object.getPrototypeOf(obj));

// function Animal(name = 'no animal pass in'){
//     return name;
// }
// let a1 = new Animal('cat')
// let a2 = new Animal('dog');

// // console.log(Object.getPrototypeOf(a1) == Object.getPrototypeOf(a2)); //true
// // console.log(Animal.prototype,  Object.getPrototypeOf(a1), a1.prototype, a1.constructor.prototype);

// Animal.prototype.greet = function(){
//     return 'adding a greet to Animal prototype, so it will be shared across all the Animal objects'
// }

// console.log(a1.greet() === a2.greet());

// function Person(firstName, lastName) {
//     this.firstName = firstName;
// }

// let p1 = new Person('Jhone')

// console.log(Person.prototype.constructor === Person)
// console.log(Person.prototype === p1.constructor.prototype); // true



var product = {};

Object.defineProperties(product, {
    name: { value: 'Smartphone',enumerable: true },
    price: { value: 799 ,enumerable: true},
    tax: { value: 0.1 ,enumerable: true},
    netPrice: {
        get: function () {
            return this.price * (1 + this.tax);
        }
    }
});

for (const key in product) {
    console.log(key);
}
console.log(product.netPrice);