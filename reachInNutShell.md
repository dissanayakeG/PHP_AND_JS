## Describing the UI

### Props
- When you nest content inside a JSX tag, the parent component will receive that content in a prop called children. For example, the Card component below will receive a children prop set to **<Avatar />** and render it in a wrapper div

### Rendering a List
- JSX elements directly inside a map() call always need keys!, Keys must be unique among siblings, Keys must not change or that defeats their purpose!
- Don’t generate them while rendering.

```javascript
function Card({ children }) {
  return (
    <div className="card">
      {children}
    </div>
  );
}

export default function Profile() {
  return ( <Card>  <Avatar/>  </Card> );
}
```

### Keeping Components Pure
- In general, you should not expect your components to be rendered in any particular order
- This component is reading and writing a guest variable declared outside of it. This means that calling this component multiple times will produce different JSX! And what’s more, if other components read guest, they will produce different JSX, too, depending on when they were rendered! That’s not predictable.
```javascript
#Bad
let guest = 0;

function Cup() {
  // Bad: changing a preexisting variable!
  guest = guest + 1;
  return <h2>Tea cup for guest #{guest}</h2>;
}

export default function TeaSet() {
  return (
    <>
      <Cup />
      <Cup />
      <Cup />
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
      <Cup guest={1} />
      <Cup guest={2} />
      <Cup guest={3} />
    </>
  );
}
```

## Adding Interactivity

### Responding to Events

- Functions passed to event handlers must be passed, not called. For example:
```javascript
<button onClick={handleClick}> //passing a function (correct)
<button onClick={handleClick()}>//calling a function (incorrect)
``` 
- This tells React to remember it and only call your function when the user clicks the button.
- In the second example, the () at the end of handleClick() fires the function immediately during rendering, without any clicks
```javascript
<button onClick={() => alert('...')}> //passing a function (correct)
<button onClick={alert('...')}> //calling a function (incorrect)
```
- In both cases, what you want to pass is a function:
- Because event handlers are declared inside of a component, they have access to the component’s props.

- All events propagate in React except onScroll, which only works on the JSX tag you attach it to.
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
### A Component's Memory
- Use a state variable when a component needs to “remember” some information between renders.
- Why local variable doesnt enough
- Local variables don’t persist between renders.
- Changes to local variables won’t trigger renders.
- To update a component with new data,Retain the data between renders and Trigger React to render the component with new data (re-rendering) are needed.
- Hooks are special functions that are only available while React is rendering.
- Hooks can only be called at the top level of your components or your own Hooks.
- If you find that you often change two state variables together, it might be easier to combine them into one. For example, Form - use an object as a state.
- Unlike props, state is fully private to the component declaring it. The parent component can’t change it.
- Hooks can only be called at the top level of the component function. Don't define then in if...else statements

