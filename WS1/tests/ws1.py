""" @package interface.py
    This code would automate an insertion at the webservice1
"""

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By
import random
import mysql.connector

#connection to the VM database
cnx = mysql.connector.connect(user='afmiguez', password='12345',
                              host='192.168.163.128',
                              database='es-project')

cur = cnx.cursor() 

query ="truncate user"

#truncate user table
cur.execute(query,())

query ="truncate activity"

#truncate activity
cur.execute(query,())

							  
cnx.close()

"""Create a Firefox browser instance."""
driver = webdriver.Firefox()

"""Open the url of of the webservice1 register interface."""
driver.get("http://192.168.163.128/ES-Project/WS1/interface.php")

f = open('users2.txt', 'r')

tokens=[]
username=[]
activity=[]

count=0
#loop for insert all users in the webservice 1
for line in f:
	array=line.split(" ")
	
	inputElement = driver.find_element_by_name("firstname")
	inputElement.send_keys(array[0])

	inputElement = driver.find_element_by_name("lastname")
	inputElement.send_keys(array[1])
	
	inputElement = driver.find_element_by_name("username")
	inputElement.send_keys(array[2])
	
	inputElement = driver.find_element_by_name("birthdate")
	inputElement.send_keys(array[3])
	
	if array[4]=="m\n":
		driver.find_element_by_xpath("//input[@name='gender'][@value='m']").click()
	else:
		driver.find_element_by_xpath("//input[@name='gender'][@value='f']").click()
	
	driver.find_element_by_id("submit").click()
	
	result=driver.find_element_by_xpath("//pre").text
	#if error message is not shown, will get username and the generated token
	if result!= "could not register":
		username.append(array[2])
		tokens.append(result)
		
		count+=1

if count==len(username):
	print ('register user test is ok')
else:
	print('register user test failed')

#open the insert activity interface
driver.get("http://192.168.163.128/ES-Project/WS1/insertActivity.php")

#array for test activities
activity=[]
activity.append("ginasio")
activity.append("dorme")
activity.append("teste")


activityArray=[]

#counter for insertion test
count=0
#loop for activity insertion
for i in range(len(username)):
	year=random.randint(2010,2014)
	month=random.randint(1,12)
	day=random.randint(1,28)
	hour=random.randint(0,23)
	minute=random.randint(0,59)
	#formats to date
	start="{}-{}-{}-{}-{}".format(year,month,day,hour,minute)
	end=start
	
	index=random.randint(0,len(activity)-1)
	
	inputElement = driver.find_element_by_name("username")
	inputElement.send_keys(username[i])
	
	inputElement = driver.find_element_by_name("start")
	inputElement.send_keys(start)
	
	inputElement = driver.find_element_by_name("end")
	inputElement.send_keys(end)
	
	inputElement = driver.find_element_by_name("name")
	inputElement.send_keys(activity[index])
	
	activityArray.append(activity[index])
	
	inputElement = driver.find_element_by_name("token")
	inputElement.send_keys(tokens[i])
	
	driver.find_element_by_id("submit").click()
	
	result=driver.find_element_by_xpath("//pre").text
	if result== "activity successfully inserted":
		count+=1

if count==len(username):
	print ('insertion activity test is ok')
else:
	print('insertion activity test failed')
	
driver.get("http://192.168.163.128/ES-Project/WS1/query.php")

test=True
for i in range(len(username)):
	inputElement = driver.find_element_by_name("username")
	inputElement.send_keys(username[i])

	inputElement = driver.find_element_by_name("name")
	inputElement.send_keys(activityArray[i])
	
	inputElement = driver.find_element_by_name("token")
	inputElement.send_keys(tokens[i])

	driver.find_element_by_id("submit").click()
	
	result=driver.find_element_by_xpath("//pre").text
	if "token is invalid" in result or "invalid token" in result or "There's no activity with that name" in result:
		test=False
		break

if test:
	print ('query test is ok')
else:
	print('query test failed')
	
print ('forcing an error at query')

inputElement = driver.find_element_by_name("username")
inputElement.send_keys(username[0])

inputElement = driver.find_element_by_name("name")
inputElement.send_keys(activityArray[1])

inputElement = driver.find_element_by_name("token")
inputElement.send_keys(tokens[1])

driver.find_element_by_id("submit").click()

result=driver.find_element_by_xpath("//pre").text
print (result)


#connection to the VM database
cnx = mysql.connector.connect(user='afmiguez', password='12345',
                              host='192.168.163.128',
                              database='ws2')

cur = cnx.cursor() 

query ="truncate pacient"

#truncate pacient table
cur.execute(query,())

query ="truncate caretaker"

#truncate caretaker table
cur.execute(query,())

cur = cnx.cursor() 

query ="truncate pacient_info"

#truncate pacient_info table
cur.execute(query,())

query ="truncate authorization"

#truncate authorization table
cur.execute(query,())
							  
cnx.close()

driver.get("http://192.168.163.128/ES-Project/WS2/interfacePacient.php")

pacientTokens=[]
pacientUsernames=[]

f = open('users2.txt', 'r')
for line in f:
	array=line.split(" ")
	
	inputElement = driver.find_element_by_name("firstname")
	inputElement.send_keys(array[0])

	inputElement = driver.find_element_by_name("lastname")
	inputElement.send_keys(array[1])
	
	inputElement = driver.find_element_by_name("username")
	inputElement.send_keys(array[2])
	
	inputElement = driver.find_element_by_name("birthdate")
	inputElement.send_keys(array[3])
	
	if array[4]=="m\n":
		driver.find_element_by_xpath("//input[@name='gender'][@value='m']").click()
	else:
		driver.find_element_by_xpath("//input[@name='gender'][@value='f']").click()
	
	driver.find_element_by_id("submit").click()
	
	result=driver.find_element_by_xpath("//pre").text
	#print ('teste interfacePacient:'+result)
	#if error message is not shown, will get username and the generated token
	if result!= "could not register":
		pacientUsernames.append(array[2])
		pacientTokens.append(result)
		count+=1

