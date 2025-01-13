Note: INTO, LIKE for copy table
## Querying data

- MySQL **SELECT** statement doesn’t require the **FROM** clause.
- When executing the SELECT statement, MySQL evaluates the FROM clause before the SELECT clause (if has)

```sql
SELECT CONCAT(“HI",”MySql") 
```
- Assign an alias to a column to make it more readable. (here, **as** is optional)

### Evaluation Order
- The evaluation order is so important because when we use aliases, sometimes it may not work if the relevant CLAUSE executes before the SELECT statement.

## Sorting data

- By default, the ORDER BY clause uses ASC if you don’t explicitly specify any option
- The evaluation order **FROM->SELECT->ORDER BY**
- In MySQL, NULL is lower than non-NULL values

```sql
SELECT 
    contactLastname, contactFirstname
FROM
    customers
ORDER BY contactLastname DESC , contactFirstname ASC;
```
- The ORDER BY  clause sorts the result set by the last name in descending order first and then sorts the sorted result set by the first name in ascending order to make the final result set. (Guess here are multiple records with same lastName but with different firstName)

```sql
#The FIELD() function returns the position of the value in the list of values value1, value2, and so on
#FIELD(value, value1, value2, ...)

SELECT orderNumber,status FROM orders 
ORDER BY  FIELD(status, 'In Process', 'On Hold', 'Cancelled', 'Resolved', 'Disputed', 'Shipped');
```

## Filtering data

- MySQL evaluates the WHERE clause after the FROM clause and before the SELECT and ORDER BY clauses.
    **FROM->WHERE->SELECT->ORDER_BY**
- In the database world, NULL is a marker that indicates that a value is missing or unknown. NULL is not equivalent to the number 0 or an empty string. SO use **IS NULL** in where clauses instead of (=)

```sql
SELECT firstName, lastName FROM employees WHERE lastName LIKE '%son' ORDER BY firstName;
```
- Use the MySQL DISTINCT clause to remove duplicate rows from the result set returned by the SELECT clause.
- MySQL doesn’t have a built-in Boolean type. Instead, it uses the number zero as FALSE and non-zero values as TRUE.
- So,logical AND operator returns 1 or 0, and returns NULL if either operand is non-zero or both operands are NULL.
- MySQL evaluates the OR operator after the AND operator if an expression contains both AND and OR operators.
    - Use parentheses to change the order of evaluation.

```sql
SELECT 1 OR 0 AND 0;
SELECT (1 OR 0) AND 0;
```
- Use the IN operator to check if a value is in a set of values.

```sql
#The value can be a column or an expression.
...value IN (value1, value2, value3,...)

SELECT 1 IN (1,2,3); #returns 1 because 1 is in the list
```
- Use the MySQL NOT IN to check if a value doesn’t match any value in a list.

### wildcard characters (%, _)

- The percentage ( % ) wildcard matches any string of zero or more characters
    **s% => sun, six | %on => Patterson,Thompson | %on% => Bondur,Bondur**
- The underscore ( _ ) wildcard matches any single character.
    **se_  => see, sea | T_m => tom, tim**
- When the pattern contains the wildcard character and you want to treat it as a regular character, you can use the ESCAPE clause.
- To ensure the LIMIT clause returns an expected output, you should always use it with an ORDER BY clause

```sql
SELECT select_list
FROM table_name
ORDER BY  sort_expression LIMIT offset, row_count;
#from row *offset *row_count num of rows will be returned, 1st row is 0
#alternative way -> LIMIT row_count OFFSET offset
```
- When you use the LIMIT clause with one argument, mysql use this to determine the maximum number of rows to return from the first row of the result set

```sql
...LIMIT row_count; === LIMIT 0 , row_count;
```
- The following finds the customer who has the second-highest credit (Note that this technique works when there are no two customers who have the same credit limits. To get a more accurate result, you should use the DENSE_RANK() window function.)

```sql
SELECT customerName, creditLimit FROM customers ORDER BY creditLimit DESC LIMIT 1,1;
```

