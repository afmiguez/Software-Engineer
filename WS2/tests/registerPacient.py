""" @package registerPacient.py
    This code would automate a pacient register at the webservice 2
"""

from selenium import webdriver
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.by import By

"""Create a Firefox browser instance."""
driver = webdriver.Firefox()

"""Open the url of of the webservice 2 register pacient interface."""
driver.get("http://192.168.163.128/ES-Project/WS2/interfacePacient.php")

f = open('pacient.txt', 'r')
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
	
