# Implementation of Role Based Access Control in PHP

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

## Overview

Open Source web-based implementation of **Role Based Access Control** (RBAC) in PHP. The implementation is flexible to integrate into any existing PHP project.

## Characteristics and Policies [1]

- within the RBAC framework, a **user** is a person, a **role** is a collection of job functions, and an **operation** represents a particular mode of access to a set of one or more protected RBAC objects; 

- the type of operations and the objects that RBAC controls is dependent on the type of system in which it will be implemented, e.g. within a  transaction management system, operations would take the form of and exhibit all the properties of a transaction;

- roles can have overlapping responsibilities and privileges, i.e. users belonging to different roles may need to perform common operations. RBAC therefore supports the concept of role hierarchies; 

- a **role hierarchy** defines roles that have unique attributes and that may contain other roles, i.e. that one role may implicitly include the operations, constraints, and objects that are associated with another role; 

- **role authorisation** (association of user with a role) can be subject to the following:
    - the user can be given no more privilege than is necessary to perform his/her job **(principle of least privilege)**; 
    - the role in which the user is gaining membership is not mutually exclusive with another role for which the user already possesses membership **(static separation of duty)**; & 
    - the numerical limitation that exists for role membership cannot be exceeded **(cardinality property)**; 
 
- **role activation** involves the mapping of a user to one or possibly many  roles. A user initiates a session during which the user is associated with a subset of roles for which that user has membership. A particular role for a user can be activated if: 
    - the user is authorised for the role being proposed for activation; 
    - the activation of the proposed role is not mutually exclusive with any other active role(s) of the user; 
    - the proposed operation is authorised for the role that is being proposed for activation; & 
    - the operation being proposed is consistent within a mandatory sequence of operations; 

- **role execution** of an operation can take place only if the subject is acting within an active role, i.e. once it is determined that a role is part of the authorised role set for the subject; 

- **dynamic separation of duty** can be provided with RBAC as long as the following rule is satisfied: a subject can become active in a new role  only if the proposed role is not mutually exclusive with any of the roles in which the subject is currently active; 

- **operation authorisation** can only be granted to a subject if the operation is authorised for the subjects proposed active role; 

- **operational separation of duty** requires that for all the operations associated with a particular business function, no single user can be allowed to perform all of these operations. In other words, a role can be associated with an operation of business function only if the role is an authorised role for the subject and the role had not been assigned previously to all of the other operations; 

- **object access authorisation** requires subject access to RBAC objects to be controlled. This ensures enforcement of enterprise policies to RBAC objects. A subject can access an object only if: 
    - the role is part of the subjects current **active role set**; 
    - the role is allowed to perform the operation; & 
    - the operation to access the object is authorised. 

## Implementation

**Database**    Four database tables are created to store role and permission information: the `roles` table stores a role ID and role name, the `permissions` table stores a permission ID and description, the `role_perm` table associates which permissions belong to which roles, and the `user_role` table associates which roles are assigned to which users.

**Model Classes**   `Role` class is to return a role object that is populated with each roles corresponding permissions. `PrivilegedUser` class extends existing User class (reuse existing code logic for managing users) and then add some additional methods specifically working with privileges. `Permission` class is to add and delete permissions. `Database` class to connect with database.

**Password**    Passwords are stored using 128-bit SHA512 algorithm. The algorithm is considered computationally expensive to brute-force password (in the event your database is compromised).

## How to Run Project

**1.**   Create empty database tables using `db/schema.sql` then insert values in `roles`, `permissions`, `role_perm` and `user_role` tables. Alternatively, sample working database tables are also available `db/schema-sample.sql`. 

**2.**   Run web server.  
    Usage:  `<path_to_php> -S <host>:<port> -t <docroot>`  
    Example:    `C:\php\php.exe -S 127.0.0.1:82 -t C:\role_based_access_control\ `

**3.**   Browser visit to [http://127.0.0.1:82](http://127.0.0.1:82).

--------------------------------------------------------------------

[1]: A. Rhodes and W. Caelli, "A Review Paper - Role Based Access Control", pp. 3-5.

## License

```The MIT License (MIT)
   
   Copyright (c) 2017 Hamza Rashid
   
   Permission is hereby granted, free of charge, to any person obtaining a copy of
   this software and associated documentation files (the "Software"), to deal in
   the Software without restriction, including without limitation the rights to
   use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
   the Software, and to permit persons to whom the Software is furnished to do so,
   subject to the following conditions:
   
   The above copyright notice and this permission notice shall be included in all
   copies or substantial portions of the Software.
   
   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
   FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
   COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
   IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
   CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```
