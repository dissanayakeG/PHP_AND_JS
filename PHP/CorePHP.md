#### What is PHP

-   php is a scripting language like js, not a programming language
-   programming language = compile
-   scripting language = interpreted

-   browser make request->web server listen to it->try to find index.php->then interpret the code to machine code | if no found index.php it shows all the files and directories as list

-   static keyword can use for caching the values.

-   users can input scripts like `<script>alert('Hello');</script>` into input fields.
-   Hackers can input malicious code from another server to the user’s web browser, the risk is higher. This type of attack is called `cross-site scripting (XSS)` attack.
-   Therefore, before displaying user input on a webpage, you should always escape the data. To do that, you use the `htmlspecialchars()` function:

```php
<?php
if (isset($_POST['name'], $_POST['email'])) {
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);

	// show the $name and $email
	echo "Thanks $name for your subscription.<br>";
	echo "Please confirm it in your inbox of the email $email.";
} else {
	echo 'You need to provide your name and email address.';
}
?>
```

### `isset()` vs `filter_has_var()`

```php
<?php
$_POST['email'] = 'example@phptutorial.net';
if(isset($_POST['email'])) // return true

$_POST['email'] = 'example@phptutorial.net';
if(filter_has_var(INPUT_POST, 'email')) // return false //check request body

/**
 * Use the filter_has_var() function to check if a variable exists in a specified type, including INPUT_POST, INPUT_GET, INPUT_COOKIE, INPUT_SERVER, or INPUT_ENV.
*/
?>
```

-   Use `filter_input()` and `filter_var()` functions to validate and sanitize data.

#### `filter_var()` for sanitize and validate data

//filter_var ( mixed $value , int $filter = FILTER_DEFAULT , array|int $options = 0 ) : mixed

```php
<?php

if (filter_has_var(INPUT_GET, 'id')) {
	// sanitize id
	$clean_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

	// validate id
	$id = filter_var($clean_id, FILTER_VALIDATE_INT);

	// validate id with options
    $id = filter_var($clean_id, FILTER_VALIDATE_INT, ['options' => ['min_range' => 10]]);

	// show the id if it's valid
	echo $id === false ? 'Invalid id' : $id;
} else {
	echo 'id is required.';
}
?>
```

#### filter_input() for sanitize and validate data

- `filter_input ( int $type , string $var_name , int $filter = FILTER_DEFAULT , array|int $options = 0 ) : mixed`

- allows you to get an external variable by its name and filter it using one or more built-in filters.
- The following example uses the filter_input() function to sanitize data for a search form:

```php
<?php

$term_html = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);
$term_url = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_ENCODED);

?>
<form action="search.php" method="get">
    <label for="term"> Search </label>
    <input type="search" name="term" id="term" value="<?php echo $term_html ?>">
    <input type="submit" value="Search">
</form>

<?php

if (null !== $term_html) {
	echo "The search result for <mark> $term_html </mark>.";
}
```

#### `filter_input` vs. `filter_var`

-   If a variable doesn’t exist, the `filter_input()` function returns `null` while the `filter_var()` function returns an `empty string` and issues a `notice of an undefined index`.

-   Also, the `filter_input()` function doesn’t get the current values of the `$_GET`, `$_POST`, … superglobal variables. Instead, it uses the `original values submitted in the HTTP request`. For example:

```php
<?php

$_GET['term'] = 'PHP'; // doesn't have any effect on INPUT_GET
$term = filter_input(INPUT_GET, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

var_dump($term); //NULL

<?php

$_GET['term'] = 'PHP';
$term = filter_var($_GET['term'], FILTER_SANITIZE_SPECIAL_CHARS);

var_dump($term);//PHP
```