driver.get("http://192.168.163.128/ES-Project/WS2/interfaceCaretaker.php")
f = open('caretakers2.txt', 'r')

caretakerTokens=[]
caretakerUsernames=[]

for line in f:
	array=line.split(" ")
	
	inputElement = driver.find_element_by_name("firstname")
	inputElement.send_keys(array[0])

	inputElement = driver.find_element_by_name("lastname")
	inputElement.send_keys(array[1])
	
	inputElement = driver.find_element_by_name("username")
	inputElement.send_keys(array[2])
	
	inputElement = driver.find_element_by_name("birthdate")
	inputElement.send_keys(array[3])
	
	if array[4]=="m\n":
		driver.find_element_by_xpath("//input[@name='gender'][@value='m']").click()
	else:
		driver.find_element_by_xpath("//input[@name='gender'][@value='f']").click()
	
	driver.find_element_by_id("submit").click()
	
	result=driver.find_element_by_xpath("//pre").text
	
	#print ('teste interfaceCaretaker:'+result)
	#if error message is not shown, will get username and the generated token
	if result!= "could not register":
		caretakerUsernames.append(array[2])
		caretakerTokens.append(result)
		count+=1

nikeUrl="https://api.nike.com/v1/me/sport/activities?startDate=2012-01-01&count=5&endDate=2015-02-01&offset=1&access_token=zG8Uq1ldSwAFv9QWbPZ7fFnthMnh"
ws1Url="http://localhost/ES-Project/WS1/class.webservice.php"

driver.get("http://192.168.163.128/ES-Project/WS2/interfaceInsertInfoLocation.php")

#começa primeira inserção
inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[0])

inputElement = driver.find_element_by_name("pacientToken")
inputElement.send_keys(pacientTokens[0])

inputElement = driver.find_element_by_name("wsUsername")
inputElement.send_keys(username[0])

inputElement = driver.find_element_by_name("wsToken")
inputElement.send_keys(tokens[0])

inputElement = driver.find_element_by_name("activityName")
inputElement.send_keys('corre')

inputElement = driver.find_element_by_name("url")
inputElement.send_keys(nikeUrl)

driver.find_element_by_id("submit").click()
#termina primeira inserção

#começa segunda inserção
inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[1])

inputElement = driver.find_element_by_name("pacientToken")
inputElement.send_keys(pacientTokens[1])

inputElement = driver.find_element_by_name("wsUsername")
inputElement.send_keys(username[1])

inputElement = driver.find_element_by_name("wsToken")
inputElement.send_keys(tokens[1])

inputElement = driver.find_element_by_name("activityName")
inputElement.send_keys(activityArray[1])

inputElement = driver.find_element_by_name("url")
inputElement.send_keys(ws1Url)

driver.find_element_by_id("submit").click()
#termina segunda inserção

result=driver.find_element_by_xpath("//pre").text
print ('teste interfaceInsertInfoLocation:'+result)

driver.get("http://192.168.163.128/ES-Project/WS2/interfaceAuthorizeCaretaker.php")

#começa primeira autorização
inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[0])

inputElement = driver.find_element_by_name("token")
inputElement.send_keys(pacientTokens[0])

inputElement = driver.find_element_by_name("activity")
inputElement.send_keys('corre')

inputElement = driver.find_element_by_name("caretaker")
inputElement.send_keys(caretakerUsernames[0])

driver.find_element_by_id("submit").click()
#termina primeira autorização

#começa segunda autorização
inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[1])

inputElement = driver.find_element_by_name("token")
inputElement.send_keys(pacientTokens[1])

inputElement = driver.find_element_by_name("activity")
inputElement.send_keys(activityArray[1])

inputElement = driver.find_element_by_name("caretaker")
inputElement.send_keys(caretakerUsernames[0])

driver.find_element_by_id("submit").click()

#termina segunda autorização

result=driver.find_element_by_xpath("//pre").text
print ('teste interfaceAuthorizeCaretaker:'+result)


driver.get("http://192.168.163.128/ES-Project/WS2/interfaceAccessInfo.php")
		
#começa a primeira consulta
inputElement = driver.find_element_by_name("caretaker")
inputElement.send_keys(caretakerUsernames[0])

inputElement = driver.find_element_by_name("token")
inputElement.send_keys(caretakerTokens[0])

inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[0])

inputElement = driver.find_element_by_name("activity")
inputElement.send_keys('corre')

driver.find_element_by_id("submit").click()

result=driver.find_element_by_xpath("//pre").text
print ('teste interfaceAccessInfo:'+result)
#termina a primeira consulta

#começa a segunda consulta
inputElement = driver.find_element_by_name("caretaker")
inputElement.send_keys(caretakerUsernames[0])

inputElement = driver.find_element_by_name("token")
inputElement.send_keys(caretakerTokens[0])

inputElement = driver.find_element_by_name("pacient")
inputElement.send_keys(pacientUsernames[1])

inputElement = driver.find_element_by_name("activity")
inputElement.send_keys(activityArray[1])

driver.find_element_by_id("submit").click()
#termina a segunda consulta

result=driver.find_element_by_xpath("//pre").text
print ('teste interfaceAccessInfo:'+result)