## Querying data

- MySQL **SELECT** statement doesn’t require the **FROM** clause.
- When executing the SELECT statement, MySQL evaluates the FROM clause before the SELECT clause (if has)

```sql
SELECT CONCAT(“HI",”MySql") 
```
- Assign an alias to a column to make it more readable. (here, **as** is optional)

## Evaluation Order
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