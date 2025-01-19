# React
# Describing the UI

## Props

* When you place content within a JSX tag, the parent component automatically receives that content as a `children` prop. For instance, in the example below, the **Card** component receives the **children** prop containing ****<Avatar />**** and renders it inside a wrapper **div**.

    ```javascript
    function Card({ myProp, children }) {
      return (
        <div className="card">
          {children}
        </div>
      );
    }
    
    export default function Profile() {
      return ( <Card myProp={...}>  <Avatar/>  </Card> );
    }
    ```

## Rendering a List

* When using JSX elements directly inside a `map()` call, you must always assign them unique **keys**. Keys help React identify and manage elements efficiently. Keep in mind: 
- **Keys must be unique among siblings.**  
- **Keys should remain stable and not change over time.**  
- **Avoid generating keys dynamically during rendering.**

## Keeping Components Pure

* In general, you should not rely on components being rendered in any specific order.  

- **Avoid side effects caused by shared state:** If a component reads and writes to a shared variable (e.g., a `guest` variable declared outside the component), rendering it multiple times may lead to inconsistent JSX.  
- **Unpredictable behavior:** Other components that access the same shared variable will produce different JSX depending on when they are rendered. This lack of predictability can lead to bugs and unintended behavior.

    ```javascript
    #Bad
    let guest = 0;    
    function Cup() {
      guest = guest + 1;// Bad: changing a preexisting variable!
      return <h2>Tea cup for guest #{guest}</h2>;
    }
    
    export default function TeaSet() {
      return (
        <>
          <Cup /><Cup /><Cup />
        </>
      );
    }
    
    #Good
    function Cup({ guest }) {
      return <h2>Tea cup for guest #{guest}</h2>;
    }
    
    export default function TeaSet() {
      return (
        <>
          <Cup guest={1} /><Cup guest={2} /><Cup guest={3} />
        </>
      );
    }
    ```

# Adding Interactivity

## Responding to Events

* Functions passed to event handlers must be passed, not called. For example:
    ```javascript
    <button onClick={handleClick}> //passing a function (correct)
    <button onClick={handleClick()}>//calling a function (incorrect)
    ``` 
* This tells React to remember it and only call your function when the user clicks the button.
* In the second example, the () at the end of handleClick() fires the function immediately during rendering, without any clicks
    ```javascript
    <button onClick={() => alert('...')}> //passing a function (correct)
    <button onClick={alert('...')}> //calling a function (incorrect)
    ```
* In both cases, what you want to pass is a function:

* Because event handlers are declared inside of a component, they have access to the component’s props.

* All events propagate in React except onScroll, which only works on the JSX tag you attach it to.
    ```javascript
    export default function Toolbar() {
      const handleClick = () => {
          alert('You clicked on the toolbar!');
      };
      
      return (
        <div className="Toolbar" onClick={handleClick}>
          <button onClick={() => alert('Playing!')}>
            Play Movie
          </button>
          <button onClick={(e) => {
                e.stopPropagation();
                alert('Uploading!') }
          }> Upload Image with no propagation/bubbling</button>    
        </div>
      );
    }
    ```

## A Component’s Memory and State in React

1. **State vs. Local Variables**:

   * **State** retains information between renders, while local variables reset each time a component re*renders.
   * **State updates trigger re*renders**, whereas changes to local variables do not.

2. **Understanding State**:

   * State is private to a component and cannot be changed by parent components.
   * Use **useState** to declare and manage state in a functional component.
   * State updates are asynchronous and processed after event handlers complete (called **batching**).

3. **How React Handles Renders**:

   * React calls the component function, which returns a JSX snapshot based on the state (at that time).
   * React updates the UI to match this snapshot.
   * State remains fixed during a render; updates apply only in the next render.

4. **Managing Multiple State Updates**:

   * Calling **setState** multiple times with the same value may not behave as expected due to state snapshots.
   * Use **updater functions** (e.g., **setNumber(n => n + 1)**) to ensure updates are based on the latest state.

        ```javascript
        <button onClick={() => {
          setNumber(number + 1);
          setNumber(number + 1);
          setNumber(number + 1);}}>+3</button>
        //In each function React prepares to change number to 1 on the next render since initial value is 0
        //Its value was “fixed” when React “took the snapshot” of the UI by calling your component.
        ```
     * To summarize, here’s how you can think of what you’re passing to the setNumber state setter:
        1. An updater function (**e.g. n => n + 1**) gets added to the queue.
        2. Any other value (**e.g. number 5**) adds “replace with 5” to the queue, ignoring what’s already queued.

5. **Updating Objects and Arrays in State**:

   * State objects and arrays should be treated as **immutable**. Do not modify them directly; instead, create a copy and update it.
   * Example for objects:
     ```javascript
     setPerson({
       ...person,
       firstName: e.target.value,
     });
     ```
   * Example for arrays:
     ```javascript
     setArtists([
       ...artists,
       { id: nextId++, name: name },
     ]);
     ```

6. **Key Patterns for State Management**:

   * **Objects**: Use the spread operator (**...**) to copy and update fields.
   * **Arrays**: Use array methods like **map**, **filter**, or **slice** to create a new array and apply changes (e.g., adding, removing, or transforming items).

7. **Best Practices**:

   * Keep state values immutable to ensure React re*renders correctly.
   * Use updater functions for sequential updates in event handlers.
   * Avoid defining hooks inside conditional blocks or nested functions.

# Managing State


