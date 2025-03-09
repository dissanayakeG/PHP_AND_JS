# Stored procedures

## Basic MySQL Stored procedures

- A stored procedure is a wrapper of a set of SQL statements stored in the MySQL database server.
- If you invoke the same stored procedure again within the same session, MySQL will execute it from the cache without the need for recompilation.
- The advantages of stored procedures include reduced network traffic, enhanced code reusability, improved security through controlled access, streamlined implementation of business logic, and the ability to grant specific privileges to applications without exposing underlying database structures.
- The disadvantages of stored procedures include increased memory usage for each connection, challenges in debugging due to a lack of dedicated tools, and the necessity for a specialized skill set, which not all application developers may possess, leading to potential difficulties in both development and maintenance processes.
- default delimiter (;) uses to separate statements and execute each separately.
- Since a SP consist of multiple statements, mysql client need a different delimiter in order to treat the entire stored procedure as a single statement.

```sql
DELIMITER //

CREATE PROCEDURE sp_name(parameter_list)
BEGIN
   statements;
END //

DELIMITER ;
```

### SP Parameter types

```sql
[IN | OUT | INOUT] parameter_name datatype[(length)]
```

1. IN : default | calling program must pass an argument | protected, changing value within SP does not change original value, work with a copy of the value.
2. OUT : can be modified | updated value is then passed back to the calling program |  cannot access the initial value of the OUT parameter when they begin.
3. INOUT : calling program may pass the argument | can modify | pass the new value back to the calling program.

```sql
#pass a session variable ( @total ) to receive the return value.
CALL GetOrderCountByStatus('Shipped',@total); #1st IN 2nd OUT
SELECT @total;

#INOUT
DELIMITER $$

CREATE PROCEDURE SetCounter(
	INOUT counter INT,
    IN inc INT
)
BEGIN
	SET counter = counter + inc;
END$$

DELIMITER ;

SET @counter = 1;
CALL SetCounter(@counter,1); -- 2
CALL SetCounter(@counter,1); -- 3
CALL SetCounter(@counter,5); -- 8
SELECT @counter; -- 8
```

### Variables

```sql
DECLARE variable_name datatype(size) [DEFAULT default_value];
DECLARE totalSale DEC(10,2) DEFAULT 0.0;

#Assigning variables
SET variable_name = value;
SELECT COUNT(*) INTO productCount FROM products;
```
- A variable whose name begins with the @ sign is a session variable, available and accessible until the session ends.

### Listing Stored Procedures

```sql
SHOW PROCEDURE STATUS [LIKE 'pattern' | WHERE search_condition]
SHOW PROCEDURE STATUS;
SHOW PROCEDURE STATUS WHERE db = 'classicmodels';
SHOW PROCEDURE STATUS LIKE '%Order%'
```

## Conditional Statements
- IF statement is different tahat IF() function.
- IF...THEN | IF...THEN...ELSE | IF...THEN...ELSEIF...ELSE

```sql
DELIMITER $$

CREATE PROCEDURE GetCustomerLevel(
    IN  pCustomerNumber INT, 
    OUT pCustomerLevel  VARCHAR(20))
BEGIN
    DECLARE credit DECIMAL(10,2) DEFAULT 0;

    SELECT creditLimit 
    INTO credit
    FROM customers
    WHERE customerNumber = pCustomerNumber;

    IF credit > 50000 THEN
        SET pCustomerLevel = 'PLATINUM';
    ELSEIF credit <= 50000 AND credit > 10000 THEN
        SET pCustomerLevel = 'GOLD';
    ELSE
        SET pCustomerLevel = 'SILVER';
    END IF;
END$$

DELIMITER ;

CALL GetCustomerLevel(141, @level);
SELECT @level; #PLATINUM
```
- CASE expression if differs from the CASE statement.
- Simple CASE statement |Searched CASE statement.

### Simple CASE statement

- To avoid the error when the case_value does not equal any when_value, you can use an empty BEGIN...END block in the ELSE clause.
- The simple CASE statement tests for equality ( =), therefore, you cannot use it to test equality with NULL because NULL = NULL returns FALSE.

