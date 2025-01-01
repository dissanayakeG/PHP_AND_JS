(function () {
    //1) Check if the IndexedDB is supported

    if (!window.indexedDB) {
        console.log(`Your browser doesn't support IndexedDB`);
        return;
    }

    //2) Open a database
    const request = indexedDB.open('CRM', 1); //DB name and version
    console.log('request instanceof IDBOpenDBRequest ', request instanceof IDBOpenDBRequest)


    //3) Create object stores
    /**
    When you open the database for the first time, the onupgradeneeded event will trigger.
    If you open the database for the second time with a version higher than the existing version, the onupgradeneeded  event also triggers.
    **/

    // create the Contacts object store and indexes
    request.onupgradeneeded = (event) => {
        let db = event.target.result;

        console.log('db instanceof IDBDatabase ', db instanceof IDBDatabase);

        // create the Contacts object store 
        // with auto-increment id
        let store = db.createObjectStore('Contacts', {
            autoIncrement: true
        });

        // create an index on the email property
        let index = store.createIndex('email', 'email', {
            unique: true
        });
    };


    request.onerror = (event) => {
        console.error(`Database error: ${event.target.errorCode}`);
    };

    request.onsuccess = (event) => {
        const db = event.target.result;

        insertContact(db, {
            email: 'john.doe@outlook.com',
            firstName: 'John',
            lastName: 'Doe'
        });

        insertContact(db, {
            email: 'jane.doe@gmail.com',
            firstName: 'Jane',
            lastName: 'Doe'
        });

        getContactById(db, 1);

        getContactByEmail(db, 'jane.doe@gmail.com');

        getAllContacts(db);

        deleteContact(db, 1);
    };

    //4) Insert data into object stores

    function insertContact(db, contact) {
        // create a new transaction
        const txn = db.transaction('Contacts', 'readwrite');

        // get the Contacts object store
        const store = txn.objectStore('Contacts');
        //
        let query = store.put(contact);

        // handle success case
        query.onsuccess = function (event) {
            console.log(event);
        };

        // handle the error case
        query.onerror = function (event) {
            console.log(event.target.errorCode);
        }

        // close the database once the transaction completes
        txn.oncomplete = function () {
            db.close();
        };
    }

    //5) Read data from the object store by key

    function getContactById(db, id) {
        const txn = db.transaction('Contacts', 'readonly');
        const store = txn.objectStore('Contacts');

        let query = store.get(id);

        query.onsuccess = (event) => {
            if (!event.target.result) {
                console.log(`The contact with ${id} not found`);
            } else {
                console.table(event.target.result);
            }
        };

        query.onerror = (event) => {
            console.log(event.target.errorCode);
        }

        txn.oncomplete = function () {
            db.close();
        };
    };

    //6) Read data from the object store by an index
    function getContactByEmail(db, email) {
        const txn = db.transaction('Contacts', 'readonly');
        const store = txn.objectStore('Contacts');

        // get the index from the Object Store
        const index = store.index('email');
        // query by indexes
        let query = index.get(email);

        // return the result object on success
        query.onsuccess = (event) => {
            console.log(query.result); // result objects
        };

        query.onerror = (event) => {
            console.log(event.target.errorCode);
        }

        // close the database connection
        txn.oncomplete = function () {
            db.close();
        };
    }

    //7) Read all data from an object store
    function getAllContacts(db) {
        const txn = db.transaction('Contacts', "readonly");
        const objectStore = txn.objectStore('Contacts');

        //The objectStore.openCursor() returns a cursor used to iterate over an object store.
        objectStore.openCursor().onsuccess = (event) => {
            let cursor = event.target.result;
            if (cursor) {
                let contact = cursor.value;
                console.log(contact);
                // continue next record
                cursor.continue();
            }
        };
        // close the database connection
        txn.oncomplete = function () {
            db.close();
        };
    }

    //8) Delete a contact
    function deleteContact(db, id) {
        // create a new transaction
        const txn = db.transaction('Contacts', 'readwrite');

        // get the Contacts object store
        const store = txn.objectStore('Contacts');
        //
        let query = store.delete(id);

        // handle the success case
        query.onsuccess = function (event) {
            console.log(event);
        };

        // handle the error case
        query.onerror = function (event) {
            console.log(event.target.errorCode);
        }

        // close the database once the transaction completes
        txn.oncomplete = function () {
            db.close();
        };
    }

})();