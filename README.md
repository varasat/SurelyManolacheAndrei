# SurelyManolacheAndrei

##Documentation 
### Setup 
- Download this git repository
- Setup Symfony 3.4 : I included the symfony install file for ease of use
- open a console and navigate to the /my_coding_test folder
- run php bin/console server:run and the coding test should be present at http://localhost:8000/

- use the SQL dump in symfony_test_database.sql to create the database
- edit the database details in parameters.yml accordingly 

### Task assigned and how it was tackled 
Build a "To Do List" sample application using the Symfony framework that can list, add, edit and delete "To Do" list items. Include an item description and due date fields as a minimum.

To simplify the understanding of this documentation I will refer to items on the To do list as reminders

The following technology stack was used : 
- Symfony forms alongside twig folders : The ease of use of symfony forms justified this choice
- Symfony controller and service : To make the code more readable, to adhere to best practices and to have an all around coherent codebase
- MySQL database 

Version of Symfony used : 3.4

The reminder object is composed of the following: 
- id : an identification field 
- comment : the action needed to be taken by the user
- deadline : the deadline for which the action must be taken
- date_posted : the day the reminder was created. This is mostly for logging purposes

Due to some time constraints there are still improvements that can be done to this project. 
We can : 
- generalize the form creator to be used for the Edit and Create actions
- Add some JS/CSS to the listing to allow multiple types of ordering dependent on the header clicked (e.g. order by id/deadline etc)
- create proper ORM XML mappings, repositories and abstract classes for the Reminders 
- use grunt to manage the CSS and JS 


 

Share your solution using a GitHub or BitBucket repo for review”