```sql
CASE case_value
    WHEN when_value1 THEN ...
    WHEN when_value2 THEN ...
    ELSE 
        BEGIN
        END;
END CASE;
```
### Searched CASE statement

- Use a simple CASE statement to evaluate a specific expression against a series of possible values and execute corresponding actions.
- Use a searched CASE statement to evaluate various conditions individually, allowing for a more flexible code.

## Loops

```sql
#LOOP

[label]: LOOP
    IF condition THEN
        LEAVE [label]; //The loop exits when the LEAVE statement is reached.
        #ITERATE [label]; //to skip the current iteration
    END IF;
END LOOP;

#WHILE

[begin_label:] WHILE search_condition DO
    statement_list
END WHILE [end_label]

# REPEAT

[begin_label:] REPEAT
    statement;
UNTIL condition
END REPEAT [end_label]
```

- It’s important to note that the REPEAT checks the condition after the execution of the block, meaning that the block always executes at least once.
- The LEAVE statement exits the flow control that has a given label.
- Use the MySQL LEAVE statement to exit a stored procedure or terminate a loop.

## Error Handling

### Show Warnings

```sql
SHOW WARNINGS;
SHOW WARNINGS [LIMIT [offset,] row_count] --> SHOW WARNINGS LIMIT 2;
SHOW COUNT(*) WARNINGS;
SELECT @@warning_count; #system variable:

SHOW VARIABLES LIKE 'max_error_count';
SET max_error_count=2048;
```
- MySQL uses the max_error_count system variable to control the maximum number of warnings, errors, and notes that the server can store.

### Show ERRORS

- The SHOW ERRORS statement is used to display error information about the most recent execution of a statement or a stored procedure.

```sql
SHOW ERRORS;
SHOW ERRORS [LIMIT [offset,] row_count];
SHOW COUNT(*) ERRORS;
SELECT @@error_count; # system variable
```

### DECLARE … HANDLER

- Use MySQL handlers to handle conditions including warnings and errors in stored procedures.
- Use the DECLARE...HANDLER statement to declare a handler.
- SQLSTATE is a five-character that provides information about the result of an SQL operation.
    - An SQLSTATE consists of two parts:
    1. Class Code (First two characters): Indicates the general category of the error.
    2. Subclass Code (Next three characters): Provides more specific information about the error within the general category.
- For example, a SQLSTATE code of ’42S02′ indicates a missing table, where ’42’ is the class code for syntax error or access rule violation, and ‘S02’ is the subclass code indicating that the table is not found.

```sql
DECLARE { EXIT | CONTINUE } HANDLER
    FOR condition_value [, condition_value] ...
    statement

#Example
DELIMITER //

CREATE PROCEDURE insert_user(
	IN p_username VARCHAR(50), 
    IN p_email VARCHAR(50)
)
BEGIN
  -- SQLSTATE for unique constraint violation
  DECLARE EXIT HANDLER FOR SQLSTATE '23000'
  BEGIN
    -- Handler actions when a duplicate username is detected
    SELECT 'Error: Duplicate username. Please choose a different username.' AS Message;
  END;

  -- Attempt to insert the user into the table
  INSERT INTO users (username, email) VALUES (p_username, p_email);

  -- If the insertion was successful, display a success message
  SELECT 'User inserted successfully' AS Message;

END //

DELIMITER ;

#call
CALL insert_user('jane','jane@example.com');
```

### DECLARE ... CONDITION

- Use MySQL DECLARE ... CONDITION to associate a name with a condition specified by a MySQL error code or SQLSTATE value to make the stored procedure code more readable and expressive.

```sql
DECLARE unknown_table CONDITION FOR 1051;
DECLARE CONTINUE HANDLER FOR unknown_table 
  BEGIN
    -- body of handler
  END;
```

### SIGNALs

- The MySQL SIGNAL statement allows you to raise an exception within a stored program, including a stored procedure, a stored function, a trigger, or an event.
- condition_value can be An SQLSTATE valu or A named condition is defined with DECLARE ... CONDITION statement.

