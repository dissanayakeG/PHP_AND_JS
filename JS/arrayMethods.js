// https://dev.to/shrihankp/higher-order-array-methods-in-javascript-14e7

let arr = [
    { "id": "5001", "type": "None" },
    { "id": "5002", "type": "Glazed" },
    { "id": "5003", "type": "Chocolate" },
    { "id": "5004", "type": "Maple" },
    { "id": "5005", "type": "Maple1" },
    { "id": "5006", "type": "Maple2" },
    { "id": "5007", "type": "Maple3" },
    { "id": "5008", "type": "Maple4" },
];

// MAP
// arr = arr.map((item) => {
//     return {
//         "value":item.id,
//         "name":item.type
//     }
// })

// FILTER
// arr1 = arr.filter((item)=>{
//     return item.id > "5005"
// })

arr1 = arr.filter(({type})=>{
    return type  == "None"
})
console.log(arr1);


// REDUCE
const givenArray = [1, 2, 3, 4, 5];
const sum = givenArray.reduce((acc, curr) => acc + curr);
console.log(sum); // console: 15

// at the first iteration: acc=1(givenArray[0]), curr=2(givenArray[1])
// at the second iteration: acc=3(givenArray[0] + givenArray[1]), curr=3(givenArray[2])
// at the third iteration: acc=6(givenArray[0] + givenArray[1] + givenArray[2]), curr=4(givenArray[3])
// at the fourth iteration: acc=10(givenArray[0] + givenArray[1] + givenArray[2] + givenArray[3]), curr=5(givenArray=[4])
// finally: acc=15 (sum of all elements) (array iteration ended)