## Joining tables

- You cannot use a column alias in the WHERE clause. The reason is that when MySQL evaluates the WHERE clause, the values of columns specified in the SELECT clause have not been evaluated yet
- MySQL hasn’t supported the FULL OUTER JOIN yet.
- The left table is the table mentioned before the LEFT/RIGHT JOIN clause.The right table is the table mentioned after the LEFT/RIGHT JOIN clause.
- To find the committee members who are not in the members table, you use this query

```sql
SELECT m.member_id,m.name AS member,c.committee_id, c.name AS committee
FROM members m
RIGHT JOIN committees c USING(name)
WHERE m.member_id IS NULL;
```
- These two are different, 2nd one returns all orders; However, only the order `10123` will have associated line items as shown in the query result

``` sql
SELECT o.orderNumber, customerNumber, productCode FROM orders o LEFT JOIN orderDetails USING(orderNumber) WHERE orderNumber = 10123;

SELECT o.orderNumber, customerNumber, productCode FROM orders o LEFT JOIN orderDetails d ON o.orderNumber = d.orderNumber AND o.orderNumber = 10123;
```
- Notice that for INNER JOIN clause, the condition in the ON clause is equivalent to the condition in the WHERE clause.
- The RIGHT OUTER JOIN is the synonym of the RIGHT JOIN
- Use table aliases and inner join or left join to perform a self join in MySQL. //REFER MORE

## Grouping data

### Group By

- The GROUP BY clause groups rows into summary rows based on column values or expressions. It returns one row for each group and reduces the number of rows in the result set.
- Place the GROUP BY clause after the FROM and WHERE clauses
- MySQL evaluates the GROUP BY clause after the FROM and WHERE clauses but before the HAVING, SELECT, DISTINCT, ORDER BY and LIMIT clauses
- To obtain the number of orders in each status

```sql
SELECT status, COUNT(*) FROM orders GROUP BY status;
```
- If you use the GROUP BY clause in the SELECT statement without using aggregate functions, the GROUP BY clause behaves like the DISTINCT clause.

### Having

- The HAVING clause applies the condition to groups of rows, while the WHERE clause applies the condition to individual rows.
- If you omit the GROUP BY clause, the HAVING clause behaves like the WHERE clause
**FROM->WHERE->GROUP_BY->HAVING->SELECT->DISTINCT->ORDER_BY->LIMIT**
- To filter the groups returned by GROUP BY clause, you use a  HAVING clause.
```sql
...GROUP BY year HAVING year > 2003;

SELECT ordernumber, SUM(quantityOrdered) AS itemsCount, SUM(quantityOrdered*priceeach) AS total 
FROM orderdetails 
GROUP BY ordernumber HAVING total > 1000;
```
- Use the HAVING COUNT clause to filter groups by the number of items in each group.

## Subqueries
- A query contain within another query like SELECT, INSERT, UPDATE, DELETE
- SubQuery evaluates first

```sql
SELECT lastName,
         officeCode
FROM employees
WHERE officeCode IN 
    (SELECT officeCode
    FROM offices
    WHERE country = 'USA');

#this is similar to WHERE officeCode IN (1,2,3)
#Operand should contain 1 column(s)
#IN,NOT IN, comparison OPERATORS,EXISTS and NOT EXISTS
```
- When a subquery is used with the EXISTS or NOT EXISTS operator, a subquery returns a Boolean value of TRUE or FALSE.
- When you use a subquery in the FROM clause, the result set returned from a subquery is used as a temporary table. This table is referred to as a derived table or materialized subquery.

### correlated subquery
- Subqueries are  independent as they are standalone.
- A correlated subquery is a subquery that uses the data from the outer query. In other words, a correlated subquery depends on the outer query. A correlated subquery is evaluated once for each row in the outer query.