```sql
DELIMITER //

CREATE PROCEDURE update_salary(
	IN p_employee_id INT,
    IN p_salary DECIMAL
)
BEGIN 
	DECLARE employee_count INT;
    
    -- check if employee exists
    SELECT COUNT(*) INTO employee_count 
    FROM employees
    WHERE id = p_employee_id;
    
    IF employee_count = 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Employee not found';
    END IF;
    
    -- validate salary
    IF p_salary < 0 THEN
		SIGNAL SQLSTATE '45000'
		SET MESSAGE_TEXT = 'Salary cannot be negative';
    END IF;
    
    -- if every is fine, update the salary
    UPDATE employees
    SET salary = p_salary
    WHERE id = p_employee_id;    

END //

DELIMITER ;
```

### RESIGNAL

- Use the RESIGNAL statement to re-raise an exception.

```sql
#1) Using MySQL RESIGNAL to re-raise the same exception
DELIMITER //

CREATE PROCEDURE DropTableXYZ()
BEGIN
  -- reraise the error
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    RESIGNAL;
  END;
  
  -- drop a table that doesn't exist
  DROP TABLE XYZ;
END//

DELIMITER ;

-- ERROR 1051 (42S02): Unknown table 'classicmodels.xyz'

#2) Using RESIGNAL statement with new signal information	
BEGIN
  -- reraise the error
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    RESIGNAL SET MYSQL_ERRNO = 5;
  END;
  
  -- drop a table that doesn't exist
  DROP TABLE XYZ;
END//

-- ERROR 5 (42S02): Unknown table 'classicmodels.xyz'

#3) Re-rasing exception with new condition value and signal information:
BEGIN
  -- reraise the error
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    RESIGNAL SQLSTATE '45000' SET MYSQL_ERRNO = 5;
  END;
  
  -- drop a table that doesn't exist
  DROP TABLE XYZ;
END//

-- ERROR 5 (45000): Unknown table 'classicmodels.xyz'
```

## Cursor

- Cursors are used in stored procedures to iterate through a result set returned by a SELECT statement.
- Cursors are used to process a result set row by row individually.

```sql
DELIMITER $$

CREATE PROCEDURE create_email_list (
	INOUT email_list TEXT
)
BEGIN
	DECLARE done BOOL DEFAULT false;
	DECLARE email_address VARCHAR(100) DEFAULT "";
    
	-- declare cursor for employee email
	DECLARE cur CURSOR FOR SELECT email FROM employees;

	-- declare NOT FOUND handler
	DECLARE CONTINUE HANDLER 
        FOR NOT FOUND SET done = true;
	
    -- open the cursor
	OPEN cur;
	
    SET email_list = '';
	
    process_email: LOOP
		
        FETCH cur INTO email_address;
        
		IF done = true THEN 
			LEAVE process_email;
		END IF;
		
        -- concatenate the email into the emailList
		SET email_list = CONCAT(email_address,";",email_list);
	END LOOP;
    
    -- close the cursor
	CLOSE cur;

END$$

DELIMITER ;
```

### Prepared Statement

- helps you enhance the security and performance of database queries.
- Prepared statements allow you to write SQL queries with placeholders for parameters, and then bind values to those parameters at runtime. They can help prevent SQL injection attacks and optimize query execution.

```sql
PREPARE stmt_name FROM preparable_stmt;
SET @var_name1 = value1;
SET @var_name2 = value2;
EXECUTE stmt_name [USING @var_name [, @var_name] ...];
{DEALLOCATE | DROP} PREPARE stmt_name;
```
- The preparable_stmt is sent to the MySQL server with placeholders (?) for parameters. Upon receiving the statement, the MySQL server parses, optimizes, and precompiles the query, and then creates the prepared statement.
- Note : Note that you can use only user variables as the values for the parameters.

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE
);

PREPARE insert_user FROM 'INSERT INTO users (username, email) VALUES (?, ?)';
SET @username = 'john_doe';
SET @email = 'jone@example.com';
EXECUTE insert_user USING @username, @email;

