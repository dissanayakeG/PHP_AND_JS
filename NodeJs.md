# Core NodeJs
## Overview

- When Node.js performs an I/O operation, like reading from the network, accessing a database or the filesystem, instead of blocking the thread and wasting CPU cycles waiting, Node.js will resume the operations when the response comes back.
- Whenever a new request is received, the request event is called, providing two objects: a request (an http.IncomingMessage object) and a response (an http.ServerResponse object).

 **Simplest NodeJs Server**
 
```javascript
const { createServer } = require('node:http')
//import { createServer } from 'node:http' 
//If you use import instead require, you need to add this in package.json ->"type": "module",

const hostname = '127.0.0.1'
const port = 3000

const server = createServer((req, res) => {
    res.statusCode = 200
    res.setHeader('Content-type', 'text/plain')
    res.end('Hello World')
})

server.listen(port, hostname, () => { console.log(`server is running a http://${hostname}:${port}/`) })
```

## Modules
- Before executing a module, Node.js wraps all the code inside that module with a function wrapper

```javascript
(function(exports, require, module, __filename, __dirname) {
    // Module code
});
```
- Node.js supports two module systems. CommonJS Modules and  ES modules

### CommonJS Modules
```javascript
### Named Exports
// math.js
function add(a, b) {
  return a + b;
}
module.exports.add = add;

// app.js
const math = require('./math');
let result = math.add(a, b);
//or
const { add, subtract } = require('./math');

### Default Export
// math.js
function anotherFunction(a, b) {
  return a * b;
}
module.exports = anotherFunction;

// app.js
const math = require('./math');
const add = math;
```
- When you use the require() function to import the same module multiple times, the require() function evaluates the module once only at the first call and places it in a cache.
- From the subsequent calls, the require() function uses the exports object from the cache instead of executing the module again.

### ES modules (Node 14.0.0 or later)

- Extention is **.mjs** or set **"type" : "module"** in **nearest parent package.json**

```javascript
//Exports
export { add, subtract };

//Imports
import { add, subtract } from './math.mjs';
```

### Path Module
```javascript
const path = require('path'); //For common
import path from 'path'; //For ES

//Properties
path.sep
path.delimiter

//Methods
path.basename(path, [,ext])
path.dirname(path)
path.extname(path) //console.log(path.extname('index.html')); //.html
path.format(pathObj)
path.isAbsolute(path)
path.join(...path) //console.log(path.join('/home', 'js', 'dist', 'app.js')) //\home\js\dist\app.js
path.normalize(path)
path.parse(path)
path.relative(from, to)
path.resolve(...path)
```

### Os Module
- The os module provides you with many useful properties and methods for interacting with the operating system and server.

```javascript
const os = require('os');
import os from 'os';

os.type()
os.arch()
os.platform()
os.release()
os.version()
os.uptime()
os.userInfo()
os.totalmem()
os.freemem()
os.cpus()
os.networkInterfaces()
```

### Event Module

- Node.js is event-driven. It relies on the events core module to achieve the event-driven architecture.
- In the event-driven model, an EventEmitter object raises an event that causes the previously attached listeners of the event to execute.

```javascript
const EventEmitter = require('events');

const emitter = new EventEmitter();

emitter.on('saved', (arg) => {
    console.log(`A saved event occurred.`);
});

emitter.emit('saved',{...someData});//A saved event occurred.

// remove the event listener
emitter.off('saved', log); //After removing, no effect on reemiting the same event
```
- The **EventEmitter** class can be extended as you need

```javascript
class Stock extends EventEmitter {....code}
```

### HTTP Module
- The http module is a core module of Node designed to support many features of the HTTP protocol.

### Process module
- The process module has the env property that contains all the environment variables.
- Setting and getting an environment variable

```javascript
SET NODE_ENV=development //Windows
EXPORT NODE_ENV=development //Mac/Linux
process.env.NODE_ENV
```

# ExpressJs
```javascript
const express = require('express')
const app = express()
const port = 3000

app.get('/', (req, res) => {
  res.send('Hello World!')
})

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`)
})
```

## Routing
- Each route can have one or more handler functions, which are executed when the route is matched.