```sql
#1
SELECT productname,
         buyprice
FROM products AS p1
WHERE buyprice > 
    (SELECT AVG(buyprice)
    FROM products
    WHERE productline = p1.productline)
#2
SELECT customerNumber,
         customerName
FROM customers
WHERE EXISTS
    (SELECT orderNumber,
         SUM(priceEach * quantityOrdered)
    FROM orderdetails
    INNER JOIN orders
    USING (orderNumber)
    WHERE customerNumber = customers.customerNumber
    GROUP BY  orderNumber
    HAVING SUM(priceEach * quantityOrdered) > 60000);
```
### derived tables

![DerivedTables.png](./DerivedTables.png)

```sql
SELECT 
    customerGroup, 
    COUNT(cg.customerGroup) AS groupCount
FROM
    (SELECT 
        customerNumber,
            ROUND(SUM(quantityOrdered * priceEach)) sales,
            (CASE
                WHEN SUM(quantityOrdered * priceEach) < 10000 THEN 'Silver'
                WHEN SUM(quantityOrdered * priceEach) BETWEEN 10000 AND 100000 THEN 'Gold'
                WHEN SUM(quantityOrdered * priceEach) > 100000 THEN 'Platinum'
            END) customerGroup
    FROM
        orderdetails
    INNER JOIN orders USING (orderNumber)
    WHERE
        YEAR(shippedDate) = 2003
    GROUP BY customerNumber) cg
GROUP BY cg.customerGroup;    
```

- For some scenarios, both the **IN** and **EXISTS** clauses can be used, but since the **EXISTS** operator works based on the
  **at least found** principle, it is much faster.
- However, the query that uses the IN operator will perform faster if the result set returned from the subquery is very small.

```sql
#1
SELECT * FROM customers c1
WHERE customerNumber IN 
    (SELECT customerNumber FROM orders );
#2    
SELECT * FROM customers c1
WHERE EXISTS 
    (SELECT *  FROM orders o  WHERE c1.customerNumber = o.customerNumber );
```

## Set operators
- To combine result set of two or more queries using the UNION operator.
- First, the number and the orders of columns that appear in all SELECT statements must be the same.
- Second, the data types of columns must be the same or compatible.
- By default, the UNION operator removes duplicate rows even if you don’t specify the DISTINCT operator explicitly. **SELECT column_list UNION [DISTINCT | ALL]**
- A JOIN combines result sets horizontally, a UNION appends result set vertically.
- Use the MySQL **EXCEPT** operator to retrieve rows from one result set that do not appear in another result set. And it follows the same rules like in UNION operator.
- Use the MySQL **INTERSECT** operator to find the rows that are common to multiple query results. And it follows the same rules like in UNION operator.

## Managing databases
- Directly login MYSQL with a database name **mysql -u root -D classicmodels -p**
- Review the created database **SHOW CREATE DATABASE testdb;**
- Unlike MySQL, where schema and database are interchangeable, in standard SQL (and many RDBMS like PostgreSQL, SQL Server, or Oracle), they are distinct concepts.
- In standard SQL, CREATE DATABASE creates a new database, while CREATE SCHEMA organizes objects within an existing database.

## Working with tables
- **CREATE TABLE [IF NOT EXISTS] table_name(column1 datatype constraints,...) ENGINE=storage_engine;**
- The **SELECT LAST_INSERT_ID();** query returns the last auto-increment value generated for the ID column.
- MySQL does not have the built-in BOOLEAN or BOOL data type. To represent boolean values, MySQL uses the smallest integer type which is TINYINT(1).
- CHAR and BINARY are fixed length while VARCHAR and VARBINARY are variable length string data types.

```sql
#Insert data into a tbale from other tables
INSERT INTO credits(customerNumber, creditLimit)
SELECT customerNumber, creditLimit FROM customers WHERE creditLimit > 0;
```

### ALTER Table/s

