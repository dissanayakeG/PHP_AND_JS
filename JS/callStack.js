function testFunction() {
    try {
        throw new Error();
    } catch (error) {
        console.log(error.stack);
    }
}

function anotherFunction() {
    testFunction();
}

anotherFunction();
