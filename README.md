# E-commerce Database Setup Guide

This guide provides instructions for setting up the e-commerce database in MySQL or MariaDB. The database consists of tables for storing information about administrators, products, subscribers, and users.

## Prerequisites

- Ensure you have MySQL or MariaDB installed on your system. If not, you can install it using your package manager or by downloading it from the official website:
  - [MySQL Installation Guide](https://dev.mysql.com/doc/mysql-installation-excerpt/5.7/en/)
  - [MariaDB Installation Guide](https://mariadb.com/kb/en/getting-installing-and-upgrading-mariadb/)

## Database Schema

The e-commerce database schema consists of the following tables:

### `admins` Table

This table stores information about administrators who have access to the e-commerce platform.

```sql
CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### `products` Table

This table stores information about products available on the e-commerce platform.

```sql
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### `subscribers` Table

This table stores information about subscribers who have subscribed to the e-commerce platform.

```sql
CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

### `users` Table

This table stores information about users who have registered on the e-commerce platform.

```sql
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

## Setup Instructions

1. **Create Database**: Start by creating a new database in MySQL or MariaDB. You can name the database `ecommerce` or choose any other suitable name.

2. **Run SQL Script**: Use the provided SQL script to create the necessary tables in the database. You can execute the script using a MySQL/MariaDB client or by importing it through the terminal.

3. **Verify Setup**: Once the script has been executed successfully, verify that the tables have been created in the database by querying the database using SQL commands or a database management tool.

## Conclusion

You've now set up the e-commerce database schema in your MySQL or MariaDB environment. You can proceed to populate the tables with data and start using the database for your e-commerce application.

For more information on using MySQL or MariaDB, refer to their respective documentation:

- [MySQL Documentation](https://dev.mysql.com/doc/)
- [MariaDB Documentation](https://mariadb.com/kb/en/documentation/)
