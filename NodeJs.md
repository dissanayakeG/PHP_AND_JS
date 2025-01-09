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