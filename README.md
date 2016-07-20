

#configuration:.
 • config/config.php set the database configuration and path configuration
 • asset/js/custom.js  set the base url
 • import the sql file into the db

#Some bugs :.
 • No loading gif used for ajax reponse time so after click . 
 • User does not validate that means multiple user with same name can be exist.
 • Enter does not work login or registration time.
 • Only login and registraion method of api are unit tested 
 • Not all the db query are sql injection risk free 
 • use default bootstrap theme 



#Not done:.
  •Inline editing 

#Php Library used:. 
  •Pdo (just for database handleing)


#Others:.
  • used bootstrap 3 default theme.
  • all javascript code in custom.js 

#How it works: 
	• User	registration with username	and	password
	• List	withall	tasks	created	by	the	current	user
	• Create	a	new	task	(only	for	the current	user)
	• Add	multiple	comments	for	a	single	task
	• Remove	a	single	comment	for	a	task
	• Mark	a	task	as	done
	• Remove	a	task,	if	it	has	no	comments
	• Parse	URLs	within	tasks	and	comments	so	they	become	clickable
  