#reuse, This time, MySQL will use the precompiled statement:
SET @username = 'jane_doe';
SET @email = 'jane@example.com';
EXECUTE insert_user USING @username, @email;
DEALLOCATE PREPARE insert_user;
```

## Stored Functions

- A stored function is a specialized type of stored program designed to return a single value. Typically, you use stored functions to encapsulate common formulas or business rules, making them reusable across SQL statements or other stored programs.
- Unlike a stored procedure, you can use a stored function in SQL statements wherever you use an expression.
- By default, stored functions consider all parameters as IN parameters. You cannot specify IN , OUT or INOUT modifiers to parameters
- A deterministic function always returns the same result for the same input parameters, while a non-deterministic function produces different results for the same input parameters.
- Inside the body section, you need to include at least one RETURN statement. The RETURN statement sends a value to the calling programs.

```sql
DELIMITER $$

CREATE FUNCTION CustomerLevel(
	credit DECIMAL(10,2)
) 
RETURNS VARCHAR(20)
DETERMINISTIC
BEGIN
    DECLARE customerLevel VARCHAR(20);

    IF credit > 50000 THEN
		SET customerLevel = 'PLATINUM';
    ELSEIF (credit >= 50000 AND 
			credit <= 10000) THEN
        SET customerLevel = 'GOLD';
    ELSEIF credit < 10000 THEN
        SET customerLevel = 'SILVER';
    END IF;
	-- return the customer level
	RETURN (customerLevel);
END$$

DELIMITER ;
```

```sql
SHOW FUNCTION STATUS WHERE db = 'classicmodels';
```
- It’s important to notice that if a stored function contains SQL statements that retrieve data from tables, then you should avoid using it in other SQL statements; otherwise, the stored function may slow down the query speed.
- stored functions can be called from select statements, stored procedures...ect
EX)
```sql
SELECT customerName, CustomerLevel(creditLimit)
FROM customers ORDER BY customerName;
```

### DROP FUNCTION

```sql
DROP FUNCTION [IF EXISTS] function_name;
```

### Listing Stored Functions

```sql
SHOW FUNCTION STATUS [LIKE 'pattern' | WHERE search_condition];
SHOW FUNCTION STATUS; # shows all stored functions in the current MySQL server
SHOW FUNCTION STATUS WHERE db = 'classicmodels';
SHOW FUNCTION STATUS LIKE '%pattern%';
#Note that the SHOW FUNCTION STATUS only shows the function that you have a privilege to access.
```

## Stored Program Security

- In MySQL, stored programs including stored procedures stored functions, triggers, and events execute within a security context which determines their privileges.

- MySQL uses DEFINER and SQL SECURITY characteristics to control these privileges.

## Transactions

- A transaction is a sequence of one or more SQL statements that are executed as a single unit of work.
- By default, when you execute an SQL statement, MySQL automatically wraps it in a transaction and commits the transaction automatically.
- To instruct MySQL to not start a transaction implicitly and commit the changes automatically, you set the value of the autocommit variable to 0 or OFF:

```sql
SET autocommit = OFF; #or
SET autocommit = 0;
```

- To enable the auto-commit mode, you set the value of the autocommit variable to 1 or ON:

```sql
SET autocommit = 1; #or
SET autocommit = ON;
```

- Use the START TRANSACTION statement to start a transaction.
- Use the COMMIT statement to apply the changes made during the transaction to the database.
- Use the ROLLBACK statement to roll back the changes made during the transaction and revert the state of the database before the transaction starts.

```sql
CREATE DATABASE banks;
USE banks;
CREATE TABLE users (
    id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255)
);

START TRANSACTION;
INSERT INTO users (id, username) 
VALUES (1, 'john');


UPDATE users 
SET email = 'john.doe@example.com' 
WHERE id = 1;

# SELECT * FROM users; shows the inserted data only for current session since it didn't commit yet
COMMIT;

# ROLLBACK; - undoes all the changes made during the transaction, reverting the database to its state before the transaction started
```

- transactions can be used in Stored Procedures for more advance transactions ([See](#https://www.mysqltutorial.org/mysql-stored-procedure/mysql-transactions/))
