# ConceptHack: Hiring Task

## How it is initiated
- First, I took boilerplate from [repository](https://gitlab.com/sifvahora17/concepthackcandidates/-/tree/main)
- A template and blade file created based on requirement to import an excel file. 
- Then several migrations created for ___Exam___ and ___Question___ along with has many relationship.

## Library used
- [Maatwebsite/Excel package (v 3.1)](https://docs.laravel-excel.com/3.1/getting-started/installation.html) 
- [jQuery (v 3.6.0)](https://jquery.com/download/)
- [jQuery Validation Plugin (v 1.19.3)](https://jqueryvalidation.org/)

## Implementation 
- Validated input file to be valid excel file with extension ___XLS___ or ___*XLSX___
- Row wise validation for each row in import process to have several fields required. 
- If data or file is not validated, it does not import excel file and redirects back on import screen and shows all errors here.
- If validation passes, process to import data begins.
- This process is performed in following way:
    - First it checks if a user exists with given username or not. If user does not exist, it creates a new user or else, it gets ID of that user.
    - Then, it checks for exam. If for a day, there is no exam defined for student, it considers it as a new exam. 
    - For question and options, it finds or create a question along with options given. First option is mandatory here to have data. For rest of options, data is optional. All options are merged as a single JSON array to store all options.
    - After this, at the end, we store question id and exam id in a pivot table created to specify has many relationships between exam and question tables.

## Commands required for implementation
```
cd existing_repo
git checkout main
git pull origin
sudo cp .env.example .env

___configure your database credentials into .env file and then proceed for further commands given below___

php artisan key:generate
php artisan migrate
```
Once you are done with all above commands, you can serve the application.
The link for import page is available by clicking on `Import` button on home page. 


## Time for implementation
It took 7 hours for me to setup, integrate libraries and implement this. 

## Task Rate
As per time I took and implemented this, I would rate it at level score of `3.5`. 


> Thank you<br /> Maulik Shah
