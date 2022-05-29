# Consider the ORDER_COSTS table below. 
# Using this table and the CUSTOMERS table, find the following:
# In which states do customers spend, on average, more than 164 on their orders? 
# Fetch those states and average order costs in those states. 
#Results should be ordered from lowest cost to highest.

select customer_state, avg(cost) as average_cost
from order_costs oc
join customers  c on c.customer_id = oc.cid
group by c.customer_state
having average_cost >164
order by average_cost;

# Implement the following function get_month. It takes as input a month as an integer.
# It needs to compute: In the given month, how many payments were made with each different payment type?
# e.g.: Credit card -> 5000 payments, debit card -> 100 payments, voucher -> 300 payments, ...
# HINT: One of the MySQL functions we covered in the PS makes it easy to work with months.

select payment_type, count(payment_type)
from order_payments op
join orders o on o.order_id = op.order_id
where month(o.order_purchase_timestamp) = 2
group by op.payment_type;

# Consider the PRODUCTS table below and the ORDER_ITEMS table from earlier. 
# For each product category other than {"moveis_decoracao", "beleza_saude"}, find the minimum price that was paid for
# an item from that category. Limit the result to retrieve only 6 rows.

# The result should be like: category1 -> minprice1, category2 -> minprice2, ...

select product_category_name, min(price)
from products
join order_items on order_items.product_id = products.product_id
group by product_category_name
having product_category_name != "moveis_decoracao" and product_category_name != "beleza_saude"
limit 6;

# Let us define "large products" as those products with weight > 400 and length > 10.
# Some orders that contain a large product can have large discrepancies between their order_delivered_carrier_date and 
# order_delivered_customer_date. 
# Let us define "strange orders that contain large products" as those orders which contain a large product and the 
# difference between their order_delivered_carrier_date and order_delivered_customer_date is larger than 20 days.

# For all "strange orders that contain large products", find their order IDs and the number of days difference between 
# their order_delivered_carrier_date and order_delivered_customer_date.
# Result should be like: "abc21312df" -> 32, "dhs230kdf8" -> 29, ...

# HINT: Using the same MySQL function as Question 1 may help.
select distinct o.order_id , abs(timestampdiff(day, order_delivered_customer_date, order_delivered_carrier_date))
from orders o 
join order_items oi on o.order_id = oi.order_id
join products p on oi.product_id = p.product_id
where p.product_weight_g >400 and p.product_height_cm > 10  
and abs(timestampdiff(day, order_delivered_customer_date, order_delivered_carrier_date)) > 20
order by o.order_id;

# Write an SQL query to find the total number of orders per week day, e.g., Monday -> 150 orders, Tuesday -> 200 orders,
# Wednesday -> 500 orders, etc. Use the "order_purchase_timestamp" attribute when counting the number of orders.
# Plot the result using a bar chart (days of week on x-axis, number of orders on y-axis). 

# HINT: Check out the "WEEKDAY" function of MySQL. 
select dayname(order_purchase_timestamp) as week_day,count(*)
from orders
group by week_day




