```javascript
app.get('/', (req, res) => {
  res.send('Hello World!')
})
```
- **app.all(),** used to load middleware functions at a path for all HTTP request methods.
- Route paths can be strings, string patterns, or regular expressions.

### Route paths

```javascript
app.get('/ab?cd', (req, res) => { }) //match acd and abcd.
app.get('/ab+cd', (req, res) => { }) //match abcd, abbcd, abbbcd, and so on.
app.get('/ab*cd', (req, res) => { }) //match abcd, abxcd, abRANDOMcd, ab123cd, and so on.
app.get('/ab(cd)?e', (req, res) => { }) //match /abe and /abcde.
app.get('/a/', (req, res) => { }) //match anything with an “a” in it.
app.get('/.*fly$/', (req, res) => { }) //match butterfly and dragonfly, but not butterflyman, dragonflyman, and so on.
```

### Route parameters

- The name of route parameters must be made up of “word characters” ([A-Za-z0-9_]).
- In express 5, Regexp characters are not supported in route path

```javascript
app.get('/users/:userId/books/:bookId', (req, res) => {})
```

- To have more control over the exact string that can be matched by a route parameter, you can append a regular expression in parentheses (()):
```javascript
Route path: /user/:userId(\d+)
Request URL: http://localhost:3000/user/42
req.params: {"userId": "42"}
```

### Route handlers

- You can provide multiple callback functions that behave like middleware to handle a request.
- Route handlers can be in the form of a function, an array of functions, or combinations of both

```javascript
const cb0 = function (req, res, next) {
  console.log('CB0')
  next() //Passing controll no next middleware or handler
}

const cb1 = function (req, res, next) {
  console.log('CB1')
  next() //Passing controll no next middleware or handler
}

app.get('/example/d', [cb0, cb1], (req, res, next) => {
  console.log('the response will be sent by the next function ...')
  next()
}, (req, res) => {
  res.send('Hello from D!')
})
```
- You can create chainable route handlers for a route path by using app.route()

```javascript
app.route('/book')
  .get((req, res) => {
    res.send('Get a random book')
  })
  .post((req, res) => {
    res.send('Add a book')
  })
  .put((req, res) => {
    res.send('Update the book')
  })
```
- Use the express.Router class to create modular, mountable route handlers.

```javascript
const express = require('express')
const router = express.Router()

//if the parent route /birds has path parameters, To make them accessible from the sub-routes.
const router = express.Router({ mergeParams: true }) 

// middleware that is specific to this router
const timeLog = (req, res, next) => {
  console.log('Time: ', Date.now())
  next()
}
router.use(timeLog)

// define the home page route
router.get('/', (req, res) => {
  res.send('Birds home page')
})
// define the about route
router.get('/about', (req, res) => {
  res.send('About birds')
})

module.exports = router

//Using in app.js
const birds = require('./birds')
app.use('/birds', birds)
```

## Serving static files
- For more refer [Doc](https://expressjs.com/id/resources/middleware/serve-static.html)
```javascript
app.use(express.static('public'))
app.use(express.static('files'))
app.use('/static', express.static('public')) //To create a virtual path prefix
//path is relative to the directory from where you launch your node process
//If you run the express app from another directory, it’s safer to use the absolute path of the directory that you want to serve
app.use('/static', express.static(path.join(__dirname, 'public')))
```

## Middlewares
- next('route') will work only in middleware functions that were loaded by using the app.METHOD() or router.METHOD() functions.

```javascript
app.get('/user/:id', (req, res, next) => {
  // if the user ID is 0, skip to the next route
  if (req.params.id === '0') next('route')
  // otherwise pass the control to the next middleware function in this stack
  else next()
}, (req, res, next) => {
  // send a regular response
  res.send('regular')
})

// handler for the /user/:id path, which sends a special response
app.get('/user/:id', (req, res, next) => {
  res.send('special')
})

//Error-handling middleware
app.use((err, req, res, next) => {
  console.error(err.stack)
  res.status(500).send('Something broke!')
})
```
- **Error-handling middleware** always takes **four** arguments. You must provide four arguments to identify it as an error-handling middleware function. Even if you don’t need to use the next object, you must specify it to maintain the signature. Otherwise, the next object will be interpreted as regular middleware and will fail to handle errors.

