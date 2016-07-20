

#configuration:.
1.config/config.php set the database configuration and path configuration
2.asset/js/custom.js  set the base url
3.import the sql file into the db

#Some bugs :.
 1.No loading gif used for ajax reponse time so after click . 
 2.User does not validate that means multiple user with same name can be exist.
 3.Enter does not work login or registration time.
 4.Only login and registraion method of api are unit tested 
 5.Not all the db query are sql injection risk free 
 6.use default bootstrap theme 



#Not done:.
  1.Inline editing 

#Php Library used:. 
  1.Pdo (just for database handleing)


#Others:.
  1 used bootstrap 3 default theme.
  2.all javascript code in custom.js 

#How it works: 
	• User	registration with username	and	password
	• List	withall	tasks	created	by	the	current	user
	• Create	a	new	task	(only	for	the current	user)
	• Add	multiple	comments	for	a	single	task
	• Remove	a	single	comment	for	a	task
	• Mark	a	task	as	done
	• Remove	a	task,	if	it	has	no	comments
	• Parse	URLs	within	tasks	and	comments	so	they	become	clickable
  