```sql
ALTER TABLE tbl ADD col1 column_definition  [FIRST | AFTER column_name], col2 column_definition  [FIRST | AFTER column_name]...
#Adding a new NOT NULL columns to an existing table will populated with default values

ALTER TABLE tbl MODIFY col1 column_definition [ FIRST | AFTER column_name], col1 column_definition [ FIRST | AFTER column_name]...;

ALTER TABLE tbl CHANGE COLUMN original_name new_name column_definition [FIRST | AFTER column_name];

ALTER TABLE table_name DROP COLUMN column_name;
#The COLUMN keyword in the DROP COLUMN clause is optional
#Before droping, need to check use cases of the column like FKs,SPs,Views,Triggers...

ALTER TABLE table_name RENAME TO new_table_name;

#Note:
RENAME TABLE table_name TO new_table_name;

DROP [TEMPORARY] TABLE [IF EXISTS] tbl1,tbl2...;
```
- Note that you cannot use the RENAME TABLE statement to rename a temporary table, but you can use the ALTER TABLE statement to rename a temporary table.

- Use **DESCRIBE tabel_name; / DESC tabel_name;** to get the list of columns in a table with their definitions.
- Use **CHECK TABLE tbl_name;** to check the status of the table/view.
- Use **SHOW WARNINGS;** to show the warning

- In terms of security, any existing privileges that you granted to the old table must be manually migrated to the new table when using RENAME TABLE.
- And you’ll need to manually adjust other database objects, including views, stored procedures, triggers, and foreign key constraints that reference the table.
- Check is a column exist in a table

```sql
SELECT IF(count(*) = 1, 'Exist','Not Exist') AS result
FROM information_schema.columns
WHERE table_schema = 'classicmodels' AND table_name = 'vendors' AND column_name = 'phone';
```
- MySQL allows a table to have up to one auto-increment column and that column must be defined as a key.
- If we add new auto-increment id column to an existing table, it will add ids for existing rows as well.
- Note that the DROP TABLE statement only drops tables. It doesn’t remove specific user privileges associated with the tables. Therefore, if you create a table with the same name as the dropped one, MySQL will apply the existing privileges to the new table, which may pose a security risk.
- To execute the DROP TABLE statement, you must have DROP privileges for the table that you want to remove.
- If you want to drop multiple tables that have a specific pattern in a database, you can't use the LIKE operator; instead, you have to write a separate mechanism or use SPs.

### Temporary tables

- MySQL removes the temporary table automatically when the session ends or the connection is terminated.
- A temporary table is only available and accessible to the client that creates it.
- In the same session, two temporary tables cannot share the same name.
- If you create a temporary table named **employees** in the sample database, the existing **employees** table becomes **inaccessible**.
- To create a temporary table whose structure is based on an existing table, you cannot use the CREATE TEMPORARY TABLE ... LIKE statement.

```sql
CREATE TEMPORARY TABLE temp_table_name
SELECT * FROM original_table LIMIT 0;
```

### Truncateing a Table
```sql
TRUNCATE [TABLE] table_name; #The TABLE keyword is optional, but to distinguish TRUNCATE TABLE and TRUNCATE() use it.
```
- Truncating a table resets AUTO_INCREMENT values to zero.
- If there is any FOREIGN KEY constraints from other tables that reference the table that you truncate, the TRUNCATE TABLE statement will fail.
- It cannot be rolled back.
- TRUNCATE TABLE statement is more efficient than the DELETE statement because it drops and recreates the table instead of deleting rows one by one.

### Generated Column
- Use a MySQL Generated column to store data computed from an expression or other columns.
```sql
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    fullname varchar(101) GENERATED ALWAYS AS (CONCAT(first_name,' ',last_name))
);

column_name data_type [GENERATED ALWAYS] AS (expression) [VIRTUAL | STORED] [UNIQUE [KEY]]
```
- MySQL provides two types of generated columns: stored and virtual. The virtual columns are calculated on the fly each time data is read whereas the stored columns are calculated and stored physically when the data is updated. default is VIRTUAL.
- The **expression** can contain literals, and built-in functions with no parameters, operators, or references to any column within the same table. If you use a function, it must be scalar and deterministic.
- If the generated column is **stored**, you can define a **unique constraint** for it.

## MySQL constraints
